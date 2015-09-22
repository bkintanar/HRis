module.exports = {
    data: {
        view: 'calendar'
    },
    methods: {
        isView: function(view) {
            return this.view == view ? true : false;
        },
        setView: function(view) {
            this.$event.preventDefault();
            this.view = view;
        }
    }
}