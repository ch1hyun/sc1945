<?php
session_start();
if (!$_SESSION['flag'] || $_SESSION['flag'] !== 'logined') {
	echo "<script>alert('Restricted area');window.close();</script>";
} else {
	$locate = "../letters/";

	$fp_list = fopen($locate."1111check.txt", "r");
	$set_time = "2021-04-12 09:00:00";
	$index = 1;

	while (!feof($fp_list)) {
		$line_list = fgets($fp_list);
		$line_md5 = explode("  ==>  ", $line_list)[1];
		$line_file = fopen($locate.trim($line_md5).".txt", "r");
		fgets($line_file);
		$lines = "";

		while (!feof($line_file)) {
			$lines .= fgets($line_file);
		}

		fclose($line_file);

		$line_file = fopen($locate.trim($line_md5).".txt", "w");
		fwrite($line_file, date("Y-m-d H:i:s", strtotime("+".$index." days", strtotime($set_time))));
		fwrite($line_file, $lines);
		fclose($line_file);

		$index++;
	}

	fclose($fp_list);

	echo "<script>alert('Done!');window.close();</script>";
}
?>
