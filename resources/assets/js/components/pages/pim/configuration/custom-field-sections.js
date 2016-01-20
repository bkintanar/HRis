module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  data: function() {

    return {
      table: {
        model: {
          dashed: ''
        }
      },
      modal: {
        custom_field_section_id: 0,
        editMode: false,
        name: '',
        screen_obj: {},
        screens_chosen: [{}],
        type_obj: {},
        types_chosen: [{}],
        required: false,
        mask: ''
      },
      screens: [],
      types: []
    };

  },

  route: {
    canReuse: false
  },

  compiled: function() {

    this.$dispatch('update-page-title', 'Custom Field Sections');
  },

  ready: function() {

    this.queryDatabase();
  },

  methods: {
    queryDatabase: function() {

      let params = {
        method: 'GET',
        path: '/pim/configuration/custom-field-sections',
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
      function(response) {

        this.table = response.entity.table;
        this.chosenScreens();
        this.chosenTypes();
      }.bind(this),
      function(response) {

        console.log(response);
      });
    },

    chosenScreens: function() {

      // retrieve screens
      client({
        path: '/screens',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {
        if (response) {
          this.modal.screens_chosen = response.entity;
        }

        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    },

    chosenTypes: function() {

      // retrieve types
      client({
        path: '/types',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {
        if (response) {
          this.modal.types_chosen = response.entity;
        }

        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    },

    submitForm: function() {

      this.modal.screen_id = this.modal.screen_obj.id;

      client({
        path: '/pim/configuration/custom-field-sections',
        method: this.modal.editMode ? 'PATCH' : 'POST',
        entity: this.modal,
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {

        $('#custom_field_section_modal').modal('toggle');
        if (this.modal.editMode) {
          this.updateRowInTable();
          swal({title: response.entity.message, type: 'success', timer: 2000});
        } else {
          this.table.items.push(response.entity.custom_field_section);
          swal({title: response.entity.message, type: 'success', timer: 2000});
        }
      }.bind(this),
      function(response) {
        if (response.status.code == 422) {
          swal({title: response.entity.message, type: 'error', timer: 2000});
        }
      });
    },

    updateRowInTable: function() {

      this.table.items[this.modal.editIndex].name = this.modal.name;
      this.modal.screen_obj = this.modal.screens_chosen[this.modal.screen_id - 3];
      this.table.items[this.modal.editIndex].screen.name = this.modal.screen_obj.name;
      this.table.items[this.modal.editIndex].screen_id = this.modal.screen_id;
    }
  }
};
