module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  compiled: function () {

    this.$dispatch('update-page-title', 'Employee List');
  },

  data: function () {

    return {
      employees: [{}]
    };
  },

  ready: function () {

    this.getEmployeeList();
  },

  methods: {
    getEmployeeList: function () {

      let params = {
        path: '/pim/employee-list',
        method: 'GET',
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      // retrieve employee list
      client(params).then(
        function (response) {

          this.employees = response.entity.employees;
        }.bind(this),
        function (response) {

          if (response.status.code == 422) {
            this.$route.router.go({
              name: 'error-404'
            });
            console.log(response.entity);
          }
        }.bind(this));
    }
  }
};
