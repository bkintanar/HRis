module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function() {

    this.$dispatch('update-page-title', 'User Management');
  },

  route: {
    canReuse: false
  }
};
