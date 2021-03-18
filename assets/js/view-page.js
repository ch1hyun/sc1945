window.onload = function () {
	var body = document.querySelector("body");
	var cmtfm = document.getElementById("cmtfm-sub");
	var btn_toggles = document.querySelectorAll(".comment-control-toggle");

	body.addEventListener("click", clickBodyEvent);
	cmtfm.addEventListener("click", function(){setClassName("cmtfm", 'comment-form empty');});
	cmtfm.addEventListener("keyup", texton);

	for (var i = 0; i<btn_toggles.length; i++) {
		btn_toggles[i].addEventListener("click", fixthings);
	}
}

function clickBodyEvent(event) {
	var target = event.target;
	// console.log(target);
	var ct = event.currentTarget.querySelector(".comment-form").querySelector(".comment-balloon");
	if(target == ct)
		return;

	var divs = ct.querySelectorAll("div");
        for (var i = 0; i< divs.length; i++) {
		if (divs[i] == target) return;
	}

	if(target == ct.querySelector(".textarea-label"))
		return;
	
	if(target == ct.querySelector(".comment-form-wrap").querySelector("textarea"))
		return;

	if(target == ct.querySelector(".comment-form-wrap").querySelector(".comment-submit-wrap").querySelector("button"))
		return;

	setClassName("cmtfm", 'comment-form ready empty');
}

function setClassName(arg1, arg2) {
	var ctm = document.getElementById("text");

	if(!ctm.value) {
		document.getElementById(arg1).className = arg2 + " animation";
		var to = setTimeout(function () {
			document.getElementById(arg1).className = arg2;
			clearTimeout(to);
		},500);
	}
}

function texton(event) {
	var ctm = document.getElementById("text");

	if(!ctm.value) {
		var body = document.querySelector("body");
		event.preventDefault();
		body.addEventListener("click", clickBodyEvent);
		document.getElementById("cmtfm").className = "comment-form empty";
	} else {
		var body = document.querySelector("body");
		body.removeEventListener("click", clickBodyEvent);
		document.getElementById("cmtfm").className = "comment-form";
	}
}

function fixthings(event) {
	var current_name = event.currentTarget.parentNode.parentNode.parentNode.parentNode.id;
	var cmts = document.getElementById("comments");
	var clscmtctrl = document.getElementById("close-comment-control");
	var vhctrl = document.getElementById(current_name).querySelector(".comment-balloon");
	var cmtctrl = vhctrl.querySelector(".comment-control");

	cmts.className = "open-control";
	clscmtctrl.setAttribute("aria-hidden", "false");
	clscmtctrl.style.display = "inline-block";
	vhctrl.className = "comment-balloon icon visible-control";
	cmtctrl.style.display = "inline-block";

	clscmtctrl.addEventListener("click", toorigin);
	document.addEventListener("scroll", toorigin);
}

function toorigin(event) {
	var cmts = document.getElementById("comments");
	var clscmtctrl = document.getElementById("close-comment-control");
	var vhctrl = document.querySelector(".comment-balloon.icon.visible-control");
	var cmtctrl = vhctrl.querySelector(".comment-control");

	var target = event.target;

	if(target == vhctrl || target == vhctrl.querySelector(".comment-article") || target == vhctrl.querySelector(".comment-control"))
		return;

	var divs = vhctrl.querySelectorAll("div");
        for (var i = 0; i< divs.length; i++) {
		if (divs[i] == target) return;
	}

	var btns = vhctrl.querySelectorAll("button");
        for (var i = 0; i< btns.length; i++) {
		if (btns[i] == target) return;
	}

	var spans = vhctrl.querySelectorAll("span");
        for (var i = 0; i< spans.length; i++) {
		if (spans[i] == target) return;
	}

	cmts.className = "";
	clscmtctrl.setAttribute("aria-hidden", "true");
	clscmtctrl.style.display = "none";
	vhctrl.className = "comment-balloon icon hidden-control";
	cmtctrl.style.display = "none";

	clscmtctrl.removeEventListener("click", toorigin);
	document.removeEventListener("scroll", toorigin);
}
