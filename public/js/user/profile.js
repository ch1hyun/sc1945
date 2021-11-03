function clickResetBtn() {
	$('#resetPw').fadeOut('slow');
	$('#resetPwBox').delay(600).fadeIn('slow');
}

function checkPwMatch() {
	if ($('#resetPassword1') === "" || $('#resetPassword1').val() !== $('#resetPassword2').val()) {
		$('#resetPwSend').attr("disabled", true);
	} else {
		$('#resetPwSend').attr("disabled", false);
	}
}

function resetPassword() {
	let cpw = $('#currentPassword').val();
	let pw = $('#resetPassword1').val();
	$.ajax({
		url: "/user/profile",
		type: "PUT",
		dataType: "JSON",
		data: {
			"cpw": cpw,
			"pw": pw,
			"target": "password"
		},
		success: function(json) {
			if (json.result === false && json.type === "currentPasswordNotMatched") {
				toastr["error"]("현재 비밀번호가 올바르지 않습니다.");
			} else {
				toastr["success"]("수정되었습니다.");
				$('#resetPwBox').fadeOut('slow');
				$('#resetPw').delay(600).fadeIn('slow').delay(600);
				$('#currentPassword').val("");
			}
			$('#resetPassword1').val("");
			$('#resetPassword2').val("");
	                        $('#resetPwSend').attr("disabled", true);
		},
		fail: function(xhr, status, errorThrown) {
			toastr["error"]("서버가 데이터를 처리하지 못했습니다. 새로고침을 해주세요. 계속해서 이 문제가 발생하면 관리자에게 문의하세요.");
		}
	})
}