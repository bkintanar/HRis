module.exports = {
    methods: {
        doLogout: function () {
            var self = this;

            client({
                path: '/logout',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    localStorage.removeItem('avatar');
                    localStorage.removeItem('employee_id');
                    localStorage.removeItem('jwt-token');
                    localStorage.removeItem('logged');
                    localStorage.removeItem('permissions');
                    localStorage.removeItem('sidebar');
                    self.$route.router.go({name: 'login'});
                }
            );
        }
    }
};
