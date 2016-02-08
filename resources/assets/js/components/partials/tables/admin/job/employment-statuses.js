module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function(job_title, index) {

      this.$parent.editRecord(job_title, index);
    },

    deleteRecord: function(job_title, index) {

      this.$parent.deleteRecord(job_title, index);
    }
  }
};
