<?php
namespace ETL\lib\emojicorp;
$page = \intval($_GET['page']);
$limit = 256;



?>
<!doctype html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <title>Emojicorp</title>
  </head>
  <body>
    <p>Page: <?= $page ?></p>
  </body>
</html>
