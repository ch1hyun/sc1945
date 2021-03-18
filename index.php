<?php
  ini_set("session.cache_expire", 10800);
  ini_set("session.gc_maxlifetime", 3600);
  session_start();
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <link rel="stylesheet" href="./assets/css/main.css?after">
    <?php
      if ($_SESSION['flag']) {
	      if ($_SESSION['flag'] === 'logined') {
    ?>
    <script src="./assets/js/main-time.js?after"></script>
    <script src="https://kit.fontawesome.com/ce9530ac1e.js" crossorigin="anonymous"></script>
    <?php }} ?>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta charset="utf-8">
    <title>From chyun</title>
  </head>
  <body>
  <div id="container">
    <div id="header">
    <?php
      if ($_SESSION['flag']) {
	      if ($_SESSION['flag'] === 'logined') {
    ?>
      <div class="time-cover">
        <div class="time">
          <span class="info" id = "time-title"></span>
	  <span id="days"></span><span class="sub">일</span>
          <span id="hours"></span><span class="sub">시</span>
	  <span id="minutes"></span><span class="sub">분</span>
          <span id="seconds"></span><span class="sub">초</span>
        </div>
      </div>
      <div id="mind-cover">
	<h2>마음만은 언제나 네 곁에 있어 ♥</h2>
      </div>
    <?php }} else { ?>
      <h1>로그인</h1>
    <?php } ?>
    </div>
  <div id="content">
    <?php
      if ($_SESSION['flag']) {
	      if ($_SESSION['flag'] === 'logined') {
    ?>
    <div id="w-list">
      <?php
        $l_path = './letters/';
	$next_flag = 0;
        include "./config.php";
        $conn = db_connect();
	if (!$_GET['page']) $_GET['page'] = 1 or die('여기!');
	$index = $_GET['page'] * 6 - 5;

	while ($_GET['page'] * 6 >= $index) {
		$t_name = $l_path."test".$index.".txt";
		if (!is_file($t_name)) {
			$next_flag = 1;
			mysqli_close($conn);
			break;
		} else {
			$fp = fopen($t_name, "r") or die("파일을 열 수 없습니다.");
			$l_time = date("Y-m-d H:i", strtotime(trim(fgets($fp))));
			if (date("Y-m-d H:i") < $l_time) {
				fclose($fp);
				mysqli_close($conn);
				$next_flag = 1;
				break;
			} else {
				$l_title= htmlentities(trim(fgets($fp)));
				$sql = "SELECT l_view FROM l_view WHERE l_id='".md5($t_name)."'";
				$r = mysqli_fetch_array(mysqli_query($conn, $sql));
				echo "<div class=\"index-list\">";
				echo "<div class=\"index-title-wrap\">";
				echo "<div class=\"index-title-contents\">";
				echo "<div class=\"index-title\"><h2><a href=\"./view.php?view_n=".$t_name."\">".$l_title."</a></h2></div>";
				echo "<div class=\"index-box\">";
				echo "<div class=\"index-sub\">";
				echo "<div class=\"index-info\"><div class=\"index-date\">".$l_time."</div></div>";
				echo "<p>치현이가 || ".$r['l_view']."</p>";
				echo "<div class=\"devided\"></div>";
				echo "</div>";
				echo "</div></div></div>";
				if ($r['l_view'] == 0) {
					echo "<div class=\"index-new\">N</div>";
				}
				echo "<a href=\"./view.php?view_n=".$t_name."\" class=\"index-transparent-button no-text\" role=\"button\">".$l_title."</a>";
				echo "</div>";
				fclose($fp);
			}
		}
		$index++;
	}
	mysqli_close($conn);
      ?>
        </div>
      </div>
      <?php
	$prev_page = $_GET['page'] - 1;
	$next_page = $_GET['page'] + 1;

	if ($next_flag == 0) {
		$t_num = $_GET['page'] * 6 + 1;
		$t_name = $l_path."test".$t_num.".txt";
		if (is_file($t_name)) {
			$fp = fopen($t_name, "r") or die("파일을 열 수 없습니다.");
			$l_time = date("Y-m-d H:i", strtotime(trim(fgets($fp))));
			fclose($fp);
			if (date("Y-m-d H:i") < $l_time) $next_flag = 1;
		}
	}

	if ($_GET['page'] == 1) {
		if ($next_flag == 1) {
			echo "<nav id=\"paging\" class=\"hide-all\">";
			echo "<button class=\"navigation-control no-text\">페이지 조절 버튼 보기</button>";
			echo "<ul>";
			echo "<li><a class=\"paging-prev no-more-prev no-text depth\" role=\"button\" aria-disabled=\"true\">최신</a></li>";
			echo "<li><a class=\"paging-next no-more-prev no-text depth\" role=\"button\" aria-disabled=\"true\">다음</a></li>";
			echo "</ul>";
			echo "</nav>";
		} else {
			echo "<nav id=\"paging\" class=\"hide-prev\">";
			echo "<button class=\"navigation-control no-text\">페이지 조절 버튼 보기</button>";
			echo "<ul>";
			echo "<li><a class=\"paging-prev no-more-prev no-text depth\" role=\"button\" aria-disabled=\"true\">최신</a></li>";
			echo "<li><a class=\"paging-next no-text depth\" href=\"?page=".$next_page."\" role=\"button\">다음</a></li>";
			echo "</ul>";
			echo "</nav>";
		}
	} else {
		if ($next_flag == 1) {
			echo "<nav id=\"paging\" class=\"hide-next\">";
			echo "<button class=\"navigation-control no-text\">페이지 조절 버튼 보기</button>";
			echo "<ul>";
			echo "<li><a class=\"paging-prev no-text depth\" href=\"?page=".$prev_page."\" role=\"button\">최신</a></li>";
			echo "<li><a class=\"paging-next no-more-prev no-text depth\" role=\"button\" aria-disabled=\"true\">다음</a></li>";
			echo "</ul>";
			echo "</nav>";
		} else {
			echo "<nav id=\"paging\" class=\"hide-prev\">";
			echo "<button class=\"navigation-control no-text\">페이지 조절 버튼 보기</button>";
			echo "<ul>";
			echo "<li><a class=\"paging-prev no-text depth\" href=\"?page=".$prev_page."\" role=\"button\">최신</a></li>";
			echo "<li><a class=\"paging-next no-text depth\" href=\"?page=".$next_page."\" role=\"button\">다음</a></li>";
			echo "</ul>";
			echo "</nav>";
		}
	}
      ?>
    </div>
    <?php }} else { ?>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
      <form id="lgn-fm" method="POST">
        <fieldset id="login_form">
          <div class="input_row">
            <span class="input_box">
              <input type="text" name="id" placeholder="아이디" maxlength="10" class="int"><br>
            </span>
            <button type="button" disabled title="delete" id="id_clear" class="wrg" style="display: block;">
              <span class="blind">삭제</span>
            </button>
          </div>
          <div class="input_row">
            <span class="input_box">
              <input type="password" name="pw" placeholder="비밀번호" maxlength="30" class="int"><br>
            </span>
            <button type="button" disabled title="delete" id="pw_clear" class="wrg" style="display: block;">
              <span class="blind">삭제</span>
            </button>
          </div>
          <input type="submit" title="로그인" alt="로그인" value="로그인" class="btn_global on" id= "lgn-btn">
        </fieldset>
      </form>
    </div>
  </div>
    <?php
      } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      if ($_POST['id'] && $_POST['pw']) {
		      if (($_POST['id'] === 'serah29' && $_POST['pw'] === 'iloveyouseoheesc1945') || ($_POST['id'] === 'serah29' && $_POST['pw'] === 'betapassword')) {
			      $_SESSION['flag'] = 'logined';
			      echo "<script>location.href='./'</script>";
		      } else {
			      echo "<script>alert('아이디 또는 비밀번호를 확인해주세요.');location.href='./';</script>";
		      }
	      }
      }
  }
?>
  </body>
</html>
