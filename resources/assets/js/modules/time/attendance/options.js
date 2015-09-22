module.exports = {
    data: {
        time: '--:--',
        isTimelogLoaded: false,
        timelog_id: null,
        timelogs: [],
        dateRange: '',
        summaryReport: {
            total_hours: 0,
            late: 0,
            undertime: 0,
            overtime: 0
        },
        currentTimelog: null
    },
    ready: function() {
        this.timelog_id = this.$$.out.getAttribute('data-id');
        this.initDatePicker();
        this.initDateTimePicker();
        this.clock();
        this.fetchTimelogs();
    },
    filters: {
        timeFormat: require('../../../filters/time_format.js'),
        dateFormat: require('../../../filters/date_format.js'),
        decimalPlace: require('../../../filters/number_format.js')
    },
    methods: require('./methods.js')
}