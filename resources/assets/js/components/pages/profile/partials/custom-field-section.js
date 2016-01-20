module.exports = {
  props: ['employee', 'custom_field_sections', 'has_access', 'permission', 'custom_field_values'],

  route: {
    canReuse: false
  },

  data: function() {
    return {
      custom_field_value_objs: [{}]
    }
  },

  methods: {

    submitForm: function() {

      let params = {
        path: '/profile/custom-fields',
        method: 'PATCH',
        entity: { custom_field_values: this.custom_field_values, employee_id: this.employee.id },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      };

      client(params).then(
      function(response) {

        swal({ title: response.entity.message, type: 'success', timer: 2000 });
        this.cancelForm();

      }.bind(this),
      function(response) {

        switch (response.status.code) {
          case 405:
            swal({ title: response.entity.message, type: 'warning', timer: 2000 });
            break;
          case 422:
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
            break;
        }

      });
    },

    modifyForm: function() {
      $('.save-form').css('display', '');
      $('.modify-form').css('display', 'none');
      $('.vue-chosen').prop('disabled', false).trigger('chosen:updated');

      $('.form-control').prop('disabled', false);
      $('.i-checks').iCheck('enable');
    },

    cancelForm: function() {

      $('.save-form').css('display', 'none');
      $('.modify-form').css('display', '');
      $('.vue-chosen').prop('disabled', true).trigger('chosen:updated');

      $('.form-control').prop('disabled', true);
      $('.i-checks').iCheck('disable');
    }
  }
};
