module.exports = {
  props: [
    'table', 'has_access', 'modal'
  ],

  methods: {

    editRecord: function (pay_grade, index) {

      this.$parent.editRecord(pay_grade, index);
    },

    deleteRecord: function (pay_grade, index) {

      this.$parent.deleteRecord(pay_grade, index);
    },

    preciseDiff: function (time_in, time_out) {

      if (!time_out) {
        time_out = moment.utc(moment.now());
      }

      var pd = moment.preciseDiff(time_in, time_out);

      return pd.replace('hours', 'hrs.')
        .replace('hour', 'hr.')
        .replace('minutes', 'mins.')
        .replace('minute', 'min.')
        .replace('seconds', 'secs.')
        .replace('second', 'sec.');
    }
  }
};
