<?php
session_start();
$backAgain1 = "<script>alert('Invalid Connection');location.href='../';</script>";
$backAgain2 = "<script>alert('Can\'t find comment');location.href='../view.php?view_n=".$_POST['l_id']."';</script>";
$backAgain3 = "<script>location.href='../view.php?view_n=".$_POST['l_id']."';</script>";
if (!$_SESSION['flag'] || $_SESSION['flag'] !== 'logined') echo $backAgain1;
if (!preg_match("/=/", $_SERVER['HTTP_REFERER'])) echo $backAgain1;
$prevPage = explode("=", $_SERVER['HTTP_REFERER']);
if ($prevPage[0] !== "http://love.sc1945.xyz/view.php?view_n") echo $backAgain1; 
if ($_SERVER['REQUEST_METHOD'] === 'GET') echo $backAgain1;
include "../config.php";
$conn = db_connect();
$sql = "SELECT comment FROM l_cmt WHERE l_id=\"".$_POST['l_id']."\" and idx=".$_POST['idx'];
$result = mysqli_query($conn, $sql);
if (!$result) {
        echo $backAgain2;
        mysqli_close($conn);
} else {
        $sql = "DELETE FROM l_cmt WHERE l_id=\"".$_POST['l_id']."\" and idx=".$_POST['idx'];
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        echo $backAgain3;
}
?>
