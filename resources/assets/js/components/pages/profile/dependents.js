module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function() {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Dependents'
    );
  },

  data: function() {

    return {
      editMode: false,
      employee_id: '',
      dependents: [],
      relationships: [],
      relationships_chosen: [{}],
      relationship_obj: {},
      modal: {
        first_name: '',
        middle_name: '',
        last_name: '',
        relationship_id: '',
        birth_date: '',
        dependent_id: 0
      },
      custom_field_sections: [{}]
    };
  },

  ready: function() {

    this.queryDatabase();
    this.chosenRelationships();

    $('#dependentsForm').submit(function() {
      return false;
    });
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
        entity: { screen_name: 'Dependents' },
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
        method: 'GET',
        path: '/employee/' + this.employee_id + '?include=user,dependents',
        entity: { employee_id: this.employee_id },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      };

      client(params).then(
      function(response) {

        this.$dispatch('update-employee', response.entity.data);
        this.custom_field_values = response.entity.data.custom_field_values;

        client({
          path: '/relationships?table_view=true',
          headers: { Authorization: localStorage.getItem('jwt-token') }
        }).then(
              function(response) {
                this.relationships = response.entity.data;
              }.bind(this));

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

    toggleModal: function() {

      this.editMode = false;

      this.modal.first_name = '';
      this.modal.middle_name = '';
      this.modal.last_name = '';
      this.modal.relationship_id = '';
      this.relationship_obj = '';
      this.modal.birth_date = '';

      // datepicker for birth_date
      $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      });

      $('#dependent_modal').modal('toggle');
      $('#dependent_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
        $('#first_name').focus();
      });
    },

    submitForm: function() {

      // jasny bug work around
      $('#first_name').focus();

      this.modal.employee_id = this.employee.id;
      this.modal.relationship_id = this.relationship_obj.id;

      if (this.modal.relationship_id && this.modal.first_name && this.modal.last_name) {

        client({
          path: '/profile/dependents',
          method: this.editMode ? 'PATCH' : 'POST',
          entity: this.modal,
          headers: { Authorization: localStorage.getItem('jwt-token') }
        }).then(
        function(response) {

          $('#dependent_modal').modal('toggle');
          if (this.editMode) {
            this.updateRowInTable();
            swal({ title: response.entity.message, type: 'success', timer: 2000 });
          } else {
            this.employee.dependents.data.push(response.entity.dependent);
            swal({ title: response.entity.message, type: 'success', timer: 2000 });
          }

          $('.vue-chosen').trigger('chosen:updated');

        }.bind(this),
        function(response) {

          if (response.status.code == 422) {
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
          }

        });
      } else {
        $('#dependent_modal').on('shown.bs.modal', function() {
          $('.vue-chosen', this).trigger('chosen:open');
        });
      }
    },

    updateRowInTable: function() {

      this.employee.dependents.data[this.editIndex].first_name = this.modal.first_name;
      this.employee.dependents.data[this.editIndex].middle_name = this.modal.middle_name;
      this.employee.dependents.data[this.editIndex].last_name = this.modal.last_name;
      this.employee.dependents.data[this.editIndex].relationship_id = this.modal.relationship_id;
      this.employee.dependents.data[this.editIndex].birth_date = this.modal.birth_date;
    },

    editRecord: function(dependent, index) {

      this.editMode = true;
      this.editIndex = index;

      this.assignValuesToModal(dependent);

      // datepicker for birth_date
      $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      });

      $('#dependent_modal').modal('toggle');
      $('#dependent_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
      });

      $('#first_name').focus();
    },

    deleteRecord: function(dependent, index) {

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
      }, function(isConfirm) {
        swal.disableButtons();
        window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
        if (isConfirm) {
          client({
            path: '/profile/dependents',
            method: 'DELETE',
            entity: { id: dependent.id },
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
          function(response) {

            swal({ title: response.entity.message, type: 'success', timer: 2000 });
            this.employee.dependents.data.splice(index, 1);

          }.bind(this),
          function(response) {

            if (response.status.code == 422) {
              swal({ title: response.entity.message, type: 'error', timer: 2000 });
            }

          });
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    assignValuesToModal: function(dependent) {

      this.modal.id = dependent.id;
      this.modal.first_name = dependent.first_name;
      this.modal.middle_name = dependent.middle_name;
      this.modal.last_name = dependent.last_name;
      this.modal.relationship_id = dependent.relationship_id;
      this.relationship_obj = this.relationships_chosen[dependent.relationship_id - 1];
      this.modal.birth_date = dependent.birth_date.substring(0, 10);
    },

    chosenRelationships: function() {

      // retrieve relationshops
      client({
        path: '/relationships',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {
        if (response) {
          this.relationships_chosen = response.entity.chosen;
        }

        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    }
  }
};
