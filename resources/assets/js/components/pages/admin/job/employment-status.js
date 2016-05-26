module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  data: function () {

    return {
      table: {
        model: {
          dashed: ''
        },
        items: [{}]
      },
      modal: {
        employment_status_id: 0,
        editMode: false,
        name: '',
        class: '',
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

  compiled: function () {

    this.$dispatch('update-page-title', 'Employment Statuses');
  },

  ready: function () {

    this.queryDatabase(1);
  },

  methods: {
    queryDatabase: function (page) {

      let params = {
        method: 'GET',
        path: '/admin/job/employment-status?page=' + page,
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
        function (response) {

          this.table = response.entity.table;

        }.bind(this),
        function (response) {

          console.log(response);
        });
    },

    editRecord: function (employment_status, index) {

      this.modal.editMode = true;
      this.modal.editIndex = index;

      this.assignValuesToModal(employment_status);

      $('#employment_status_modal').modal('toggle');
      $('#employment_status_modal').on('shown.bs.modal', function () {
        $('.vue-chosen', this).trigger('chosen:updated');
      });
    },

    submitForm: function () {
      client({
        path: '/admin/job/employment-status',
        method: this.modal.editMode ? 'PATCH' : 'POST',
        entity: this.modal,
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
        function (response) {

          $('#employment_status_modal').modal('toggle');
          if (this.modal.editMode) {
            this.updateRowInTable();
            swal({title: response.entity.message, type: 'success', timer: 2000});
          } else {

            let page = this.table.items.last_page;

            this.queryDatabase(page);

            swal({title: response.entity.message, type: 'success', timer: 2000});
          }
        }.bind(this),
        function (response) {
          if (response.status.code == 422) {
            swal({title: response.entity.message, type: 'error', timer: 2000});
          }
        });
    },

    deleteRecord: function (employment_status) {

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
            path: '/admin/job/employment-status',
            method: 'DELETE',
            entity: {id: employment_status.id},
            headers: {Authorization: localStorage.getItem('jwt-token')}
          }).then(
            function (response) {

              this.goto(this.table.items.current_page);

              swal({title: response.entity.message, type: 'success', timer: 2000});

            }.bind(this),
            function (response) {

              if (response.status.code == 422) {
                swal({title: response.entity.message, type: 'error', timer: 2000});
              }

            });
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    updateRowInTable: function () {

      this.table.items.data[this.modal.editIndex].name = this.modal.name;
      this.table.items.data[this.modal.editIndex].class = this.modal.class;
    },

    assignValuesToModal: function (employment_status) {

      this.modal.id = employment_status.id;
      this.modal.name = employment_status.name;
      this.modal.class = employment_status.class;
    },

    goto: function (page) {

      let count = this.table.items.total - 1 % 10;

      if (this.table.items.current_page == this.table.items.last_page && (count % 10 == 0)) {
        page = page - 1;
      }

      this.queryDatabase(page);
    },

    toggleModal: function () {

      this.modal.name = null;
      this.modal.class = null;

      $('#employment_status_modal').modal('toggle');
    }
  }
};
