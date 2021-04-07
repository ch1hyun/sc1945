<!DOCTYPE html>
<html>
	<head>
		<title>For you</title>
		<?php
			session_start();
			if (!$_SESSION['flag'] || $_SESSION['flag'] !== 'logined') {
				echo "<script>alert('Restricted area');window.close();</script>";
			} else {
		?>
        </head>
<style>
#explain {
	border: 1px solid red;
	border-radius: 5px;
	padding: 6px;
}
img {
	width: 100%;
}
</style>
		<title>선물♥</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta charset="utf-8">
	</head>
	<body>
		<div id="explain">
			<p>페로로로쉐에요! 맛있게 먹어줘요</p>
			<p>사진 클릭 -&gt; 다음에서 열기 클릭 -&gt; 서히 자신에게 카톡으로 보내기</p>
		</div>
		<a href="http://love.sc1945.xyz/assets/images/mozzirole_gift.jpg" download>
			<img src="http://love.sc1945.xyz/assets/images/mozzirole_gift.jpg">
		</a>
		<br><button onclick="window.close()" role="button">창닫기</button>
	</body>
	<?php
			}
	?>
</html>
