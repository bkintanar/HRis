module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function () {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Emergency Contacts'
    );
  },

  data: function () {

    return {
      editMode: false,
      employee_id: '',
      emergency_contacts: [],
      relationships: [],
      relationships_chosen: [{}],
      relationship_obj: {},
      modal: {
        first_name: '',
        middle_name: '',
        last_name: '',
        relationship_id: '',
        home_phone: '',
        mobile_phone: '',
        id: 0
      },
      custom_field_sections: [{}]
    };
  },

  ready: function () {

    this.queryDatabase();
    this.chosenRelationships();

    $('#emergencyContactsForm').submit(function () {
      return false;
    });
  },

  methods: {
    queryDatabase: function () {

      if (this.$route.path.indexOf('/pim') > -1) {
        this.employee_id = this.$route.params.employee_id;
      } else {
        this.employee_id = localStorage.getItem('employee_id');
      }

      client({
        path: '/pim/configuration/custom-field-sections-by-screen-id',
        entity: {screen_name: 'Emergency Contacts'},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {

          this.custom_field_sections = response.entity.custom_field_sections;

        }.bind(this),

        function (response) {

          if (response.status.code == 422) {
            this.$route.router.go({
              name: 'error-404'
            });
            console.log(response.entity);
          }
        }.bind(this));

      let params = {
        method: 'GET',
        path: '/employee/' + this.employee_id + '?include=user,emergency_contacts',
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
        function (response) {

          this.$dispatch('update-employee', response.entity.data);
          this.custom_field_values = response.entity.data.custom_field_values;

          client({
            path: '/relationships?table_view=true',
            headers: {Authorization: localStorage.getItem('jwt-token')}
          }).then(
            function (response) {

              this.relationships = response.entity.data;
            }.bind(this));

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

    toggleModal: function () {

      this.editMode = false;

      this.modal.first_name = '';
      this.modal.middle_name = '';
      this.modal.last_name = '';
      this.modal.relationship_id = '';
      this.relationship_obj = '';
      this.modal.home_phone = '';
      this.modal.mobile_phone = '';

      $('#emergency_contact_modal').modal('toggle');
      $('#emergency_contact_modal').on('shown.bs.modal', function () {
        $('.vue-chosen', this).trigger('chosen:updated');
        $('#first_name').focus();
      });
    },

    submitForm: function () {

      // jasny bug work around
      $('#first_name').focus();

      this.modal.employee_id = this.employee.id;
      this.modal.relationship_id = this.relationship_obj.id;

      if (this.modal.relationship_id && this.modal.first_name && this.modal.last_name) {

        client({
          path: '/profile/emergency-contacts',
          method: this.editMode ? 'PATCH' : 'POST',
          entity: this.modal,
          headers: {Authorization: localStorage.getItem('jwt-token')}
        }).then(
          function (response) {
            $('#emergency_contact_modal').modal('toggle');
            if (this.editMode) {
              this.updateRowInTable();
              swal({title: response.entity.message, type: 'success', timer: 2000});
            } else {
              this.employee.emergency_contacts.data.push(response.entity.emergency_contact);
              swal({title: response.entity.message, type: 'success', timer: 2000});
            }

            $('.vue-chosen').trigger('chosen:updated');
          }.bind(this),
          function (response) {

            if (response.status.code == 422) {
              swal({title: response.entity.message, type: 'error', timer: 2000});
            }
          });
      } else {
        $('#emergency_contact_modal').on('shown.bs.modal', function () {
          $('.vue-chosen', this).trigger('chosen:open');
        });
      }
    },

    updateRowInTable: function () {

      this.employee.emergency_contacts.data[this.editIndex].first_name = this.modal.first_name;
      this.employee.emergency_contacts.data[this.editIndex].middle_name = this.modal.middle_name;
      this.employee.emergency_contacts.data[this.editIndex].last_name = this.modal.last_name;
      this.employee.emergency_contacts.data[this.editIndex].relationship_id = this.modal.relationship_id;
      this.employee.emergency_contacts.data[this.editIndex].home_phone = this.modal.home_phone;
      this.employee.emergency_contacts.data[this.editIndex].mobile_phone = this.modal.mobile_phone;
    },

    editRecord: function (emergency_contact, index) {

      this.editMode = true;
      this.editIndex = index;

      this.assignValuesToModal(emergency_contact);

      $('#emergency_contact_modal').modal('toggle');

      $('#emergency_contact_modal').on('shown.bs.modal', function () {
        $('.vue-chosen', this).trigger('chosen:updated');
      });

      $('#first_name').focus();
    },

    deleteRecord: function (emergency_contact, index) {

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
          client({
            path: '/profile/emergency-contacts/' + emergency_contact.id,
            method: 'DELETE',
            headers: {Authorization: localStorage.getItem('jwt-token')}
          }).then(
            function (response) {

              switch (response.status.code) {
                case 200:
                  swal({title: response.entity.message, type: 'success', timer: 2000});
                  this.employee.emergency_contacts.data.splice(index, 1);
                  break;
                case 500:
                  swal({title: response.entity.message, type: 'error', timer: 2000});
                  break;
              }
            }.bind(this));
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    assignValuesToModal: function (emergency_contact) {

      this.modal.id = emergency_contact.id;
      this.modal.first_name = emergency_contact.first_name;
      this.modal.middle_name = emergency_contact.middle_name;
      this.modal.last_name = emergency_contact.last_name;
      this.modal.relationship_id = emergency_contact.relationship_id;
      this.relationship_obj = this.relationships_chosen[emergency_contact.relationship_id - 1];
      this.modal.home_phone = emergency_contact.home_phone;
      this.modal.mobile_phone = emergency_contact.mobile_phone;
    },

    chosenRelationships: function () {

      // retrieve relationships
      client({
        path: '/relationships',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {

          if (response) {
            this.relationships_chosen = response.entity.chosen;
          }

          $('.vue-chosen').trigger('chosen:updated');
        }.bind(this));
    }
  }
};
