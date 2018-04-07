<?php
namespace ETL\lib\emojicorp;

function validateKey($emos){
    $sequences = file(__DIR__.'/sequences.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $len = mb_strlen($emos);
    $seq = '';
    for($i = 0; $i < $len; ++$i){
        $chr = mb_substr($emos, $i, 1);
        $ord = mb_ord($chr, "UTF-8");
        $hex = strtoupper(dechex($ord));
        
        if(strlen($seq)){
            $next = $seq . ' ' . $hex;
        }
        else {
            $next = $hex;
        }

        if(in_array($next, $sequences)){
            // good
            $seq = $next;
        }
        elseif(in_array($hex, $sequences)) {
            // also good
            $seq = $hex;
        }
        else {
            if($i < $len){
                $i = $i + 1;
                $chr2 = mb_substr($emos, $i, 1);
                $ord2 = mb_ord($chr2, "UTF-8");
                $hex2 = strtoupper(dechex($ord2));
                $next2 = $next . ' ' . $hex2;
                if(in_array($next2, $sequences)){
                    // good
                    $seq = $next2;
                }
                else {
                    // bad
                    //echo "really bad next -- {$next2}<br />";
                    throw new \Exception("Unrecognized emoji sequence: {$next2}");
                }
        
            }
        }
        //echo "{$hex}<br />";
    }

    return true;
}

/**
 * Pads/Trims a key so that it provides enough bytes to the Sodium encrypt function
 */
function emojiKey($emos){
    @validateKey($emos);
    $len = strlen($emos);
    $pad = '';
    for($i = $len; $i < SODIUM_CRYPTO_SECRETBOX_KEYBYTES; ++$i){
        $pad .= $i % 9;
    }
    if($len > SODIUM_CRYPTO_SECRETBOX_KEYBYTES){
        return substr($emos, 0, SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
    }
    return $emos . $pad;
}
// Straight-up dumb copy of a generic encrypt/decrypt system.

/**
* Encrypt a message
* 
* @param string $message - message to encrypt
* @param string $key - encryption key
* @return string
*/
function safeEncrypt($message, $key)
{
    $nonce = random_bytes(
        SODIUM_CRYPTO_SECRETBOX_NONCEBYTES
    );

    $cipher = base64_encode(
        $nonce.
        sodium_crypto_secretbox(
            $message,
            $nonce,
            $key
        )
    );
    sodium_memzero($message);
    sodium_memzero($key);
    return $cipher;
}

/**
* Decrypt a message
* 
* @param string $encrypted - message encrypted with safeEncrypt()
* @param string $key - encryption key
* @return string
*/
function safeDecrypt($encrypted, $key)
{   
    $decoded = base64_decode($encrypted);
    if ($decoded === false) {
        throw new \Exception('Scream bloody murder, the encoding failed.');
    }
    if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
        throw new \Exception('Scream bloody murder, the message was truncated.');
    }
    $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
    $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

    $plain = sodium_crypto_secretbox_open(
        $ciphertext,
        $nonce,
        $key
    );
    if ($plain === false) {
         throw new \Exception('The message was tampered with in transit, assuming you gave the right key.');
    }
    sodium_memzero($ciphertext);
    sodium_memzero($key);
    return $plain;
}
