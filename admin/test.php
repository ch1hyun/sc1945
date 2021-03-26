<!DOCTYPE html>
<html>
<head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$splitLine = explode("\n", $_POST['content']);
	$newContent = '';
	foreach ($splitLine as $line) {
		$newContent .= "<p>".trim($line)."</p>\n";
	}

	$fp = fopen("./test.txt", "w");
	fwrite($fp, $newContent);
	fclose($fp);
}
?>
</head>
<body>
<form method="POST">
<textarea cols="45" rows="16" name="content"></textarea><br>
<button type="submit" role="button">클릭!</button>
</form>
</body>
</html>
