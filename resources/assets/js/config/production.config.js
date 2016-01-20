var protocol = (location.protocol === 'https:') ? 'https://' : 'http://';

var config = {
  env: 'production',
  api: {
    base_url: protocol + '//api.hris.dev/api',
    defaultRequest: {
      headers: {
        'X-Requested-With': 'rest.js',
        'Content-Type': 'application/json'
      }
    }
  },
  social: {
    facebook: '',
    twitter: '',
    github: ''
  },
  debug: false
};

module.exports = config;
