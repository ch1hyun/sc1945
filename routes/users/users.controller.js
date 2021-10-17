exports.users = (req, res) => {
	if (req.session.is_logined !== undefined) res.redirect('/');
	res.send('/public/user/login');
}
