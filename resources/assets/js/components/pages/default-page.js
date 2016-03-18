module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged', 'custom_field_values'
  ],

  compiled: function() {

    var properties = [
      localStorage.hasOwnProperty('logged'),
      localStorage.hasOwnProperty('employee_id'),
      localStorage.hasOwnProperty('avatar'),
      localStorage.hasOwnProperty('permissions')
    ];

    for (var property in properties) {

      if (!properties[property]) {
        parent.destroyLogin();
        this.$route.router.go('/login');
        localStorage.setItem('route-intended', this.$route.path);
      }
    }

    this.logged = JSON.parse(atob(localStorage.getItem('logged')));
    this.logged.employee_id = localStorage.getItem('employee_id');
    this.logged.avatar = localStorage.getItem('avatar');
    this.logged.has_access = JSON.parse(atob(localStorage.getItem('permissions')));
  }
};
