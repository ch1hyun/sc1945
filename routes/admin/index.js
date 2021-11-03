const express = require('express');
const mongoose = require('mongoose');
const dateCtrl = require('../../lib/date');
const Schedule = require('../../models/schedule');
const fs = require('fs');
const router = express.Router();

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
	let findDates, schedule = {};
	let d = (req.query.d === undefined) ? new Date() : new Date(req.query.d);
	d.setDate(1);

	schedule.year = d.getFullYear();
	schedule.month = d.getMonth() + 1;
	schedule.weekData = ['일', '월', '화', '수', '목', '금', '토'];
	schedule.dates = dateCtrl.getDates(d);
	[schedule.schedules, findDates] = dateCtrl.getSchedules(d, mode="month");

	let nextButton = dateCtrl.dateButtonFormat(d);
	d.setMonth(d.getMonth() - 2);
	let prevButton = dateCtrl.dateButtonFormat(d);

	Schedule.findByDates(findDates)
	.then((datas) => {
		for (let key in schedule.schedules) {
			for (let data of datas) {
				if (key.split('/')[1] === data.date.split('-')[2]) {
					if (schedule.schedules[key] === null) schedule.schedules[key] = [];
					schedule.schedules[key].push(data);
				}
			}
		}

		return res.render('admin/schedule/schedule', 
			{
				page_name: 'admin-schedule',
				nickname: req.session.nickname,
				schedule: schedule,
				mode: req.query.mode,
				prevButton: prevButton,
				nextButton: nextButton
			}
		);
	})
	.catch(err => res.status(500).send(err));
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
	let nextDate = dateCtrl.getNextMonth(new Date(currentDate));

	Schedule.deleteByPeriod(currentDate, nextDate)
	.catch(err => res.status(500).send(err));

	for (let date in editSchedule) {
		for (let schedule of editSchedule[date]) {
			Schedule.create({
				date: date,
				content: schedule
			})
			.catch(err => res.status(500).send(err));
		}
	}

	return res.redirect("/admin/schedule");
});

module.exports = router;
