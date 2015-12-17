module.exports = {

    ready: function () {
        this.$dispatch('updatePageTitle', 'Login');
    },

    data: function () {
        return {
            user: {
                email: null,
                password: null
            },
            messages: []
        }
    },

    methods: {
        attempt: function (e) {
            e.preventDefault();
            var that = this;

            let params = {
                path: '/login',
                entity: {'email': this.user.email, 'password': this.user.password}
            };

            client(params).then(
                function (response) {
                    localStorage.setItem('jwt-token', 'Bearer ' + response.entity.token);
                    that.getUserData();
                },
                function (response) {
                    that.messages = [];
                    if (response.entity.error) {
                        that.messages.push({type: 'danger', message: 'Sorry, you provided invalid credentials'});
                    }
                }
            );
        },

        getUserData: function () {
            var that = this;

            client({
                path: '/users/me?include=employee,role',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {

                    that.$dispatch('userHasLoggedIn', response.entity.data);
                    that.$route.router.go('/dashboard');
                },
                function (response) {
                    console.log(response);
                }
            );
        }
    },

    route: {
        activate: function (transition) {
            this.$dispatch('userHasLoggedOut');
            transition.next();
        }
    }
};
