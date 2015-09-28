var timelog = require('../../../controllers/timelog_controller.js');

module.exports = {
    editTimelog: timelog.edit,
    deleteTimelog: timelog.destroy,
    updateTimelog: timelog.update,
    timeIn: timelog.timeIn,
    timeOut: timelog.timeOut,
    fetchTimelogs: timelog.fetchTimelogs,
    getServerDate: timelog.getServerDate,
    initDatePicker: timelog.initDatePicker,
    onApplyDateRange: timelog.onApplyDateRange,
    clock: timelog.clock,
    initDateTimePicker: timelog.initDateTimePicker,
    setDateTimePicker: timelog.setDateTimePicker,
    componentFormat: timelog.componentFormat,
};