module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function () {

    this.$dispatch(
      'update-page-title', 'My Presence'
    );
  },

  data: function () {

    return {
      uri: '/presence/timelogs',
      table: {
        model: {
          dashed: ''
        },
        items: [{}],
        div_size: 'col-md-9',
        sub_title: ''
      },
      params: {
        page: 1,
        start: null,
        end: null,
        offset: 0,
        employee_id: ''
      },
      time: '12:00:00 AM',
      timelog_id: null,
      timelogs: [{}],
      summaryReport: [{}],
      dateRange: '',
      isTimelogLoaded: false
    };
  },

  ready: function () {

    this.queryDatabase(1);
    this.initDatePicker();
    this.clock();
  },

  methods: {
    queryDatabase: function (page) {

      this.params.page = page;
      this.params.employee_id = localStorage.getItem('employee_id');

      let params = {
        path: '/presence/timelogs?' + $.param(this.params),
        method: 'GET',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      // retrieve employee list
      client(params).then(
        function (response) {
          this.timelog_id = null;
          this.isTimelogLoaded = true;

          this.timelogs = response.entity.data.timelogs.data;
          this.summaryReport = response.entity.data.summary_report;

          this.table = response.entity.table;
          this.table.sub_title = response.entity.data.date_range;

          var latest_timelog = this.timelogs[0];

          if (typeof latest_timelog != 'undefined' && latest_timelog.out == null) {
            this.timelog_id = latest_timelog.id;
          }

        }.bind(this),
        function (response) {

        }.bind(this));
    },

    getServerDate: function () {

      let params = {
        path: '/presence/server-time',
        method: 'GET',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(function (response) {

        return response.entity.server.date;
      });
    },

    clock: function () {
      var local = moment.utc(this.getServerDate()).toDate();

      setInterval(function () {
        this.time = moment(local).format('h:mm:ss A');
        local = moment(local).add(1, 'seconds').toDate();
      }.bind(this), 1000);
    },

    initDatePicker: function () {
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
      this.onApplyDateRange(1);
    },

    setParams: function (params) {
      this.params = params;
    },

    onApplyDateRange: function (page) {
      this.$$datePicker.on('apply.daterangepicker', function (ev, picker) {

        var data = {
          page: page,
          start: picker.startDate.format('YYYY-MM-DD'),
          end: picker.endDate.format('YYYY-MM-DD'),
          offset: moment().utcOffset(),
          employee_id: this.logged.employee_id
        };

        this.setParams(data);

        this.queryDatabase(page);

      }.bind(this));
    },

    timeIn: function (e) {
      e.preventDefault();

      let params = {
        path: '/presence/alert/time-in',
        method: 'GET',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
        function (response) {

          swal(response.entity,
            function () {
              swal.disableButtons();

              let params = {
                path: '/presence/time-in',
                method: 'POST',
                headers: {Authorization: localStorage.getItem('jwt-token')}
              };

              client(params).then(
                function (response) {
                  swal(response.entity.title, response.entity.text);
                  this.timelog_id = response.entity.timelog_id;
                  this.queryDatabase(1);
                }.bind(this));
            }.bind(this)
          );

        }.bind(this),
        function (response) {

        }.bind(this));
    },

    timeOut: function (e) {
      e.preventDefault();
      var data = {'id': this.timelog_id};

      let params = {
        path: '/presence/alert/time-out',
        method: 'GET',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
        function (response) {

          swal(response.entity,
            function () {
              swal.disableButtons();

              let params = {
                path: '/presence/time-out',
                method: 'POST',
                entity: data,
                headers: {Authorization: localStorage.getItem('jwt-token')}
              };

              client(params).then(
                function (response) {

                  swal(response.entity.title, response.entity.text);
                  this.timelog_id = null;
                  this.queryDatabase(1);
                }.bind(this)
              );
            }.bind(this)
          );

        }.bind(this),
        function (response) {

        }.bind(this));
    }
  }
};
