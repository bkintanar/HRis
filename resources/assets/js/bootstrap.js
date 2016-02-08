// Import requirements using browserify
//window.Vue = require('vue');
//window.VueRouter = require('vue-router');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';

Vue.use(VueRouter);
Vue.use(VueResource);

// Insert vue-router and vue-resource into Vue

// Import the actual routes, aliases, ...
import { configRouter } from './routes';

// Create our router object and set options on it
const router = new VueRouter({});

// Inject the routes into the VueRouter object
configRouter(router);

// Configure the application
window.config = require('./config');
Vue.config.debug = true;

// Configure our HTTP client
var rest = require('rest');
var pathPrefix = require('rest/interceptor/pathPrefix');
var mime = require('rest/interceptor/mime');
var defaultRequest = require('rest/interceptor/defaultRequest');
var errorCode = require('rest/interceptor/errorCode');
var interceptor = require('rest/interceptor');
var jwtAuth = require('./interceptors/jwtAuth');

window.client = rest.wrap(pathPrefix, { prefix: config.api.base_url })
    .wrap(mime)
    .wrap(defaultRequest, config.api.defaultRequest)
    .wrap(errorCode, { code: 400 });

// Bootstrap the app
// HRis Components
Vue.component('copyleft', require('./compiled/partials/copyleft.vue'));
Vue.component('action-area', require('./compiled/partials/action-area.vue'));
Vue.component('navbar-static-side', require('./compiled/partials/navbar-static-side.vue'));
Vue.component('navbar-static-profile-top', require('./compiled/partials/navbar-static-profile-top.vue'));
Vue.component('navbar-static-top', require('./compiled/partials/navbar-static-top.vue'));
Vue.component('static-footer', require('./compiled/partials/static-footer.vue'));
Vue.component('chosen', require('./compiled/partials/chosen.vue'));
Vue.component('table-presenter', require('./compiled/partials/table.vue'));

// Partial Tables
Vue.component(
  'custom-field-sections',
  require('./compiled/partials/tables/pim/configuration/custom-field-sections.vue')
);
Vue.component(
  'custom-fields',
  require('./compiled/partials/tables/pim/configuration/custom-fields.vue')
);
Vue.component(
  'job-titles',
  require('./compiled/partials/tables/admin/job/titles.vue')
);

// Partial Profile
Vue.component('custom-field-section', require('./compiled/pages/profile/partials/custom-field-section.vue'));
Vue.component('custom-field-text', require('./compiled/pages/profile/partials/custom-field-text.vue'));
Vue.component('custom-field-drop-down', require('./compiled/pages/profile/partials/custom-field-drop-down.vue'));

const App = Vue.extend(require('./compiled/app.vue'));
router.start(App, 'body');
window.router = router;
