module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission'],
    replace: false,
    data: function () {
        return {
            employee: {
                user: {
                    data: {}
                },
                id: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                employee_id: '',
                face_id: '',
                gender: '',
                nationality_id: '',
                marital_status_id: '',
                job_history: [],
                emergency_contacts: {
                    data: []
                }
            },
            has_access: ''
        }
    },
    ready: function () {

        this.t = 1;

        var that = this;

        this.$on('userHasLoggedOut', function () {
            this.destroyLogin()
        });

        this.$on('userHasLoggedIn', function (user) {
            that.setLogin(user);
            localStorage.setItem('logged', btoa(JSON.stringify(user)));
            localStorage.setItem('employee_id', user.employee.data.employee_id);
            localStorage.setItem('avatar', user.employee.data.avatar);
            localStorage.setItem('permissions', btoa(JSON.stringify(user.role.data[0].permissions)));
        });

        this.$on('update-page-title', function (page_title) {
            that.page_title = page_title;
            var route = [];
            var route_path = this.$route.path.substr(1);
            var route_segments = route_path.split('/');

            var route_name = route_segments[0];
            for (var i = 0; i < route_segments.length; i++) {

                if (i && route_segments[i].indexOf('HRis') != 0) {
                    route_name += '-' + route_segments[i];
                }

                if (route_segments[i] == 'pim') {
                    route_segments[i] = 'PIM';
                    continue;
                } else if (route_segments[i].indexOf('HRis') != 0) {
                    route_segments[i] = route_segments[i].replace('-', ' ');
                    route_segments[i] = this.toTitleCase(route_segments[i]);
                }

                if (route_segments[i].indexOf('HRis') == 0) {
                    route.push({
                        'segment': route_segments[i],
                        'name': route_name + '-personal-details',
                        'params': {'employee_id': route_segments[i]}
                    });
                } else {
                    route.push({
                        'segment': route_segments[i],
                        'name': route_name,
                        'params': {'employee_id': route_segments[i - 1]}
                    });
                }
            }

            this.routes = route;
            this.preparePermission();

            document.title = 'HRis | ' + page_title;
        });

        this.$on('update-employee', function (employee) {

            var self = this;

            this.employee = employee;
            this.employee.birth_date = this.employee.birth_date ? this.employee.birth_date.date.substring(0, 10) : null;

            client({
                path: '/job-titles?table_view=true',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    self.job_titles = response.entity;
                    that.$broadcast('set-job-titles-default');
                    that.$broadcast('set-job-titles-action-area');
                },
                function (response) {
                    console.log(response);
                }
            );

            client({
                path: '/employment-statuses?table_view=true',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    self.employment_statuses = response.entity;
                },
                function (response) {
                    console.log(response);
                }
            );

            this.$broadcast('employee-loaded');
        });

        // The app has just been initialized, check if we can get the user data with an already existing token
        var token = localStorage.getItem('jwt-token');
        if (token !== null && token !== 'undefined') {
            var that = this;

            client({
                path: '/users/me?include=employee,role',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    // User has successfully logged in using the token from storage
                    that.setLogin(response);
                    // broadcast an event telling our children that the data is ready and views can be rendered
                    that.$broadcast('data-loaded')
                },
                function (response) {
                    // Login with our token failed, do some cleanup and redirect if we're on an authenticated route
                    that.destroyLogin()
                }
            );
        }
    },

    data: function () {
        return {
            user: null,
            token: null,
            authenticated: false
        }
    },

    methods: {

        setLogin: function (user) {

            var that = this;

            // Save login info in our data and set header in case it's not set already
            this.user = user;
            this.authenticated = true;
            client({
                method: 'POST',
                path: '/sidebar',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    localStorage.setItem('sidebar', btoa(response.entity.sidebar));
                    that.$broadcast('set-sidebar');
                }
            );
        },

        destroyLogin: function (user) {
            // Cleanup when token was invalid our user has logged out
            this.user = null;
            this.token = null;
            this.authenticated = false;
            localStorage.removeItem('avatar');
            localStorage.removeItem('employee_id');
            localStorage.removeItem('jwt-token');
            localStorage.removeItem('logged');
            localStorage.removeItem('permissions');
            localStorage.removeItem('sidebar');
            if (this.$route.auth) this.$route.router.go('/login')
        },

        toTitleCase: function (str) {
            return str.replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        },

        preparePermission: function () {
            var route_path = this.$route.path.substr(1); // removes the first character ('/') in the path
            var route_dotted = route_path.replace(/\//g, '.');
            var route_segment = route_path.split('/');
            var route_is_pim = route_segment[0] == 'pim';

            this.permission = route_dotted;
            if (route_is_pim) {
                route_segment = route_segment[route_segment.length - 1];
                this.permission = 'pim.' + route_segment;
            }

            this.route = {'path': route_path, 'dotted': route_dotted, 'segment': route_segment, 'pim': route_is_pim};

            this.has_access = JSON.parse(atob(localStorage.getItem('permissions')));
        }
    }

};
