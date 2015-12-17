module.exports = {
    data: function () {
        return {
            navlinks: '',
            employment_status: {},
            job_titles: {},
            employee: {}
        }
    },
    ready: function () {
        var that = this;
        var that = this;
        this.$on('set-sidebar', function () {
            that.navlinks = JSON.parse(atob(localStorage.getItem('sidebar')));
            $('#side-menu').metisMenu();
        });
    }
};
