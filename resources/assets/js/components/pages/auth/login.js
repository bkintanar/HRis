module.exports = {

  compiled: function() {

    this.$dispatch('updatePageTitle', 'Login');
  },

  data: function() {

    return {
      user: {
        email: null,
        password: null
      },
      messages: []
    };
  },

  methods: {
    attempt: function(e) {

      e.preventDefault();

      let params = {
        path: '/login',
        entity: { email: this.user.email, password: this.user.password }
      };

      client(params).then(
      function(response) {
        localStorage.setItem('jwt-token', 'Bearer ' + response.entity.token);
        this.getUserData();
      }.bind(this),
      function(response) {
        this.messages = [];
        if (response.entity.status_code >= 400) {
          this.messages.push({ type: 'danger', message: 'Sorry, you provided invalid credentials' });
        }
      }.bind(this));
    },

    getUserData: function() {

      client({
        path: '/users/me?include=employee,role',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        var route = '/dashboard';

        this.$dispatch('userHasLoggedIn', response.entity.data);

        if (localStorage.hasOwnProperty('route-intended')) {
          route = localStorage.getItem('route-intended');
          localStorage.removeItem('route-intended');
        }

        this.$route.router.go(route);

      }.bind(this),
      function(response) {
        console.log(response);
      });
    }
  },

  route: {
    activate: function(transition) {

      this.$dispatch('userHasLoggedOut');
      transition.next();
    }
  }
};
