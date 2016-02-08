module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function() {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Personal Details'
    );
  },

  route: {
    canReuse: false
  },

  data: function() {

    return {
      id: '',
      nationality: '',
      nationality_obj: {},
      marital_status_obj: {},
      nationalities_chosen: [{}],
      marital_status: '',
      marital_statuses_chosen: [{}],
      original_employee_id: '',
      custom_field_sections: [{}]
    };
  },

  ready: function() {

    this.queryDatabase();
  },

  methods: {

    queryDatabase: function() {

      if (this.$route.path.indexOf('/pim') > -1) {
        this.employee_id = this.$route.params.employee_id;
      } else {
        this.employee_id = localStorage.getItem('employee_id');
      }

      client({
        path: '/pim/configuration/custom-field-sections-by-screen-id',
        entity: { screen_name: 'Personal Details' },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        this.custom_field_sections = response.entity.custom_field_sections;

      }.bind(this),

      function(response) {

        if (response.status.code == 422) {
          this.$route.router.go({
            name: 'error-404'
          });
          console.log(response.entity);
        }
      }.bind(this));

      let params = {
        path: '/employee/get-by-employee-id?include=user',
        entity: { employee_id: this.employee_id },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      };

      client(params).then(
      function(response) {

        this.$dispatch('update-employee', response.entity.data);
        this.custom_field_values = response.entity.data.custom_field_values;

        this.original_employee_id = response.entity.data.employee_id;

        this.chosenNationalities();
        this.chosenMaritalStatuses();

        var genderWatcher = setInterval(function() {

          if (this.employee != null) {

            var _this = this;

            // iCheck
            $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green'
            });
            clearInterval(genderWatcher);

            $('input[name="gender"]').on('ifChecked', function() {

              _this.employee.gender = this.value;
            });

            this.switchGender(this.employee.gender);
          }
        }.bind(this), 1);

      }.bind(this),

      function(response) {

        if (response.status.code == 422) {
          this.$route.router.go({
            name: 'error-404'
          });
          console.log(response.entity);
        }
      }.bind(this));
    },

    submitForm: function() {

      // jasny bug work around
      $('#first_name').focus();

      this.employee.marital_status_id = this.marital_status_obj.id;
      this.employee.nationality_id = this.nationality_obj.id;

      let params = {
        path: '/profile/personal-details',
        method: 'PATCH',
        entity: { employee: this.employee },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      };

      client(params).then(
      function(response) {

        this.updateLocalStorage(response.entity.employee.employee_id);

        if (this.$route.path.indexOf('/pim') > -1) {
          this.$route.router.go({
            name: 'pim-employee-list-personal-details',
            params: { employee_id: response.entity.employee.employee_id }
          });
        }

        this.$route.params.employee_id = response.entity.employee.employee_id;
        swal({ title: response.entity.message, type: 'success', timer: 2000 });
        this.cancelForm();

      }.bind(this),
      function(response) {
        switch (response.status.code) {
          case 405:
            swal({ title: response.entity.message, type: 'warning', timer: 2000 });
            break;
          case 422:
            $('#first_name').focus();
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
            break;
        }
      }.bind(this));
    },

    modifyForm: function() {

      $('.avatar').css('display', '');
      $('.job-title').css('display', 'none');

      $('.save-form').css('display', '');
      $('.modify-form').css('display', 'none');
      $('.vue-chosen').prop('disabled', false).trigger('chosen:updated');
      $('.form-control').prop('disabled', false);
      $('.i-checks').iCheck('enable');

      // datepicker for birth_date
      $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      }).datepicker('update', this.employee.birth_date);

      $('#first_name').focus();
    },

    cancelForm: function() {

      // retrieve original data since cancel button was pressed.
      this.queryDatabase();

      $('.avatar').css('display', 'none');
      $('.job-title').css('display', '');

      $('.save-form').css('display', 'none');
      $('.modify-form').css('display', '');
      $('.vue-chosen').prop('disabled', true).trigger('chosen:updated');
      ;
      $('.form-control').prop('disabled', true);
      $('.i-checks').iCheck('disable');

      // datepicker for birth_date
      $('#datepicker_birth_date .input-group.date').datepicker('remove');
    },

    switchGender: function(gender) {

      switch (gender) {
        case 'M' :
          $('input[id="gender[1]"]').iCheck('check');
          break;
        case 'F' :
          $('input[id="gender[2]"]').iCheck('check');
          break;
      }
    },

    updateLocalStorage: function(new_employee_id) {

      if (this.original_employee_id == localStorage.getItem('employee_id')) {
        localStorage.setItem('employee_id', new_employee_id);
      }
    },

    chosenNationalities: function() {

      // retrieve nationalities
      client({
        path: '/nationalities',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {
        if (response) {
          this.nationalities_chosen = response.entity;
        }

        this.nationality_obj = this.nationalities_chosen[this.employee.nationality_id - 1];
        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    },

    chosenMaritalStatuses: function() {

      // retrieve marital status
      client({
        path: '/marital-statuses',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {
        if (response) {
          this.marital_statuses_chosen = response.entity;
        }

        this.marital_status_obj = this.marital_statuses_chosen[this.employee.marital_status_id - 1];
        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    }
  }
};
