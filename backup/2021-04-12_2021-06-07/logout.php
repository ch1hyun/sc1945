<?php
session_start();
if ($_SESSION['flag']) {
	session_destroy();
	echo "<script>location.href='./';</script>";
} else {
	echo "<script>location.href='./';</script>";
}
?>
