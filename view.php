<?php
session_start();
if (!$_SESSION['flag']) {
	echo "<script>alert('로그인을 먼저해주세요.');location.href='./';</script>";
} else {
	if ($_POST['comments']) {
		$c_fp = fopen("./letters/comments/".$_POST['file_n'], "a") or die('파일을 열 수 없습니다.');
		fwrite($c_fp, $_POST['comments']."\n");
		fwrite($c_fp, date("Y-m-d H:i:s")."\n");
		fclose($c_fp);
		echo "<script>history.go(-1);</script>";
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./assets/css/main.css?after">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>From chyun</title>
  </head>
  <body>
    <div class="container">
      <div class="content">
      <?php if (!$_GET['view_n']) { ?>
        <div class="cant-maching-title">NOTHING</div>
      <?php
      } else {
	      if (preg_match("/../", $_GET['view_n'] || !preg_match("/.txt/i", $_GET['view_n']))) die('허용되지 않은 파라미터 값입니다.');
	      $fp = fopen($_GET['view_n'], "r") or die('파일을 열 수 없습니다.');
	      $time_l = date("Y-m-d H:i:s", strtotime(trim(fgets($fp))));
	      if (date("Y-m-d H:i:s") < $l_time) {
		      fclose($fp);
		      die('편지가 아직 도착하지 않았습니다.');
	      }
	      $title_l = htmlentities(trim(fgets($fp)));
	      $content_l = "";
	      while (!feof($fp)) {
		      $content_l .= fgets($fp);
	      }
	      include "./config.php";
	      $conn = db_connect();
	      $sql = "SELECT l_view FROM l_view WHERE l_id = '".substr($_GET['view_n'], 0, 32)."'";
	      $r = mysqli_fetch_array(mysqli_query($conn, $sql));
	      $r['l_view']++;
	      $sql = "UPDATE l_view SET l_view=".$r['l_view']." WHERE l_id='".substr($_GET['view_n'], 0, 32)."'";
	      mysqli_query($conn, $sql);
	      mysqli_close($conn);
      ?>
        <div class="view-w-cover">
          <div class="view-w-header">
            <span id="view-w-title"><?php echo $title_l; ?></span>
            <span id="view-w-time">일시 : <?php echo $time_l; ?></span>
            <span id="view-w-view">조회수 : <?php echo $r['l_view']; ?></span>
          </div>
          <div class="view-w-body">
	    <span id="view-w-contents"><pre><?php echo $content_l; ?></pre></span>
          </div>
          <div class="btn"><&nbsp;<a href="#" onclick="location.href='./';">이전</a></div>
        </div>
        <div class="comments-cover cover-dft">
          <div class="comments-header">
            <p id="comments-title">Comments to chyun♥</p>
            <form method="POST">
              <fieldset class="comments-frm">
                <div class="comments-box">
                  <textarea class="form-control" name="comments" id="comments" cols="80" rows="4" placeholder="댓글을 작성해주세요.(최대 500글자)" value="" maxlength="500" required></textarea>
                  <input type="hidden" name="file_n" value=<?php echo $_GET['view_n']; ?>>
                </div>
                <button type="submit" class="btn btn-cmt">작성</button>
              </fieldset>
            </form>
          </div>
          <div class="comments-body">
          <?php
	      $cmts = fopen("./letters/comments/".$_GET['view_n'], "r") or die('파일을 열 수 없습니다.');
	      while (!feof($cmts)) {
		      echo "<p class='pre-cmts'><pre>";
		      echo fgets($cmts);
		      echo strtotime(trim(fgets($cmts)));
		      echo "</pre></p>";
	      }
	      fclose($cmts);
          ?>
          </div>
        </div>
      <?php fclose($fp); }} ?>
      </div>
    </div>
  </body>
</html>
