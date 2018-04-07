<?php
namespace ETL\lib\emojicorp;
$page = \intval($_GET['page']);
$limit = 512;
$skip = $limit * $page;

$fetch = <<<EOT
SELECT BIN_TO_UUID(`uuid`) AS `uuid`, `time` FROM bbs ORDER BY `time` DESC
LIMIT {$limit} OFFSET {$skip}
EOT;

$db = new \mysqli("db", "emojiuser", "emojipass", "emojicorp"); // host, user, pass, db-schema
$res = $db->query($fetch);
$posts = [];
while($row = $res->fetch_assoc()){
  $posts[] = $row;
}
$res->free();

?>
<!doctype html>
<html lang=en>
  <head>
    <meta charset=utf-8>
    <title>Emojicorp</title>
    <script src="https://cdn.jsdelivr.net/npm/emojione@3.1.2/lib/js/emojione.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emojione@3.1.2/extras/css/emojione.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="emo.js"></script>
    <style>
      .posts td {
        font-family: monospace;
        border: 1px solid black;
        padding: 0.5em;
      }
      input {
        min-width: 256px;
      }
      textarea {
        min-width: 365px;
        min-height: 128px;
      }
      .padtab {
        font-size: 32px;
      }
    </style>
  </head>
  <body>
    <p>Page: <?= $page ?> (pagination is NOT implemented; simply limits to the latest 512 messages)</p>
    <hr />
    <table class="posts">
      <tbody>
<?php foreach($posts as $post): ?>
        <tr>
          <td><?= $post['uuid'] ?></td>
          <td><?= $post['time'] ?></td>
          <td><button class="read" data-uuid="<?= $post['uuid'] ?>">Read...</button></td>
        </tr>

<?php endforeach; ?>

      </tbody>
    </table>
    <div>
      <hr />
      <h1 id="read_heading">Read from BBS</h1>
      <form method="GET" action="read.php" class="read_form">
        <div>
          <label for="uuid">UUID:</label><br />
          <input name="uuid" id="uuid" type="text" />
        </div>
        <div>
          <label for="readkey">Emoji Key:</label><br />
          <input name="readkey" id="readkey" type="text" />
          <button class="read_convert">Convert Shortnames</button>
          <a href="shortcodes.html" target="shortcodes">List of shortcodes</a>
          <br />
          <em>- (this input is intended to be type="password", therefore, "seeing" emoji here is merely a convenience for this "toy" app)</em><br />
          <em>- (also, in a highly secured app, the form method would more likely be POST than GET; it is GET here for convenience of making things "visible")</em>
        </div>
        <div>
          <p>Poor Man's Emoji Pad (click to fill the key)</p>
          <table class="padtab">
            <tbody>
              <tr>
                <td class="emo readpad" data-value="😀">😀</td>
                <td class="emo readpad" data-value="🔥">🔥</td>
                <td class="emo readpad" data-value="🍄">🍄</td>
              </tr>
              <tr>
                <td class="emo readpad" data-value="🍍">🍍</td>
                <td class="emo readpad" data-value="⭐">⭐</td>
                <td class="emo readpad" data-value="🌊">🌊</td>
              </tr>
              <tr>
                <td class="emo readpad" data-value="🎨">🎨</td>
                <td class="emo readpad" data-value="✌️">✌️</td>
                <td class="emo readpad" data-value="🎩">🎩</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <button type="submit" class="read_form">Submit</button>
        </div>
      </form>
    </div>
    <div>
      <hr />
      <h1>Post to BBS</h1>
      <form method="POST" action="api.php" class="write_form">
        <div>
          <label for="message">Message</label><br />
          <textarea name="message" id="message"></textarea>
        </div>
        <div>
          <label for="key">Emoji Key:</label><br />
          <input name="key" id="key" type="text" /><br />
          <button class="read_convert">Convert Shortnames</button>
          <a href="shortcodes.html" target="shortcodes">List of shortcodes</a>
        </div>
        <div>
          <p>Poor Man's Emoji Pad (click to fill the key)</p>
          <table class="padtab">
            <tbody>
              <tr>
                <td class="emo pad" data-value="😀">😀</td>
                <td class="emo pad" data-value="🔥">🔥</td>
                <td class="emo pad" data-value="🍄">🍄</td>
              </tr>
              <tr>
                <td class="emo pad" data-value="🍍">🍍</td>
                <td class="emo pad" data-value="⭐">⭐</td>
                <td class="emo pad" data-value="🌊">🌊</td>
              </tr>
              <tr>
                <td class="emo pad" data-value="🎨">🎨</td>
                <td class="emo pad" data-value="✌️">✌️</td>
                <td class="emo pad" data-value="🎩">🎩</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <button type="submit" class="write_form">Submit</button>
        </div>
      </form>
      <hr />
      <div>
        <p>Emoji icons supplied by <a href="https://www.emojione.com">EmojiOne</a></p>
        <p class="emo">Made with ❤️ & ☮️ from Montreal</p>
      </div>
    </div>
  </body>
</html>
