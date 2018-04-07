<?php
namespace ETL\lib\emojicorp;

require_once('../lib/lib_emoji.php');

$key = emojiKey($_POST['key']);
$box = safeEncrypt($_POST['message'], $key);

echo "<pre>$box</pre><br />";

$user_message = safeDecrypt($box, $key);

$sanitized_message = htmlspecialchars($user_message, ENT_QUOTES, 'UTF-8');

echo "<pre>$sanitized_message</pre><br />";