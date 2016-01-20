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
        custom_field_id: 0,
        editMode: false,
        name: '',
        screen_obj: {},
        screens_chosen: [{}],
        type_obj: {},
        types_chosen: [{}],
        required: false,
        mask: ''
      },
      screens: []
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

    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green'
    });
  },

  methods: {
    queryDatabase: function() {

      let params = {
        method: 'GET',
        path: '/pim/configuration/custom-fields?custom_field_section_id='+this.$route.params.custom_field_section_id,
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
      this.modal.type_id = this.modal.type_obj.id;
      this.modal.custom_field_section_id = this.$route.params.custom_field_section_id;

      this.modal.required = false;
      if (document.querySelector('#required:checked') != null)
      {
        this.modal.required = true;
      }

      client({
        path: '/pim/configuration/custom-fields',
        method: this.modal.editMode ? 'PATCH' : 'POST',
        entity: this.modal,
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {

        $('#custom_field_modal').modal('toggle');
        if (this.modal.editMode) {
          this.updateRowInTable();
          swal({title: response.entity.message, type: 'success', timer: 2000});
        } else {
          this.table.items.push(response.entity.custom_field);
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
      this.modal.type_obj = this.modal.types_chosen[this.modal.type_id - 1];
      this.table.items[this.modal.editIndex].type.id = this.modal.type_obj.id;
      this.table.items[this.modal.editIndex].type.has_options = this.hasOptions(this.modal.type_obj.id);
      this.table.items[this.modal.editIndex].type.name = this.modal.type_obj.name;
      this.table.items[this.modal.editIndex].type_id = this.modal.type_id;
      this.table.items[this.modal.editIndex].mask = this.modal.mask;
      this.table.items[this.modal.editIndex].required = this.modal.required;
    },

    hasOptions: function(id) {

      let has_options = [2, 7, 8];

      return has_options.indexOf(id) != -1;
    }
  }
};
