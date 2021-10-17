<?php
include "./config.php";
$conn = db_connect();
$sql = "SELECT max(idx) FROM l_cmt WHERE l_id=\"9dcaa6bdb777af8072fec78c8dc7f4fe\"";
$r = mysqli_fetch_array(mysqli_query($conn, $sql))[0];
if (!$r) $r = 1;
echo $r;
mysqli_close($conn);
?>
