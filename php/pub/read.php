<?php
namespace ETL\lib\emojicorp;

require_once('../lib/lib_emoji.php');
$ok = false;
try {
    $uuid = $_GET['uuid'];
    $key = emojiKey($_GET['readkey']);
    
    $read = <<<EOT
SELECT BIN_TO_UUID(`uuid`) AS `uuid`, `time`, `message` FROM bbs
WHERE `uuid` = UUID_TO_BIN(?)
EOT;
    
    $db = new \mysqli("db", "emojiuser", "emojipass", "emojicorp"); // host, user, pass, db-schema
    $stmt = $db->prepare($read);
    if($stmt === false){
        var_dump( $db->error );
        exit;
    }
    $stmt->bind_param('s', $uuid);
    $stmt->bind_result($uuid, $time, $box);
    $stmt->execute();
    $stmt->fetch(); // flush
    
    $user_message = safeDecrypt($box, $key);
    $sanitized_message = nl2br(htmlspecialchars($user_message, ENT_QUOTES, 'UTF-8'));
    $ok = true;
}
catch (\Exception $e){
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <title>Emojicorp</title>
  </head>
  <body>
    <h1>Read-a-message</h1>
    <hr />
<?php if($ok): ?>
    <p>Succesfully Unlocked!</p>
    <div style="background: #ccc; padding: 0.5em; margin: 0.5em;">
        <?= $sanitized_message ?>
    </div>
<?php else: ?>
    <p>Error!</p>
    <div style="background: #fcc; padding: 0.5em; margin: 0.5em;">
        <?= $error ?>
    </div>
<?php endif; ?>
    <hr />
    <a href="/">Return to home page</a>
  </body>
</html>