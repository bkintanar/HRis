var protocol = (location.protocol === 'https:') ? 'https://' : 'http://';

var config = {
  env: 'development',
  api: {
    base_url: protocol + '//api.hris.dev/api',
    defaultRequest: {
      headers: {
        'Content-Type': 'application/json'
      }
    }
  },
  social: {
    facebook: '',
    twitter: '',
    github: ''
  },
  debug: true
};

module.exports = config;
