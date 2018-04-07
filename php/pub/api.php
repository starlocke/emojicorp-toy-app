<?php
namespace ETL\lib\emojicorp;

require_once('../lib/lib_emoji.php');
require_once('../lib/lib_uuid.php');

try {
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
    $ok = $stmt->execute();
    if($ok){
        $stmt->fetch(); // flush
    }
    else {
        $error = "Something went wrong. Sorry.";
    }
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
    <h1>Write-a-message</h1>
    <hr />
<?php if($ok): ?>
    <p>Succesfully Recorded!</p>
    <div style="background: #ccc; padding: 0.5em; margin: 0.5em;">
        Message ID: <?= $uuid ?>
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
