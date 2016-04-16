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

    this.queryDatabase(1);
  },

  methods: {
    queryDatabase: function(page) {

      let params = {
        method: 'GET',
        path: '/pim/configuration/custom-field-sections?page=' + page,
        entity: { employee_id: this.employee_id },
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

    editRecord: function(custom_field_section, index) {

      this.modal.editMode = true;
      this.modal.editIndex = index;

      this.assignValuesToModal(custom_field_section);

      $('#custom_field_section_modal').modal('toggle');
      $('#custom_field_section_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
      });
    },

    submitForm: function() {

      this.modal.screen_id = this.modal.screen_obj.id;

      client({
        path: '/pim/configuration/custom-field-sections',
        method: this.modal.editMode ? 'PATCH' : 'POST',
        entity: this.modal,
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        $('#custom_field_section_modal').modal('toggle');
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
      this.modal.screen_obj = this.modal.screens_chosen[this.modal.screen_id - 3];
      this.table.items.data[this.modal.editIndex].screen.name = this.modal.screen_obj.name;
      this.table.items.data[this.modal.editIndex].screen_id = this.modal.screen_id;
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
            path: '/pim/configuration/custom-field-sections/' + custom_field_section.id,
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

    assignValuesToModal: function(custom_field_section) {

      this.modal.name = custom_field_section.name;
      this.modal.screen_obj = this.modal.screens_chosen[custom_field_section.screen_id - 3];
      this.modal.custom_field_section_id = custom_field_section.id;
      this.modal.screen_name = custom_field_section.screen.name;
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

      $('#custom_field_section_modal').modal('toggle');

      $('#custom_field_section_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
      });
    }
  }
};
