module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function(custom_field_section, index) {

      this.modal.editMode = true;
      this.modal.editIndex = index;

      this.assignValuesToModal(custom_field_section);

      $('#custom_field_section_modal').modal('toggle');
      $('#custom_field_section_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
      });
    },

    deleteRecord: function(custom_field_section, index) {

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
            path: '/pim/configuration/custom-field-sections',
            method: 'DELETE',
            entity: { id: custom_field_section.id },
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
          function(response) {

            swal({ title: response.entity.message, type: 'success', timer: 2000 });
            this.table.items.splice(index, 1);

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

    assignValuesToModal: function(custom_field_section) {

      this.modal.name = custom_field_section.name;
      this.modal.screen_obj = this.modal.screens_chosen[custom_field_section.screen_id - 3];
      this.modal.custom_field_section_id = custom_field_section.id;
      this.modal.screen_name = custom_field_section.screen.name;
    }
  }
};
