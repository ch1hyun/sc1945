function typerStart() {
	$("#count-days").typer({
		strings: [
			"Love Forever",
			"D+ <%= countDays %>"
		],
		useCursor: true,
		typeSpeed: 100,
		backspaceSpeed: 40,
		backspaceDelay: 3000,
		repeatDelay: 2000,
		repeat:true,
		autoStart:true,
		startDelay: 100,
	});
}