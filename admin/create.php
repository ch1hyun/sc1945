<?php
session_start();
if (!$_SESSION['flag'] && $_SESSION['flag'] !== 'logined') echo "<script>alert('Restricted Area');location.href='../';</script>";
if ($_SERVER['REQUEST_METHOD'] === 'GET') echo "<script>alert('No GET method');location.href='../';</script>";
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fp = fopen("../letters/1111check.txt", "r");
	$maxNum = 0;
	while (!feof($fp)) {
		$splitLine = explode("  =>  ", fgets($fp))[0];
	        $num = intval(substr($splitLine, 0, strpos($splitLine, "letter210308")));
	        if ($num > $maxNum) $maxNum = $num;
	}
	fclose($fp);

	$maxNum++;
	$new_name = $maxNum."letter210308";
	$new_l_id = md5($new_name);

	$fp = fopen("../letters/1111check.txt", "a");
	fwrite($fp, $new_name."  =>  ".$new_l_id."\n");
	fclose($fp);

	$content = explode("\n", $_POST['content']);
	$newContent = '';

	foreach($content as $line) {
		if ($content[0] == $line || $content[1] == $line) {
			$newContent .= $line;
			continue;
		}
		if (preg_match("/<p>|span|imageblock|img|source|browser|vedio|vedioblock/i", $line)) {
			$newContent .= trim($line)."\n";
		} else {
			$newContent .= "<p>".trim($line)."</p>\n";
		}
	}

	$fp = fopen("../letters/".$new_l_id.".txt", "w");
	fwrite($fp, $newContent);
	fclose($fp);

	include "../config.php";

	$conn = db_connect() or die('DB 연결 실패');
	$sql = "INSERT INTO l_view VALUES(\"".$new_l_id."\", 0)";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	echo "<script>alert('글 작성 완료!');location.href='./';</script>";
}
else echo "<script>alert('Restricted Area');location.href='../';</script>";
?>
