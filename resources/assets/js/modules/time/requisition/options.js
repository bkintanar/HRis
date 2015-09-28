module.exports = {
    data: {
        sidebar: 0
    },
    methods: {
        isSidebar: function(index) {
            return this.sidebar == index ? true : false;
        },
        setSidebar: function(index) {
            this.$event.preventDefault();
            this.sidebar = index;
        }
    }
}