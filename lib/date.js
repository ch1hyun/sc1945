function dateFormatDB(d) {
	return d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate();
}

function dateFormat(d) {
	return (d.getMonth()+1) + "/" + d.getDate();
}

function dateButtonFormat(d) {
	return d.getFullYear() + "-" + (d.getMonth() + 1);
}

function dateButtonFullFormat(d) {
	return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
}

function operateDate(date, operate, amount) {
	if (operate === "+") {
		let nextYear = date.getMonth() == 11 ? date.getFullYear() + 1 : date.getFullYear();
		let nextMonth = date.getMonth() == 11 ? 0 : date.getMonth() + 1;
		let lastDate = new Date(nextYear, nextMonth, 0).getDate();
		let currentDate = date.getDate();
		
		if (currentDate + amount > lastDate) {
			date.setDate(currentDate + amount - lastDate);
			date.setYear(nextYear);
			date.setMonth(nextMonth);
		} else {
			date.setDate(currentDate + amount);
		}
	} else if (operate === "-") {
		let prevLastDate = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
		let currentDate = date.getDate();

		if (amount > currentDate) {
			date.setDate(0);
			date.setDate(prevLastDate + currentDate - amount);
		} else {
			date.setDate(currentDate - amount);
		}
	}
}

function getLastDate(d) {
	let lastDate, temp = d.getDate();
	d.setMonth(d.getMonth() + 1);
	d.setDate(0);
	lastDate = d.getDate();
	d.setDate(temp);
	
	return lastDate;
}

function getSchedule(d, mode) {
	let schedule = {};
	let findDates = [];
	
	if (mode === "month") {
		let lastDate = getLastDate(d);
		
		for(let i = 0; i < lastDate; ++i) {
			schedules[dateFormat(d)] = null;

			findDates.push(dateFormatDB(d));
			operateDate(date, "+", 1);
		}
	} else if (mode === "7days") {
		for(let i = 0; i < 7; ++i) {
			operateDate(d, "+", 1);
			schedule[dateFormat(d)] = null;

			findDates.push(dateFormatDB(d));
		}
	} else {
		return false;
	}
	
	return [schedule, findDates];
}

function getDates(d) {
	let dates = [];
	let lastDate = getLastDate(d);

	let temp = [];
	for (let i = 0; i < 7; ++i) {
		if (i < d.getDay()) temp.push({date: null});
		else temp.push({date: (i - d.getDay() + 1)});
	}
	dates.push(temp);

	for (let i = dates[0][6].date; i < lastDate; ++i) {
		if ((i - dates[0][6].date) % 7 == 0) {
			if (i - dates[0][6].date != 0) dates.push(temp);
			temp = [];
		}

		temp.push({date: (i + 1)});
	}

	let l = temp.length;
	for (let i = 0; i < 7 - l; ++i) {
		temp.push({date:null});
	}
	dates.push(temp)

	return dates;
}

function getNextMonth(d) {
	let result, temp = d.getDate();
	d.setMonth(d.getMonth() + 1);
	result = d.getFullYear() + "-" + d.getMonth();
	d.setMonth(d.getMonth() - 1);
	d.setDate(temp);
	
	return result;
}