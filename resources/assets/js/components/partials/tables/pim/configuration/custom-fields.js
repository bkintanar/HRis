module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {
    editRecord: function(custom_field, index) {
      this.modal.editMode = true;
      this.modal.editIndex = index;

      this.assignValuesToModal(custom_field);

      $('#custom_field_modal').modal('toggle');
      $('#custom_field_modal').on('shown.bs.modal', function() {

        if (custom_field.type.has_options) {
          $.each(custom_field.options, function(index, value) {
            //console.log(value);
            $('#custom_field_options').tagsinput('add', value.name);
          });
        }

        $('.vue-chosen', this).trigger('chosen:updated');
        $('.i-checks').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green'
        });
      }.bind(this));
    },

    deleteRecord: function(custom_field, index) {

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
            path: '/pim/configuration/custom-fields',
            method: 'DELETE',
            entity: { id: custom_field.id },
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

    assignValuesToModal: function(custom_field) {

      this.modal.name = custom_field.name;
      this.modal.type_obj = this.modal.types_chosen[custom_field.type.id - 1];
      this.modal.custom_field_id = custom_field.id;
      this.modal.required = custom_field.required ? true : false;
      this.modal.mask = custom_field.mask;

      $('#custom_field_options').tagsinput();
    }
  }
};
