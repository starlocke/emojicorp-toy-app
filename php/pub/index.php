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
    <script src="https://cdn.jsdelivr.net/npm/emojione@3.1.2/lib/js/emojione.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emojione@3.1.2/extras/css/emojione.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="emo.js"></script>
  </head>
  <body>
    <p>Page: <?= $page ?></p>
    <div>
      <hr />
      <h1>Post to BBS</h1>
      <form method="POST" action="api.php">
        <div>
          <label for="message">Message</label><br />
          <textarea name="message" id="message"></textarea>
        </div>
        <div>
          <label for="key">Emoji Key:</label><br />
          <input name="key" id="key" type="text" />
        </div>
        <div>
          <p>Poor Man's Emoji Pad</p>
          <table>
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
          <button type="submit">Submit</button>
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
