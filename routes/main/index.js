const express = require('express');
const router = express.Router();
const controller = require('./main.controller');
const fs = require('fs');

router.get('/', function(req, res) {
	if (req.session.is_logined === undefined) {
		res.redirect('/user/login');
		res.end();
	}
	let today = new Date();
	let metDay = new Date(2019, 3, 5);
	let endArmyDay = new Date(2023, 0, 11);

	let met_dday = Math.ceil((today.getTime() - metDay.getTime()) / (1000 * 60 * 60 * 24));
	let endArmy_dday = Math.ceil((endArmyDay.getTime() - today.getTime()) / (1000 * 60 * 60 * 24));
	res.render('index',
		{
			page_name: 'home',
			countDays: met_dday,
			untilEndArmy: endArmy_dday,
			nickname: req.session.nickname,
			userId: req.session.userId
		}
	);
});


module.exports = router;
