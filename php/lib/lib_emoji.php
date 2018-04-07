<?php
namespace ETL\lib\emojicorp;

/**
 * Pads a string so that it provides enough bytes to the Sodium encrypt function
 */
function emojiKey($emos){
    $len = strlen($emos);
    $pad = '';
    for($i = $len; $i < SODIUM_CRYPTO_SECRETBOX_KEYBYTES; ++$i){
        $pad .= $i % 9;
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
