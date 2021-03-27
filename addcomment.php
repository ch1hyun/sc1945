<?php
session_start();
if ($_SESSION['flag'] && $_SESSION['flag'] === 'logined' && $_SERVER['REQUEST_METHOD'] === 'POST') {
	if (preg_match("/\.\./", $_GET['view_n'])) echo "<script>alert('Invalid arguments');history.go(-1);</script>";
	include "./config.php";
	$conn = db_connect();
	$vn = mysqli_real_escape_string($conn, $_GET['view_n']);
	$pt_temp = explode("\n", $_POST['comment']);
	$pt = '';
	foreach($pt_temp as $line) {
		$pt .= trim(mysqli_real_escape_string($conn, $line))."<br>";
	}
	$sql = "SELECT MAX(idx) FROM l_cmt WHERE l_id = \"".$vn."\"";
	$result = mysqli_fetch_array(mysqli_query($conn, $sql))[0];
	if (!$result) $result = 1;
	$sql = "INSERT INTO l_cmt VALUES(\"".$vn."\", ".($result + 1).", now(), \"".$pt."\")";
	mysqli_query($conn, $sql);
	mysqli_close($conn);
	echo "<script>location.href=\"./view.php?view_n=".$_GET['view_n']."\";</script>";
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo "<script>alert(\"RESTRICTED AREA\");location.href='./';</script>";
}
?>
