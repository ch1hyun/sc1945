<?php
  session_start();
if ($_SESSION['flag'] && $_SESSION['flag'] !== 'logined') {
	echo "<script>alert('login first');window.close();</script>";
}
  $prevPage = parse_url($_SERVER['HTTP_REFERER']);
  if ($prevPage['scheme']."://".$prevPage['host'].$prevPage['path'] !== "http://love.sc1945.xyz/view.php") {
	  echo "<script>alert('Invalid Connection');window.close();</script>";
  } else {
	  include "./config.php";
	  $cmtid = explode("-", $_GET['cmtid']);
	  $conn = db_connect();
	  $sql = "SELECT comment FROM l_cmt WHERE l_id=\"".$cmtid[0]."\" and idx=".$cmtid[1];
	  $currentText = mysqli_fetch_array(mysqli_query($conn, $sql))[0];
	  mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" media="screen" href="./assets/css/fix-comment.css?after">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="utf-8">
    <title>댓글 수정</title>
  </head>
  <body>
    <header>
      <h1 class="header_title">댓글 수정</h1>
    </header>
    <form class="comment_form" method="POST" action="./comment/fix.php">
      <fieldset>
        <input type="hidden" name="l_id" value="<?php echo $cmtid[0]; ?>">
        <input type="hidden" name="idx" value="<?php echo $cmtid[1]; ?>">
        <div class="wrap_content">
          <label class="screen_out" for="comment">내용</label>
	  <textarea id="comment" name="comment" cols="45" rows="9" placeholder="여기에 작성해주세요."><?php echo $currentText; ?></textarea>
        </div>
        <div class="wrap_btn">
          <button class="btn btn_reset" onclick="javascript:window.close()">창닫기</button>
          <button class="btn btn_reset" type="reset">취소</button>
          <button class="btn btn_submit" type="submit">확인</button>
        </div>
      </fieldset>
    </form>
  </body>
</html>
<?php } ?>
