const express = require('express');
const router = express.Router();

const main = require('./main/index');
const user = require('./users/index');
const admin = require('./admin/index');

router.use('/', main);
router.use('/user', user);
router.use('/admin', admin);

module.exports = router;
