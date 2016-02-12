module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function(pay_grade, index) {

      this.$parent.editRecord(pay_grade, index);
    },

    deleteRecord: function(pay_grade, index) {

      this.$parent.deleteRecord(pay_grade, index);
    }
  }
};
