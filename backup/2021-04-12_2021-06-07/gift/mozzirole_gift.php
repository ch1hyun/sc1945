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
			<p>GS25 초코 모찌롤이 기프트콘으로 없더라구 ㅜㅜ 머니쿠폰으로 먹어요오!! 다른거두 괜차나 히히</p>
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
