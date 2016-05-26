module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function (custom_field_section, index) {

      this.$parent.editRecord(custom_field_section, index);
    },

    deleteRecord: function (custom_field_section, index) {

      this.$parent.deleteRecord(custom_field_section, index);
    }
  }
};
