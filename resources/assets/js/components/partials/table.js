module.exports = {
  props: [
    'table', 'has_access', 'name', 'modal'
  ],

  methods: {

    toggleModal: function(name) {

      this.modal.editMode = false;

      switch (name) {
        case 'custom-field-sections':

          this.modal.name = null;

          $('#custom_field_section_modal').modal('toggle');

          $('#custom_field_section_modal').on('shown.bs.modal', function() {
            $('.vue-chosen', this).trigger('chosen:updated');
          });

          break;

        case 'custom-fields':

          this.modal.name = null;
          this.modal.type_obj = null;
          this.modal.mask = null;
          this.modal.required = null;
          this.modal.custom_field_options = null;

          $('#custom_field_modal').modal('toggle');
          $('#custom_field_modal').on('shown.bs.modal', function() {
            $('.vue-chosen', this).trigger('chosen:updated');
            $('#custom_field_options').tagsinput('removeAll');
          });

        default:

      }
    }
  }
};
