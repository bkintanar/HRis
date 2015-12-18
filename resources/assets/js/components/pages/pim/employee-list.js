module.exports = {

    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'],
    compiled: function () {
        this.$dispatch('update-page-title', 'Employee List');
    },
    data: function () {
        return {
            employees: [{}]
        }
    },
    ready: function() {
        this.getEmployeeList();
    },
    methods: {
        getEmployeeList: function () {

            var that = this;

            let params = {
                path: '/pim/employee-list',
                method: 'GET',
                entity: {'employee_id': this.employee_id},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            };

            // retrieve employee list
            client(params).then(
                function (response) {

                    that.employees = response.entity.employees;
                },
                function (response) {
                    if (response.status.code == 422) {
                        that.$route.router.go({
                            name: 'error-404'
                        });
                        console.log(response.entity);
                    }
                }
            );
        }
    }
}
