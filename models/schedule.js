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

scheduleSchema.statics.findByDates = function(findDates) {
	return this.find({"date": {$in: findDates}});
};

scheduleSchema.statics.deleteByPeriod = function(prev, next) {
	return this.deleteMany({"date": {$gte: prev, $lt: next}});
};

scheduleSchema.statics.create = function(object) {
	const schedule = new this(object);
	return schedule.save();
}

module.exports = mongoose.model('Schedule', scheduleSchema);
