module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function () {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Job Details'
    );
  },

  data: function () {

    return {
      editMode: false,
      employee_id: '',
      job_titles_chosen: [{}],
      job_title_obj: {},
      employment_statuses_chosen: [{}],
      employment_status_obj: {},
      departments_chosen: [{}],
      department_obj: {},
      locations_chosen: [{}],
      location_obj: {}
    };
  },

  ready: function () {

    this.queryDatabase();
  },

  methods: {
    queryDatabase: function () {

      if (this.$route.path.indexOf('/pim') > -1) {
        this.employee_id = this.$route.params.employee_id;
      } else {
        this.employee_id = localStorage.getItem('employee_id');
      }

      let params = {
        method: 'GET',
        path: '/employee/' + this.employee_id + '?include=user,job_histories',
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
        function (response) {

          this.$dispatch('update-employee', response.entity.data);
          this.custom_field_values = response.entity.data.custom_field_values;

          this.chosenJobTitles();
          this.chosenEmploymentStatuses();
          this.chosenDepartments();
          this.chosenLocations();
        }.bind(this),
        function (response) {

          if (response.status.code == 422) {
            this.$route.router.go({
              name: 'error-404'
            });
            console.log(response.entity);
          }
        }.bind(this));
    },

    deleteRecord: function (job_history, index) {

      var previousWindowKeyDown = window.onkeydown; // https://github.com/t4t5/sweetalert/issues/127
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        type: 'warning',
        confirmButtonClass: 'confirm-class',
        cancelButtonClass: 'cancel-class',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {

        swal.disableButtons();
        window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
        if (isConfirm) {

          let params = {
            path: '/profile/job/' + job_history.id,
            method: 'DELETE',
            headers: {Authorization: localStorage.getItem('jwt-token')}
          };

          client(params).then(
            function (response) {
              swal({title: response.entity.message, type: 'success', timer: 2000});
              this.employee.job_histories.data.splice(index, 1);
              this.setCurrentJobHistory();
            }.bind(this),
            function (response) {

              if (response.status.code == 422) {
                swal({title: response.entity.message, type: 'error', timer: 2000});
              }
            }.bind(this));

        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    setCurrentJobHistory: function () {

      var current_job_history = this.employee.job_histories.data[0];

      this.employee.job_history.data.job_title_id = current_job_history.job_title_id;
      this.employee.job_history.data.department_id = current_job_history.department_id;
      this.employee.job_history.data.employment_status_id = current_job_history.employment_status_id;
      this.employee.job_history.data.work_shift_id = current_job_history.work_shift_id;
      this.employee.job_history.data.location_id = current_job_history.location_id;

      this.job_title_obj = this.job_titles_chosen[this.employee.job_history.data.job_title_id - 1];
      this.employment_status_obj =
        this.employment_statuses_chosen[this.employee.job_history.data.employment_status_id - 1];
      this.department_obj = this.departments_chosen[this.employee.job_history.data.department_id - 1];
      this.location_obj = this.locations_chosen[this.employee.job_history.data.location_id - 1];

      this.employee.job_history.data.effective_date = current_job_history.effective_date;
      this.employee.job_history.data.comments = current_job_history.comments;

      this.updateLoggedUser(current_job_history);
    },

    modifyForm: function () {

      $('.save-form').css('display', '');
      $('.modify-form').css('display', 'none');
      $('.vue-chosen').prop('disabled', false).trigger('chosen:updated');
      $('.form-control').prop('disabled', false);
      $('.i-checks').iCheck('enable');

      this.toggleDatepickers(true);

      $('#first_name').focus();
    },

    terminateForm: function () {

    },

    cancelForm: function () {

      // retrieve original data since cancel button was pressed.
      this.queryDatabase();

      $('.save-form').css('display', 'none');
      $('.modify-form').css('display', '');

      this.disableFields();
    },

    disableFields: function () {
      $('.vue-chosen').prop('disabled', true).trigger('chosen:updated');
      $('.form-control').prop('disabled', true);

      this.toggleDatepickers(false);
    },

    chosenJobTitles: function () {

      // retrieve job-titles
      client({
        path: '/job-titles',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {
          if (response) {
            this.job_titles_chosen = response.entity.chosen;
          }

          if (this.employee) {
            this.job_title_obj = this.job_titles_chosen[this.employee.job_history.data.job_title_id - 1];
          }

          $('.vue-chosen').trigger('chosen:updated');
        }.bind(this));
    },

    chosenEmploymentStatuses: function () {

      // retrieve employment-statuses
      client({
        path: '/employment-statuses',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {
          if (response) {
            this.employment_statuses_chosen = response.entity.chosen;
          }

          if (this.employee) {
            this.employment_status_obj =
              this.employment_statuses_chosen[this.employee.job_history.data.employment_status_id - 1];
          }

          $('.vue-chosen').trigger('chosen:updated');
        }.bind(this));
    },

    chosenDepartments: function () {

      // retrieve departments
      client({
        path: '/departments',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {
          if (response) {
            this.departments_chosen = response.entity.chosen;
          }

          if (this.employee) {
            this.department_obj = this.departments_chosen[this.employee.job_history.data.department_id - 1];
          }

          $('.vue-chosen').trigger('chosen:updated');
        }.bind(this));
    },

    chosenLocations: function () {

      // retrieve locations
      client({
        path: '/locations',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {
          if (response) {
            this.locations_chosen = response.entity.chosen;
          }

          if (this.employee) {
            this.location_obj = this.locations_chosen[this.employee.job_history.data.location_id - 1];
          }

          $('.vue-chosen').trigger('chosen:updated');
        }.bind(this));
    },

    toggleDatepickers: function (enable) {

      if (enable) {
        $('.input-group.date').datepicker({
          format: 'yyyy-mm-dd',
          keyboardNavigation: false,
          forceParse: true,
          calendarWeeks: true,
          autoclose: true,
          clearBtn: true
        });

        $('#datepicker_effective_date .input-group.date')
          .datepicker('update', this.employee.job_history.data.effective_date);
        $('#datepicker_joined_date .input-group.date')
          .datepicker('update', this.employee.joined_date);
        $('#datepicker_probation_end_date .input-group.date')
          .datepicker('update', this.employee.probation_end_date);
        $('#datepicker_permanency_date .input-group.date')
          .datepicker('update', this.employee.permanency_date);
      } else {
        $('#datepicker_effective_date .input-group.date').datepicker('remove');
        $('#datepicker_joined_date .input-group.date').datepicker('remove');
        $('#datepicker_probation_end_date .input-group.date').datepicker('remove');
        $('#datepicker_permanency_date .input-group.date').datepicker('remove');
      }
    },

    submitForm: function () {

      // jasny bug work around
      $('#comments').focus();

      this.disableFields();

      if (!this.employee.job_history.data.effective_date) {
        swal({title: 'Effective Date is a required field', type: 'error', timer: 2000});
        $('#effective_date').focus();
        return false;
      }

      // Set Chosen data
      this.employee.job_history.data.job_title_id = this.job_title_obj.id;
      this.employee.job_history.data.employment_status_id = this.employment_status_obj.id;
      this.employee.job_history.data.department_id = this.department_obj.id;
      this.employee.job_history.data.location_id = this.location_obj.id;

      client({
        path: '/profile/job',
        method: 'PATCH',
        entity: {employee: this.employee},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {
          if (response.entity.job_history) {
            this.employee.job_histories.data.unshift(response.entity.job_history);
            this.updateLoggedUser(response.entity.job_history);
          }

          swal({title: response.entity.message, type: 'success', timer: 2000});
          this.cancelForm();

        }.bind(this),
        function (response) {
          switch (response.status.code) {
            case 405:
              swal({title: response.entity.message, type: 'warning', timer: 2000});
              break;
            case 422:
              $('#first_name').focus();
              swal({title: response.entity.message, type: 'error', timer: 2000});
              break;
          }
        });
    },

    updateLoggedUser: function (current_job_history) {

      if (this.logged.employee.data.id == this.employee.id) {
        this.logged.employee.data.job_history.data.job_title_id = current_job_history.job_title_id;
        localStorage.setItem('logged', btoa(JSON.stringify(this.logged)));
      }
    }
  }
};
