module.exports = {
  methods: {
    doLogout: function() {

      localStorage.removeItem('avatar');
      localStorage.removeItem('employee_id');
      localStorage.removeItem('jwt-token');
      localStorage.removeItem('logged');
      localStorage.removeItem('permissions');
      localStorage.removeItem('sidebar');
      this.$route.router.go({ name: 'login' });
    }
  }
};
