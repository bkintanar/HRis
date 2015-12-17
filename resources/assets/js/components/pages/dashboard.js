module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'],
    route: {
        canReuse: false
    },
    compiled: function () {
        this.$dispatch('update-page-title', 'Dashboard');
    },
    ready: function () {
        var that = this;

        if (this.$route.path.indexOf('/pim') > -1) {
            this.employee_id = this.$route.params.employee_id;
        } else {
            this.employee_id = localStorage.getItem('employee_id');
        }

        let params = {
            path: '/employee/get-by-employee-id?include=user',
            entity: {'employee_id': this.employee_id},
            headers: {'Authorization': localStorage.getItem('jwt-token')}
        };

        client(params).then(
            function (response) {

                that.$dispatch('update-employee', response.entity.data);
            });
    }
};
