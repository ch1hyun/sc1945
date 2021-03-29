<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="./css/main.css?after">
    <title>ADMIN</title>
<?php
session_start();
if (!$_SESSION['flag'] && $_SESSION['flag'] !== 'logined') echo "<script>alert('Restricted Area');location.href='../';</script>";
else {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$fp = fopen("../letters/".$_POST['l_id'].".txt", "w");
		fwrite($fp, $_POST['content']."\n");
		fclose($fp);
		echo "<script>location.href='?l_id=".$_POST['l_id']."';</script>";
	} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$fp = fopen("../letters/1111check.txt", "r");
	while (!feof($fp)) {
		$line = trim(fgets($fp));
		if (strpos($line, $_GET['l_id'])) break;
	}
	fclose($fp);

	$splitLine = explode("  =>  ", $line);
?>
  </head>
  <body>
    <div id="container">
      <header>
        <h1>뷰 페이지</h1>
      </header>
      <div id="content">
        <div id="view-wrap">
          <div id="view">
            <div id="view-header">
              <span><?php echo $splitLine[0]; ?></span>
              <span>=<&gt;/span>
              <span><?php echo $splitLine[1]; ?></span>
            </div>
            <div id="view-body">
<?php
	if ($_GET['fix'] && $_GET['fix'] === 'yy') {
?>
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
&lt;span class="audioblock"&gt;
  &lt;audio controls src="http://love.sc1945.xyz/assets/audios/???.m4a"&gt;
    Your browser does not support the &lt;code&gt;audio&lt;/code&gt; element.
  &lt;/audio&gt;
&lt;/span&gt;
❤️
          </pre>
        </header>
<?php
		echo "<form method='post'>";
		echo "<input type=\"hidden\" name=\"l_id\" value=\"".$_GET['l_id']."\">";
                echo "<textarea cols=\"45\" rows=\"30\" width=\"100%\" height=\"100%\" name=\"content\">";
        }
	$fp = fopen("../letters/".$splitLine[1].".txt", "r");
	while (!feof($fp)) {
		echo fgets($fp);
	}
	fclose($fp);
	if ($_GET['fix'] && $_GET['fix'] === 'yy') {
		echo "</textarea>";
                echo "<button type=\"submit\" role=\"button\">확인</button>";
                echo "<button onclick=\"location.href='?l_id=".$_GET['l_id']."';\">취소</button>";
		echo "</form>";
        }
?>
            </div>
            <div id="view-footer">
<?php
	if (!$_GET['fix'] && $_GET['fix'] !== 'yy') {
?>
              <button onclick="location.href='./';">뒤로가기</button>
              <button <?php echo "onclick=\"location.href='?l_id=".$_GET['l_id']."&fix=yy';\""; ?>>수정</button>
<?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
<?php }} ?>
</html>
