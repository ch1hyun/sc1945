const express = require('express');
const mongoose = require('mongoose');
const router = express.Router();
const Schedule = require('../../models/schedule');
const controller = require('./admin.controller');
const fs = require('fs');

function getDates(date) {
	let dates = [];
	let lastDate = new Date(date.getMonth() === 11 ? date.getFullYear() + 1 : date.getFullYear(), date.getMonth() === 11 ? 0     : date.getMonth() + 1, 0).getDate();

	let temp = [];
	for (let i = 0; i < 7; ++i) {
		if (i < date.getDay()) temp.push({date: null});
		else temp.push({date: (i - date.getDay() + 1)});
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

function dateFormatDB(date) {
	return date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
}
function dateFormat(date) {
	return (date.getMonth()+1) + "/" + date.getDate();
}

function operateDate(date, operate, amount) {
	if (operate === "+") {
		let nextYear = date.getMonth() === 11 ? date.getFullYear() + 1 : date.getFullYear();
		let nextMonth = date.getMonth() === 11 ? 0 : date.getMonth() + 1;
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

function getSchedules(date) {
	let schedules = {};
	let findDatas = [];
	let lastDate = new Date(date.getMonth() === 11 ? date.getFullYear() + 1 : date.getFullYear(), date.getMonth() === 11 ? 0 : date.getMonth() + 1, 0).getDate();

	for(let i = 0; i < lastDate; ++i) {
		// DB 정보 받아오는 코드
		let temp_date = dateFormat(date);
		schedules[temp_date] = null;

		findData = {
			"date": dateFormatDB(date)
		};

		findDatas.push(findData.date);
		operateDate(date, "+", 1);
	}

	return [schedules, findDatas];
}

router.get('/', function(req, res) {
	if (req.session.is_logined === undefined) {
		if (req.session.id !== 'admin') {
			return res.redirect('/');
		}
		return res.redirect('/user/login');
	}

	return res.render('admin/index',
		{
			page_name: 'admin-home',
			nickname: req.session.nickname
		}
	);
});

router.get('/schedule', function(req, res) {
	if (req.session.is_logined === undefined) {
		if (req.session.id !== 'admin') {
			return res.redirect('/');
		}
		return res.redirect('/user/login');
	}
	let schedule = {};
	let findDatas;

	let t_f
	if (req.query.t_f === undefined || req.query.t_f === "") {
		t_f = new Date();
	} else {
		t_f = new Date(req.query.t_f);
	}
	t_f.setDate(1);

	schedule.year = t_f.getFullYear();
	schedule.month = t_f.getMonth() + 1;
	schedule.weekData = ['일', '월', '화', '수', '목', '금', '토'];
	schedule.dates = getDates(t_f);
	[schedule.schedules, findDatas] = getSchedules(t_f);

	let nextButton = t_f.getFullYear() + "-" + (t_f.getMonth() + 1);
	t_f.setMonth(t_f.getMonth() - 2);
	let prevButton = t_f.getFullYear() + "-" + (t_f.getMonth() + 1);

	Schedule.find({"date": {$in: findDatas}}, function(err, docs) {
		for (let key in schedule.schedules) {
			for (let data of docs) {
				if (key.split('/')[1] === data.date.split('-')[2]) {
					if (schedule.schedules[key] === null) schedule.schedules[key] = [];
					schedule.schedules[key].push(data);
				}
			}
		}

		return res.render('admin/schedule/index', 
			{
				page_name: 'admin-schedule',
				nickname: req.session.nickname,
				schedule: schedule,
				mode: req.query.mode,
				prevButton: prevButton,
				nextButton: nextButton
			}
		);
	});
});

router.post('/schedule/edit', function(req, res) {
	if (req.session.is_logined === undefined) {
		if (req.session.id !== 'admin') {
			return res.redirect('/');
		}
		return res.redirect('/user/login');
	}

	let editSchedule = JSON.parse(req.body.editSchedule);
	let currentDate = req.body.currentDate;

	let temp = currentDate.split("-")
	let nextDate = ((parseInt(temp[1]) == 11) ? parseInt(temp[0]) + 1 : parseInt(temp[0])) + "-" + ((parseInt(temp[1]) == 11) ? 0 : parseInt(temp[1]) + 1)

	Schedule.deleteMany({"date": {'$gte': currentDate, '$lt': nextDate}}, function(err){});

	for (let date in editSchedule) {
		for (let schedule of editSchedule[date]) {
			let instance = new Schedule();
			instance.date = date;
			instance.content = schedule;

			instance.save(function(err) {
				if(err) return res.status(500).send('Interval Server Error');
			});
		}
	}

	return res.redirect("/admin/schedule");
});

module.exports = router;
