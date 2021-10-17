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
			<p>히히 아메리칸 트레이에서 사용할 수 있는 머니쿠폰이에요!!</p>
			<p>사양말구 맛나게 먹어줘</p>
			<p>비플 제로페이에 등록해야 아메리칸 트레이에서 사용할 수 있오!!!</p>
		</div>
		<pre>
왕서희 님께 모바일 온누리상품권 30,000 원이 도착하였습니다.

★ 보내시는 분의 메시지
음하핫 맛나게 무그라!
- 오치현 -

▶ 선물 PIN 번호: 94721271
▶ 선물 등록 기간: ~ 2021-05-08
▶ 선물등록 가능 APP :
    PAYCO, 유비페이, 010제로페이, 비플 제로페이, BNK경남은행, 올원뱅크, 춘천사랑상품권, 뉴스마트뱅킹, 슬배생, 썸뱅크, 강원상품권, Finnq (핀크), 경남지역상품권, TEST(KSNET), 신한쏠(SOL), 체크페이, 누비전, 핀트(Fint), 전남사랑상품권, 우리 WON 뱅킹, 머니트리, 광주은행, 티머니페이, 시럽 월렛(Syrup Wallet), IM샵(#)
▶ 이용안내
 - 상품권의 PIN 번호를 등록하고 해당 상품권의 가맹점에서 사용할 수 있습니다.
 - 선물 등록기간이 종료되면 자동으로 발송인에게 회수됩니다.
 - 선물 등록 전에 발송인이 선물을 회수할 수 있습니다.
 - 일부 상품권의 경우, 월 선물 수령한도가 있을 수 있습니다.(수령한도 초과 시 등록불가)
 - 선물 받은 상품권의 환불 시 최초 구매자의 구매일/지원금 기준으로 환불됩니다. 단, 최초 구매자가 법인인 경우 미사용 환불은 불가하고, 잔액 환불은 개별 상품권 정책에 따라 결정됩니다.
 - 유효기간 만료 후 결제 취소 불가합니다. 
 - 선물받은 PIN 번호는 타인에게 양도가 불가 합니다.

▶ 상품권 이용방법 상세 안내
1. 선물등록방법 : 문자 수신 PIN 번호 확인 &gt; 등록 가능 앱 확인 실행(설치/가입필수) &gt; 제로페이 모바일상품권 메뉴 선택 &gt; 선물/쿠폰 등록 메뉴 선택 or 선물함에서 선물등록 선택 &gt; PIN 번호 입력 &gt; 선물등록 완료
2. 상품권사용하기 : 앱 실행 &gt; 제로페이 모바일상품권 메뉴 선택 &gt; 구매한 상품권 및 금액 확인 &gt; 결제하기 메뉴 선택 &gt; 거래승인번호 입력 &gt; QR 결제 또는 바코드 결제 
3. 가맹점 찾기 및 제로페이 모바일상품권 추가 정보 확인 : 제로페이 모바일상품권 홈페이지에서 확인 

▶ 상품권 이용 문의 : 제로페이 고객센터 1670-0582
		</pre>
		<br><button onclick="window.close()" role="button">창닫기</button>
	</body>
	<?php
			}
	?>
</html>
