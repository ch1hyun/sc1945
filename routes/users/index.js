const router = require('express').Router()
const Schedule = require('../../models/schedule');
const fs = require('fs');

function dateFormatDB(date) {
	return date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
}

function dateFormat(date) {
	return (date.getMonth()+1) + "/" + date.getDate();
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

function findToIn(findData) {
	let result;
	return result;
}
function getSchedule(t_f) {
	let schedule = {schedules: {}};
	let findDatas = [];
	let dates = [];
	operateDate(t_f, "-", t_f.getDay() + 1);
	
	for(let i = 0; i < 7; ++i) {
		operateDate(t_f, "+", 1);
		let date = dateFormat(t_f);
		schedule.schedules[date] = null;

		// DB 정보 받아오는 코드
		let findData = {
			"date": dateFormatDB(t_f)
		};

		findDatas.push(findData.date);
	}

	return [schedule, findDatas]; 

}

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
	
	let t_f;
	if (req.query.t_f === undefined || req.query.t_f === "") {
		t_f = new Date();
	} else {
		t_f = new Date(req.query.t_f);
	}
	let [sc, findDatas] = getSchedule(t_f);
	operateDate(t_f, "-", 3);
	sc.year = t_f.getFullYear();
	if (sc === false) {
			return res.status(500).json({
				result: false,
				type: "DBqueryERROR"
			});
	}
	sc.weekData = ['일', '월', '화', '수', '목', '금', '토'];
	
	operateDate(t_f, "-", t_f.getDay() + 4);
	let prevButton = t_f.getFullYear() + "-" + (t_f.getMonth() + 1) + "-" + t_f.getDate();
	operateDate(t_f, "+", 14);
	let nextButton = t_f.getFullYear() + "-" + (t_f.getMonth() + 1) + "-" + t_f.getDate();


	Schedule.find({"date": {$in: findDatas}}, function(err, docs) {
		for(let key in sc.schedules) {
			for(let data of docs) {
				if(key.split('/')[1] === data.date.split('-')[2]) {
					if (sc.schedules[key] === null) sc.schedules[key] = [];
					sc.schedules[key].push(data);
				}
			}
		}
		return res.render('user/schedule', {
				page_name: 'schedule',
				nickname: req.session.nickname,
				userId: req.session.userId,
				schedule: sc,
				prevButton: prevButton, 
				nextButton: nextButton
		});
	});

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
				if (obj[id].pw === pw) { 
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
			if (obj[req.session.userId].pw !== req.body.cpw) {
				return res.send({
					result:false,
					type: "currentPasswordNotMatched"
				});
			}
			obj[req.session.userId].pw = req.body.pw;
			
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
