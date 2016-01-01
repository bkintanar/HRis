module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  compiled: function() {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Contact Details'
    );
  },

  data: function() {

    return {
      id: '',
      address_city_obj: {},
      address_province_obj: {},
      address_country_obj: {},
      city: '',
      cities_chosen: [{}],
      province: '',
      provinces_chosen: [{}],
      country: '',
      countries_chosen: [{}]
    };

  },

  watch: {
    address_province_obj: function() {

      // retrieve cities
      if (this.address_province_obj) {
        this.chosenCities(this.address_province_obj.id, false);

        // call twice since there's a bug in chosen.js vue directive.
        this.chosenCities(this.address_province_obj.id, true);
      }
    },

    cities_chosen: function() {

      for (var i = 0; i < this.cities_chosen.length; i++) {
        if (this.employee.address_city_id == this.cities_chosen[i].id) {
          this.address_city_obj = this.cities_chosen[i];
          break;
        }
      }
    }
  },

  ready: function() {

    this.queryDatabase();
  },

  methods: {
    queryDatabase: function() {

      if (this.$route.path.indexOf('/pim') > -1) {
        this.employee_id = this.$route.params.employee_id;
      } else {
        this.employee_id = localStorage.getItem('employee_id');
      }

      let params = {
        path: '/employee/get-by-employee-id?include=user',
        entity: {employee_id: this.employee_id},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
      function(response) {

        this.$dispatch('update-employee', response.entity.data);

        this.chosenProvinces();
        this.chosenCountries();
      }.bind(this),
      function(response) {

        console.log(response);
      });
    },

    submitForm: function() {

      // jasny bug work around
      $('#address_1').focus();

      // Set values
      this.employee.address_city_id = this.address_city_obj.id;
      this.employee.address_province_id = this.address_province_obj.id;
      this.employee.address_country_id = this.address_country_obj.id;

      let params = {
        path: '/profile/contact-details',
        method: 'PATCH',
        entity: {employee: this.employee},
        headers: {Authorization: localStorage.getItem('jwt-token')}
      };

      client(params).then(
      function(response) {

        switch (response.status.code) {
          case 200:

            if (this.$route.path.indexOf('/pim') > -1) {
              this.$route.router.go({
                name: 'pim-employee-list-contact-details',
                params: {employee_id: response.entity.employee.employee_id}
              });
            }

            swal({title: response.entity.status, type: 'success', timer: 2000});
            this.cancelForm();
            break;
          case 405:
            swal({title: response.entity.status, type: 'warning', timer: 2000});
            break;
          case 500:
            $('#first_name').focus();
            swal({title: response.entity.status, type: 'error', timer: 2000});
            break;
        }
      }.bind(this));
    },

    modifyForm: function() {

      $('.save-form').css('display', '');
      $('.modify-form').css('display', 'none');
      $('.vue-chosen').prop('disabled', false).trigger('chosen:updated');
      $('.form-control').prop('disabled', false);

      $('#address_1').focus();
    },

    cancelForm: function() {

      // retrieve original data since cancel button was pressed.
      this.queryDatabase();

      $('.save-form').css('display', 'none');
      $('.modify-form').css('display', '');
      $('.vue-chosen').prop('disabled', true).trigger('chosen:updated');
      $('.form-control').prop('disabled', true);
    },

    chosenProvinces: function() {

      // retrieve provinces
      client({
        path: '/provinces',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {

        if (response) {
          this.provinces_chosen = response.entity;
        }

        this.address_province_obj = this.provinces_chosen[this.employee.address_province_id - 1];
      }.bind(this));
    },

    chosenCountries: function() {

      // retrieve countries
      client({
        path: '/countries',
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {

        if (response) {
          this.countries_chosen = response.entity;
        }

        this.address_country_obj = this.countries_chosen[this.employee.address_country_id - 1];
      }.bind(this));
    },

    chosenCities: function(value, open) {

      // retrieve cities
      client({
        path: '/cities?province_id=' + value,
        headers: {Authorization: localStorage.getItem('jwt-token')}
      }).then(
      function(response) {

        if (response) {
          this.cities_chosen = response.entity;
        }

        $('.vue-chosen').trigger('chosen:updated');

        if (open) {
          $('#address_city_id').trigger('chosen:open');
        }
      }.bind(this));
    }
  }
};
