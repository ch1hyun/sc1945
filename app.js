const express = require('express');
const session = require('express-session');
const mongoose = require('mongoose');
const path = require('path');
const bodyParser = require('body-parser');

const app = express();

app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, '/public')));
app.use(session({
	secret: 'tjgml2597sc1945',
	resave: false,
	saveUninitialized: true,
	maxAge: 1 * 24 * 60 * 60 * 1000
}));

app.set('view engine', 'ejs');
app.set('views', './templates');


//let connection1 = mongoose.createConnection("mongodb://localhost:27017/sc1945")
let db = mongoose.connection;
db.on('error', console.error);
db.once('open', function() {
	console.log("Connected to mongod server");
});

mongoose.connect('mongodb://localhost/sc1945');

// ROUTES
app.use('/', require('./routes'));

//app.listen(3000, function() {
//	console.log("Server listening 3000...");
//});

require('greenlock-express').init({
	packageRoot: __dirname,
	configDir: './greenlock.d',
	maintainerEmail: 'och2510@gmail.com',
}).serve(app);

