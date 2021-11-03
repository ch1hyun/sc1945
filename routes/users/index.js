const router = require('express').Router();
const md5 = require('md5');
const Schedule = require('../../models/schedule');
const dateCtrl = require('../../lib/date');
const fs = require('fs');

router.get('/', function(req, res) {
	return res.redirect('/user/login');
});

router.get('/login', function(req, res) {
	if (req.session.is_logined !== undefined) {
		return res.redirect('/');
	}
	return res.render('user/login', {
		nickname: "Stranger",
		page_name: "login"
	});
});

router.get('/logout', function(req, res) {
	if (req.session.is_logined === undefined) {
		return res.redirect('/');
	}

	req.session.destroy(function(err){
		if(err) res.status(500).send('Internal Server Error');
		return res.redirect('/');
	});
});

router.get('/profile', function(req, res) {
	if (req.session.is_logined === undefined) {
		return res.redirect('/');
	}

	return res.render('user/profile',
		{
			page_name: 'profile',
			nickname: req.session.nickname,
			userId: req.session.userId
		}
	);
});

router.get('/schedule', function(req, res) {
	if (req.session.is_logined === undefined) {
		return res.redirect('/');
	}
	let findDates, schedule = {};
	let d = (req.query.d === undefined) ? new Date() : new Date(req.query.d);
	
	schedule.year = d.getFullYear();
	schedule.weekData = ['일', '월', '화', '수', '목', '금', '토'];
	schedule.color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
	schedule.scheduleList = ['오전', '오후', '주간', '야간', '주간당직', '야간당직'];
	[schedule.schedules, findDates] = dateCtrl.getSchedule(d, mode="7days");
	
	dateCtrl.operateDate(d, "-", d.getDay() + 4);
	let prevButton = dateCtrl.dateButtonFullFormat(d);
	dateCtrl.operateDate(d, "+", 14);
	let nextButton = dateCtrl.dateButtonFullFormat(d);

	Schedule.findByDates(findDates)
	.then((datas) => {
		for(let key in schedule.schedules) {
			for(let data of datas) {
				if(key.split('/')[1] === data.date.split('-')[2]) {
					if (schedule.schedules[key] === null) schedule.schedules[key] = [];
					schedule.schedules[key].push(data);
				}
			}
		}
		return res.render('user/schedule', {
				page_name: 'schedule',
				nickname: req.session.nickname,
				userId: req.session.userId,
				schedule: schedule,
				prevButton: prevButton, 
				nextButton: nextButton
		});
	})
	.catch(err => res.status(500).send(err));
});

router.post('/login', function(req, res) { 
	if (req.session.is_logined !== undefined) { 
		return res.redirect('/'); 
	} 

	let id = req.body.sc_id;
	let pw = req.body.sc_pw;
	let rm = req.body.sc_rm;

	fs.readFile(__dirname + '/../../auth/users.json', 'utf-8', function(err, data) { 
		let obj = JSON.parse(data); 

		if (Object.keys(obj).includes(id)) { 
				if (obj[id].pw === md5(pw + obj.salt)) { 
					req.session.is_logined = true; 
					req.session.userId = id; 
					req.session.nickname = obj[id].nickname; 
					if (rm) { 
						req.session.cookies.originalMaxAge = 3 * 24 * 60 * 60 * 1000; 
					}
					return res.redirect('/');
				} else { 
					return res.redirect('/user/login');
				}
		} else {
			res.redirect('/user/login');
		}
	});
});

router.put('/profile', function(req, res) {
	if (req.session.is_logined === undefined) {
		res.redirect('/');
	}

	if (req.body.target === 'password') {
		fs.readFile(__dirname + '/../../auth/users.json', 'utf-8', function(err, data) {
			let obj = JSON.parse(data);
			if (obj[req.session.userId].pw !== md5(req.body.cpw + obj.salt)) {
				return res.send({
					result:false,
					type: "currentPasswordNotMatched"
				});
			}
			obj[req.session.userId].pw = md5(req.body.pw + obj.salt);
			
			fs.writeFile(__dirname + '/../../auth/users.json', JSON.stringify(obj), (err) => {
				if (err) {
					return res.status(500).send('Internal Server Error');
				}
				return res.send({result:true});
			});
		});
	} else {
		return res.status(500).send('Internal Server Error');
	}
}); 

module.exports = router;
