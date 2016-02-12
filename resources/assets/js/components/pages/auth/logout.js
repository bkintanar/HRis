module.exports = {

  route: {
    activate: function(transition) {

      this.$root.authenticated = false;
      this.$root.user = null;

      localStorage.removeItem('user');
      localStorage.removeItem('jwt-token');
      localStorage.removeItem('logged');
      localStorage.removeItem('employee_id');
      localStorage.removeItem('avatar');
      localStorage.removeItem('permissions');

      transition.redirect('/');
    }
  }
};
