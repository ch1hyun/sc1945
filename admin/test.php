<!DOCTYPE html>
<html>
<head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$fp = fopen("./test.txt","w");
fwrite($fp, $_POST['content']."\n");
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
