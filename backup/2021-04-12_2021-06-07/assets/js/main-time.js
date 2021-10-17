function gt(time) {
	let m_format = 60 * 60;
	let h_format = m_format * 24;

	let day = parseInt(time / h_format);
	let hour = parseInt(time % h_format / m_format);
	let min = parseInt(time % m_format / 60);
	let sec = parseInt(time % 60);

	if (day < 10) {
		day = "0" + day;
	}
	if (hour < 10) {
	        hour = "0" + hour;
	}
	if (min < 10) {
	        min = "0" + min;
	}
	if (sec < 10) {
	        sec = "0" + sec;
	}

	return new Array(day, hour, min, sec);
}

function remaindTime() {
	let now = new Date();
	let enter = new Date(2021, 3, 12, 14, 00, 00);
	let suryo = new Date(2021, 4, 14, 14, 00, 00);
	let jadae = new Date(2021, 5, 8, 14, 00, 00);

	let nt = now.getTime();
	let et = enter.getTime();
	let st = suryo.getTime();
	let jt = jadae.getTime();

	let tt = document.getElementById('time-title');
	let t_fmt = null;

	if (nt < et) {
		tt.innerText = "입대까지 남은 시간";
		t_fmt = gt(parseInt(et - nt) / 1000);

	} else if (nt < st) {
		tt.innerText = "수료까지 남은 시간";
	        t_fmt = gt(parseInt(st - nt) / 1000);

	} else if (nt < jt) {
		tt.innerText = "자대배치까지 남은 시간";
		t_fmt = gt(parseInt(jt - nt) / 1000);

        } else {
		tt.innerText = "끝~! 기다리느라 수고많았어요 겸둥이 ♥";
	        t_fmt = new Array('00', '00', '00', '00');
	}

	document.getElementById('days').innerText = t_fmt[0];
	document.getElementById('hours').innerText = t_fmt[1];
	document.getElementById('minutes').innerText = t_fmt[2];
	document.getElementById('seconds').innerText = t_fmt[3];

}

setInterval(remaindTime, 1000);

