var Vue = require('vue');
var options = require('./options.js');

Vue.use(require('vue-resource'));
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

var app = new Vue(options).$mount('#app');