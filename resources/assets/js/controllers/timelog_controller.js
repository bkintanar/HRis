var controller = {};

controller.edit = function(timelog) {
    $('#edit_timelog').modal();
    this.componentFormat('#time_in', timelog.in);
    this.componentFormat('#time_out', timelog.out);
    this.currentTimelog = timelog;
};

controller.destroy = function(timelog) {
    this.$http.get('/alert/timelog-delete', function(settings) {
        swal(settings, function() {
            swal.disableButtons(); 
            self.$http.delete('/ajax/timelog/' + timelog.id, function(data) {
                swal(data.title, data.text, data.level);
                this.timelogs.$remove(timelog);
            });
        }.bind(this));
    });
};

controller.update = function(e) {
    e.preventDefault();
    var data = {
        'in': moment.utc($('#time_in').filthypillow('getDate')).format('YYYY-MM-DD HH:mm'),
        'out': moment.utc($('#time_out').filthypillow('getDate')).format('YYYY-MM-DD HH:mm')
    };

    this.$http.put('/ajax/timelog/' + this.currentTimelog.id, data, function(obj) {
        this.currentTimelog.in = data.in;
        this.currentTimelog.out = data.out;
        this.currentTimelog.rendered_hours = obj.rendered_hours;
        swal(obj.title, obj.text, obj.level);
    });
};

controller.timeIn = function(e) {
    e.preventDefault();
    this.$http.get('/alert/time-in', function(settings) {
        swal(settings,
            function(){
                swal.disableButtons();
                this.$http.post('/ajax/time-in', function(data) {
                    swal(data.title, data.text);
                    this.timelog_id = data.timelog_id;
                    this.fetchTimelogs();
                });
            }.bind(this)
        );
    });
};

controller.timeOut = function(e) {
    e.preventDefault();
    var data = { 'id': this.timelog_id };

    this.$http.get('alert/time-out', function(settings) {
        swal(settings,
            function(){
                swal.disableButtons();
                this.$http.post('/ajax/time-out', data, function(data) {
                    swal(data.title, data.text);
                    this.timelog_id = null;
                    this.fetchTimelogs();
                });
            }.bind(this)
        );
    });
};

controller.fetchTimelogs = function() {
    this.$http.get('/ajax/timelogs', function (data) {
        this.isTimelogLoaded = true;
        this.timelogs = data.timelogs;
        this.summaryReport = data.summary_report;
        this.dateRange = data.date_range;
    });
};

controller.getServerDate = function() {
    var time;
    this.$http.get('/ajax/server-time', function (data) {
        time = data.server.date;
    });
    return time;
};

controller.initDatePicker = function() {
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    var start = moment([moment().year(), moment().month()]),
        end = moment(start).endOf('month');

    cb(start, end);
    this.$$datePicker = $('#reportrange').daterangepicker({
        ranges: {
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    this.onApplyDateRange();
};

controller.onApplyDateRange = function() {
    this.$$datePicker.on('apply.daterangepicker', function(ev, picker) {
        var data = {
            start: picker.startDate.format('YYYY-MM-DD'),
            end: picker.endDate.format('YYYY-MM-DD'),
            offset: moment().utcOffset()
        };

        this.$http.get('/ajax/timelogs', data, function(data) {
            this.timelogs = data.timelogs;
            this.dateRange = data.date_range;
            this.summaryReport = data.summary_report;
        });
    }.bind(this));
};

controller.clock = function() {
    var local = moment.utc(this.getServerDate()).toDate();

    setInterval(function(){
        this.time = moment(local).format('h:mm:ss A');
        local = moment(local).add(1, 'seconds').toDate();
    }.bind(this), 1000);
};

controller.initDateTimePicker = function() {
    $(document).ready(function() {
        this.setDateTimePicker('#time_in');
        this.setDateTimePicker('#time_out');
    }.bind(this));
};

controller.setDateTimePicker = function(id) {
    var $fp = $(id);

    $fp.filthypillow({enableCalendar: false, startStep: 'hour'})
        .on( "focus", function( ) {
          $fp.filthypillow( "show" );
        })
        .on( "fp:save", function( e, dateObj ) {
          $fp.val( dateObj.format( "MMM DD YYYY hh:mm A" ) );
          $fp.filthypillow( "hide" );
        });
};

controller.componentFormat = function(id, str_time) {
    var time = $(id),
        m_time = moment(moment.utc(str_time).toDate());

    time.on('focus', function() {
        time.filthypillow('updateDateTime', m_time.toDate());

        var container = time.next();
        container.find(".fp-month").text(m_time.format( "MM" ));
        container.find(".fp-day").text(m_time.format( "DD" ));
        container.find(".fp-hour").text(m_time.format( "hh" ));
        container.find(".fp-minute").text(m_time.format( "mm" ));
        container.find(".fp-meridiem").text(m_time.format( "A" ));
    });

    time.filthypillow('updateDateTime', m_time.toDate());
    time.val(m_time.format("MMM DD YYYY hh:mm A"));
};

module.exports = controller;