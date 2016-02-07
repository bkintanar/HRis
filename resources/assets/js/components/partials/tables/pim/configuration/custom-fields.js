module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function(custom_field, index) {

      this.$parent.editRecord(custom_field, index);
    },

    deleteRecord: function(custom_field, index) {

      this.$parent.deleteRecord(custom_field, index);
    }
  }
};
