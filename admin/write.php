<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="./css/main.css?after">
    <title>ADMIN</title>
    <?php
      session_start();
      if (!$_SESSION['flag'] && $_SESSION['flag'] !== 'logined') echo "<script>alert('Restricted Area');location.href='../';</script>";
      else {
    ?>
  <head>
  <body>
    <div id="container">
      <header>
        <h1>아래에 작성</h1>
      </header>
      <div id="content">
        <header>
          <pre>
&lt;p&gt;&lt;/p&gt; &lt;- 기본 문자
&lt;u&gt;&lt;/u&gt; &lt;- 밑줄
&lt;b&gt;&lt;/b&gt; &lt;- 강조
&lt;span class="imageblock"&gt;
  &lt;img src="" width="" height="" filename="" filemime="image/??"&gt;
&lt;/span&gt;
&lt;span class="videoblock"&gt;
  &lt;video controls width="374"&gt;
    &lt;source src="http://love.sc1945.xyz/assets/videos/???.mp4" type="video/mp4"&gt;
    Sorry, your browser doesn't support embedded videos.
  &lt;/video&gt;
&lt;/span&gt;
          </pre>
        </header>
        <form method="POST" action="./create.php">
          <fieldset>
            <div id="letter">
              <textarea cols="100" rows="30" name="content"></textarea><br>
            </div>
            <button type="submit" role="button">작성</button>
          </fieldset>
        </form>
        <button onclick="location.href='./'">뒤로가기</button>
      </div>
    </div>
  </body>
  <?php } ?>
</html>
