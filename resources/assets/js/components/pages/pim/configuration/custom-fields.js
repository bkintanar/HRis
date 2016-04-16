module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  data: function() {

    return {
      table: {
        model: {
          dashed: ''
        },
        items: [{}]
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

    this.queryDatabase(1);

    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green'
    });
  },

  methods: {
    queryDatabase: function(page) {

      let params = {
        method: 'GET',
        path: '/pim/configuration/custom-fields?custom_field_section_id=' + this.$route.params.custom_field_section_id + '&page=' + page,
        headers: { Authorization: localStorage.getItem('jwt-token') }
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
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
          function(response) {
            if (response) {
              this.modal.screens_chosen = response.entity.chosen;
            }

            $('.vue-chosen').trigger('chosen:updated');
          }.bind(this));
    },

    chosenTypes: function() {

      // retrieve types
      client({
        path: '/types',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
          function(response) {
            if (response) {
              this.modal.types_chosen = response.entity.chosen;
            }

            $('.vue-chosen').trigger('chosen:updated');
          }.bind(this));
    },

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
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        $('#custom_field_modal').modal('toggle');
        if (this.modal.editMode) {
          this.updateRowInTable();
          swal({ title: response.entity.message, type: 'success', timer: 2000 });
        } else {

          let page = this.table.items.current_page;

          this.queryDatabase(page);

          swal({ title: response.entity.message, type: 'success', timer: 2000 });
        }

      }.bind(this),
      function(response) {
        if (response.status.code == 422) {
          swal({ title: response.entity.message, type: 'error', timer: 2000 });
        }
      });
    },

    updateRowInTable: function() {

      this.table.items.data[this.modal.editIndex].name = this.modal.name;
      this.modal.type_obj = this.modal.types_chosen[this.modal.type_id - 1];
      this.table.items.data[this.modal.editIndex].type.id = this.modal.type_obj.id;
      this.table.items.data[this.modal.editIndex].type.has_options = this.hasOptions(this.modal.type_obj.id);
      this.table.items.data[this.modal.editIndex].type.name = this.modal.type_obj.name;
      this.table.items.data[this.modal.editIndex].type_id = this.modal.type_id;
      this.table.items.data[this.modal.editIndex].mask = this.modal.mask;
      this.table.items.data[this.modal.editIndex].required = this.modal.required;
    },

    hasOptions: function(id) {

      let has_options = [2, 7, 8];

      return has_options.indexOf(id) != -1;
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
            path: '/pim/configuration/custom-fields/' + custom_field.id,
            method: 'DELETE',
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
              function(response) {

                this.goto(this.table.items.current_page);

                swal({ title: response.entity.message, type: 'success', timer: 2000 });

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
    },

    goto: function(page) {

      let count = this.table.items.total - 1 % 10;

      if (this.table.items.current_page == this.table.items.last_page && (count % 10 == 0)) {
        page = page - 1;
      }

      this.queryDatabase(page);
    },

    toggleModal: function() {

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
    }
  }
};
