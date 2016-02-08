module.exports = {
  props: [
    'table', 'has_access', 'name', 'modal'
  ],

  methods: {

    editRecord: function(model, index) {

      this.$parent.editRecord(model, index);
    },

    deleteRecord: function(model, index) {

      this.$parent.deleteRecord(model, index);
    },

    toggleModal: function() {

      this.modal.editMode = false;

      this.$parent.toggleModal();
    },

    goto: function(page) {

      let count = this.table.items.total - 1 % 10;

      if (this.table.items.current_page == this.table.items.last_page && (count % 10 == 0)) {
        page = page - 1;
      }

      this.$parent.queryDatabase(page);
    }
  }
};
