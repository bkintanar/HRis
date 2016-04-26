module.exports = {
  props: [
    'employee', 'job_titles', 'employment_statuses'
  ],

  route: {
    canReuse: false
  },

  ready: function() {
    $('img').load(function(){
      $(this).css('background','none');
    });
  }
};
