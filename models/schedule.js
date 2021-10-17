const mongoose = require("mongoose");

// Define Schemes
const scheduleSchema = new mongoose.Schema({
	date: {
		type: String,
		required: true
	},
	content: {
		type: String,
		required: true
	}
}, { timestamps: true });

module.exports = mongoose.model('Schedule', scheduleSchema);
