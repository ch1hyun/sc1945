<?php
/* 마지막 편지 번호 추출 로직 */
$fp = fopen("../letters/1111check.txt", "r");
$maxNum = 0;
while (!feof($fp)) { 
	$splitLine = explode("  =>  ", fgets($fp))[0];
	$num = intval(substr($splitLine, 0, strpos($splitLine, "letter210308")));
	if ($num > $maxNum) $maxNum = $num;
}
echo $maxNum;
fclose($fp);

/* 편지 추가 로직 */
$fp = fopen("../letters/1111check.txt", "a");
fwrite($fp, "2letter210308  =>  ewkfweflkwvwior\n");
fclose($fp);
?>
