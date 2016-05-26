module.exports = {
  data: function () {

    return {
      navlinks: '',
      employment_status: {},
      job_titles: {},
      employee: {}
    };
  },

  ready: function () {

    this.$on('set-sidebar', function () {

      this.navlinks = JSON.parse(atob(localStorage.getItem('sidebar')));
      $('#side-menu').metisMenu();
    }.bind(this));
  }
};
