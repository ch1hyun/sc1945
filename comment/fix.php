<?php
session_start();
if (!$_SESSION['flag'] || $_SESSION['flag'] !== 'logined') echo "<script>alert('Invalid Connection');window.close();</script>";
if (!preg_match("/=/", $_SERVER['HTTP_REFERER'])) echo "<script>alert('Invalid Connection');window.close();</script>";
$prevPage = explode("=", $_SERVER['HTTP_REFERER']);
if ($prevPage[0] !== "http://love.sc1945.xyz/fixcmt.php?cmtid") echo "<script>alert('Invalid Connection');window.close();</script>";
if ($_SERVER['REQUEST_METHOD'] === 'GET') echo "<script>alert('Invalid Connection');window.close();</script>";
include "../config.php";
$conn = db_connect();
$sql = "SELECT comment FROM l_cmt WHERE l_id=\"".$_POST['l_id']."\" and idx=".$_POST['idx'];
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo "<script>alert('Can\'t find comment');window.close();</script>";
	mysqli_close($conn);
} else {
	$sql = "UPDATE l_cmt SET comment=\"".$_POST['comment']."\" WHERE l_id=\"".$_POST['l_id']."\" and idx=".$_POST['idx'];
	mysqli_query($conn, $sql);
	mysqli_close($conn);
	echo "<script>window.close();</script>";
}
?>
