module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function (education_level, index) {

      this.$parent.editRecord(education_level, index);
    },

    deleteRecord: function (education_level, index) {

      this.$parent.deleteRecord(education_level, index);
    }
  }
};
