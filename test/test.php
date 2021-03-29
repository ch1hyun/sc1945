<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="utf-8">
    <title>TEST</title>
    <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      header("Content-Type: text/html; charset=UTF-8");

      include "class.sms.php" or die("HERE");
      $hp_num = "01028052511";
      $callback = "01028052511";
      $msg = "테스트";
      $result = sendSMS($hp_num, $callback, $msg, $err_msg);
      
      if ($result < 0) {
	      echo $err_msg;
      } else {
	      echo "성공 (".$result."건)<br>";

	      if($err_msg) {
		      $result = sendSMS($err_msg, $callback, $msg, $err_msg);
	      }
      } 
      }
    ?>
  </head>
  <body>
    <form method='POST'>
      수신 번호 : <input type="text" name="p_num"><br>
      발신 번호 : <input type="text" name="cb"><br>
      메세지 : <input type="text" name="msg"><br>
      <button type="submit" role="button">전송</button>
    </form>
  </body>
</html>
