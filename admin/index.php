<!DOCTYPE html>
<html>
  <head>
<?php
session_start();
if (!$_SESSION['flag'] && $_SESSION['flag'] !== 'logined') echo "<script>alert('Restricted Area');location.href='../';</script>";
else {
?>
    <link rel="stylesheet" type="text/css" href="./css/main.css?after">
    <title>ADMIN</title>
  </head>
  <body>
    <div id="container">
    <header>
      <h1>어드민 페이지</h1>
    </header>
    <div id="content">
    <ul>
<?php
	$fp = fopen("../letters/1111check.txt", "r") or die("파일을 열 수 없습니다.");
	while (!feof($fp)) {
		$splitLine = explode("  =>  ", fgets($fp));
		if (!strpos($splitLine[0], "letter")) continue;
		echo "<li><a href='./view.php?l_id=".$splitLine[1]."'>".$splitLine[0]."  =>  ".$splitLine[1]."</a></li>";
	}
	fclose($fp);
?>
    </ul>
    <button onclick="location.href='./write.php'">글쓰기</button>
    <button onclick="location.href='../'">홈으로</button>
    </div>
    </div>
  </body>
<?php
}
?>
</html>
