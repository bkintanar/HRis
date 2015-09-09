var Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#app',
    data: {
        time: '--:--',
        isTimelogLoaded: false,
        timelog_id: null,
        timelogs: [],
        dateRange: '',
        totalHours: 0
    },
    ready: function() {
        this.initTimelogId();
        this.initDatePicker();
        this.clock();
        this.fetchTimelogs();
    },
    filters: {
        timeFormat: function(utc) {
            if(! utc) return '--:--';
            return this.utcToLocal(utc, 'hh:mm A');
        },
        dateFormat: function(utc) {
            return this.utcToLocal(utc, 'MMM D, YYYY');
        },
        decimalPlace: function(num, decimal = 2) {
            return Number(num).toFixed(decimal);
        }
    },
    methods: {
        initDatePicker: function() {
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
        },
        initTimelogId: function() {
            this.timelog_id = this.$$.out.getAttribute('data-id');
        },
        utcToLocal: function(utc, format) {
            var local = moment.utc(utc).toDate();
            return moment(local).format(format);
        },
        onApplyDateRange: function() {
            var self = this;
            this.$$datePicker.on('apply.daterangepicker', function(ev, picker) {
                var data = {
                    start: picker.startDate.format('YYYY-MM-DD'),
                    end: picker.endDate.format('YYYY-MM-DD'),
                    offset: moment().utcOffset()
                };

                self.$http.get('/ajax/timelogs', data, function(data) {
                    this.timelogs = data.timelogs;
                    this.dateRange = data.date_range;
                    this.totalHours = data.total_hours;
                });
            });
        },
        timeIn: function(e) {
            var self = this;
            e.preventDefault();
            this.$http.get('/alert/time-in', function(settings) {
                swal(settings,
                    function(){
                        swal.disableButtons();
                        $.post('/ajax/time-in', function(data) {
                            swal(data.title, data.text);
                            self.timelog_id = data.timelog_id;
                            self.fetchTimelogs();
                        });
                    }
                );
            });
        },
        timeOut: function(e) {
            e.preventDefault();
            var self = this,
                data = { 'id': this.timelog_id };

            this.$http.get('alert/time-out', function(settings) {
                swal(settings,
                    function(){
                        swal.disableButtons();
                        $.post('/ajax/time-out', data, function(data) {
                            swal(data.title, data.text);
                            self.timelog_id = null;
                            self.fetchTimelogs();
                        });
                    }
                );
            });
        },
        fetchTimelogs: function() {
            this.$http.get('/ajax/timelogs', function (data) {
                this.isTimelogLoaded = true;
                this.timelogs = data.timelogs;
                this.totalHours = data.total_hours;
                this.dateRange = data.date_range;
            });
        },
        getServerDate: function() {
            var time;
            this.$http.get('/ajax/server-time', function (data) {
                time = data.server.date;
            });
            return time;
        },
        clock: function() {
            var self = this,
                local = moment.utc(this.getServerDate()).toDate();

            setInterval(function(){
                self.time = moment(local).format('h:mm:ss A');
                local = moment(local).add(1, 'seconds').toDate();
            },1000);  
        },
        deleteTimelog: function(timelog) {
            var self = this;
            this.$http.get('/alert/timelog-delete', function(settings) {
                swal(settings, function() {
                    swal.disableButtons(); 
                    self.$http.delete('/ajax/timelog/' + timelog.id, function(data) {
                        swal(data.title, data.text, data.level);
                        this.timelogs.$remove(timelog);
                    });
                });
            });
        },
        editTimelog: function(timelog) {
            var self = this,
                data = {
                    'in': this.utcToLocal(timelog.in, 'HH:mm'),
                    'out': this.utcToLocal(timelog.out, 'HH:mm')
                };

            this.$http.get('/alert/timelog-edit', data, function(settings) {
                swal(settings, function() {
                    swal.disableButtons();
                    var timeIn = moment($('#time_in').val(),'HH:mm'),
                        timeOut = moment($('#time_out').val(),'HH:mm'),
                        _in = moment(timelog.in).set({ 'hour': timeIn.hours(), 'minute': timeIn.minutes() }),
                        out = moment(timelog.out).set({ 'hour': timeOut.hours(), 'minute': timeOut.minutes() });
                    var data = {
                        'in': _in.utc().format('YYYY-MM-DD HH:mm'),
                        'out': out.utc().format('YYYY-MM-DD HH:mm')
                    };
                    console.log(_in.utc().format());
                    console.log(out.utc().format());
                    self.$http.put('/ajax/timelog/' + timelog.id, data, function(obj) {
                        timelog.in = data.in;
                        timelog.out = data.out;
                        timelog.rendered_hours = obj.rendered_hours;
                        swal(obj.title, obj.text, obj.level);
                    });
                });
            });
        }
    }
});