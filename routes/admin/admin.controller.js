exports.admin = (req, res) => {
	if (req.session.is_logined === undefined) {
		res.redirect('https:/love.sc1945.xyz/user/login');
	}
	res.writeHead(200, { "Content-Type": "text/html" });
	res.send('index');
}
