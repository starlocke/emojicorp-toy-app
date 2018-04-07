<?php
namespace ETL\lib\emojicorp;

require_once('../lib/lib_emoji.php');
require_once('../lib/lib_uuid.php');

$key = emojiKey($_POST['key']);
$box = safeEncrypt($_POST['message'], $key);
$uuid = UUID::v4();

$insert = <<<EOT
INSERT INTO bbs (
    uuid,
    message,
    time
)
VALUES (
    UUID_TO_BIN( ? ),
    ?,
    NOW()
)
EOT;

$db = new \mysqli("db", "emojiuser", "emojipass", "emojicorp"); // host, user, pass, db-schema
$stmt = $db->prepare($insert);
if($stmt === false){
    var_dump( $db->error );
    exit;
}
$stmt->bind_param('ss', $uuid, $box);
$stmt->execute();
$stmt->fetch(); // flush

echo "<pre>{$uuid} -> {$box}</pre><br />";

// $user_message = safeDecrypt($box, $key);

// $sanitized_message = htmlspecialchars($user_message, ENT_QUOTES, 'UTF-8');

// echo "<pre>$sanitized_message</pre><br />";