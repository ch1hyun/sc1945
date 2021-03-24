<?php
session_start();
if (!$_SESSION['flag']) {
	echo "<script>alert('로그인을 먼저해주세요.');location.href='./';</script>";
} else {
	if ($_SERVER['HTTP_REFERER'] === "http://love.sc1945.xyz/comment/delete.php") echo "<script>alert('삭제했슴동!!');</script>";
	include "./config.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="./assets/js/view-page.js?after"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
    <link rel="stylesheet" href="./assets/css/main.css?after">
    <link rel="stylesheet" href="./assets/css/view-page.css?after">
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
	      if (preg_match("/\.\./", $_GET['view_n'] || !preg_match("/.txt/i", $_GET['view_n']))) die('허용되지 않은 파라미터 값입니다.');
	      $fp = fopen("./letters/".$_GET['view_n'].".txt", "r") or die('파일을 열 수 없습니다.');
	      $l_time = date("Y-m-d H:i", strtotime(trim(fgets($fp))));
	      if (date("Y-m-d H:i") < $l_time) {
		      fclose($fp);
		      die('편지가 아직 도착하지 않았습니다.');
	      }
	      $l_title = htmlentities(trim(fgets($fp)));
	      $content_l = "";
	      while (!feof($fp)) {
		      $content_l .= fgets($fp);
	      }
	      $conn = db_connect();
	      $vn = mysqli_real_escape_string($conn, $_GET['view_n']);
	      $sql = "SELECT l_view FROM l_view WHERE l_id = '".$vn."'";
	      $r = mysqli_fetch_array(mysqli_query($conn, $sql));
	      $r['l_view']++;
	      $sql = "UPDATE l_view SET l_view=".$r['l_view']." WHERE l_id='".$vn."'";
	      mysqli_query($conn, $sql);
	      mysqli_close($conn);
      ?>
        <div id="content-wrap">
          <header class="content-header">
            <div class="headline-wrap">
              <div class="headline">
                <h2 aria-live="polite"><?php echo $l_title; ?></h2>
              </div>
            </div>
            <div class="sub-headline">
              <p class="info"><?php echo $r['l_view']; ?></p>
              <p class="count"><?php echo $l_time; ?></p>
            </div>
          </header>
          <article id="article" aria-live="polite" class="margin">
	    <?php echo $content_l; ?>
            <p style="text-align: center; clear: none; float: none;">
              <br>
            </p>
            <p>
              - 치현이가 -
              <br>
            </p>
          </article>
        <div id="comments-cover">
          <div id="comments">
            <h4>댓글</h4>
            <button id="close-comment-control" class="no-text" style="display:none" aria-hidden="true">댓글 조절 메뉴 닫기</button>
            <?php
	      $conn = db_connect();
	      $vn = mysqli_real_escape_string($conn, $_GET['view_n']);
	      $sql = "SELECT * FROM l_cmt WHERE l_id=\"".$vn."\" ORDER BY idx ASC";
  	      $result = mysqli_query($conn, $sql);  
	      if (mysqli_num_rows($result) > 0) {
            ?>
            <ol>
              <li id="main-comment">
                <ul id="comment-wrap">
                <?php
  	        while ($r = mysqli_fetch_array($result)) {
			$crt_idx = $r['idx'];
			echo "<li id=\"comment".$r['l_id'].$r['idx']."\" class=\"sub-comment\">";
			echo "<div class=\"comment-balloon icon hidden-control\">";
			echo "<p class=\"comment-article\">".$r['comment']."</p>";
			echo "<div class=\"comment-info\">";
			echo "<div class=\"comment-username icon\">";
			echo "<span>귀염둥이 서히</span>";
			echo "</div>";
			echo "<div class=\"comment-date\">";
			echo "<span>".$r['c_time']."</span>";
			echo "</div>";
			echo "<div class=\"comment-control-toggle-wrap\">";
			echo "<button class=\"comment-control-toggle no-text icon fade-icon depth-icon\">메뉴 보기</button>";
			echo "</div>";
			echo "</div>";
			echo "<nav class=\"comment-control icon\" style=\"display:none\" aria-hidden=\"true\" role=\"menu\">";
			echo "<div role=\"menuitem\">";
			echo "<button onclick=\"deleteComment('".$r['l_id']."-".$r['idx']."'); return false;\" class=\"comment-control-button delete no-text icon fade-icon depth-icon\">수정 또는 삭제...</button>";
			echo "</div>";
			echo "<div role=\"menuitem\">";
			echo "<button onclick=\"fixComment('".$r['l_id']."-".$r['idx']."'); return false;\" class=\"comment-control-button modify no-text icon fade-icon depth-icon\">수정 또는 삭제...</button>";
			echo "</div>";
			echo "</nav>";
			echo "</div>";
			echo "</li>";
		}
		mysqli_close($conn);
                ?>
                </ul>
              </li>
            </ol>
            <?php } ?>
	    <form method="POST" action=<?php echo "./addcomment.php?view_n=".$_GET['view_n']; ?> style="margin:0;">
             <div id="cmtfm" class="comment-form ready empty">
              <div id="cmtfm-sub" class="comment-balloon icon">
                <label class="textarea-label icon" for="text" aria-label="댓글 입력">
                  여기를 눌러 댓글을 남겨주세요.
                </label>
                <div class="comment-form-wrap">
                  <textarea id="text" class="comment-textarea" name="comment" rows="2" cols="20" style="height:56px" aria-label="댓글 내용"></textarea>
                  <div class="comment-submit-wrap">
                    <button class="comment-submit no-text icon fade-icon depth-icon" type="submit" title="여기에 댓글을 등록합니다.">
                      등록하기
                    </button>
                    </div>
                  </div>
                </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php fclose($fp); }} ?>
      </div>
      <div id="btn-article"><a href="./" class="index-transparent-button no-text" role="button"></a></div>
    </div>
  </body>
</html>
