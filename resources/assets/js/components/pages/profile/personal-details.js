module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'],
    compiled: function () {
        this.$dispatch('update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Personal Details');
    },

    route: {
        canReuse: false
    },

    data: function () {
        return {
            id: '',
            nationality: '',
            nationality_obj: {},
            marital_status_obj: {},
            nationalities_chosen: [{}],
            marital_status: '',
            marital_statuses_chosen: [{}],
            original_employee_id: ''
        }

    },
    ready: function () {
        this.queryDatabase();
    },
    methods: {

        queryDatabase: function () {
            if (this.$route.path.indexOf('/pim') > -1) {
                this.employee_id = this.$route.params.employee_id;
            } else {
                this.employee_id = localStorage.getItem('employee_id');
            }

            let params = {
                path: '/employee/get-by-employee-id?include=user',
                entity: {'employee_id': this.employee_id},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            };

            client(params).then(
                function (response) {

                    this.$dispatch('update-employee', response.entity.data);

                    this.original_employee_id = response.entity.data.employee_id;

                    this.chosenNationalities();
                    this.chosenMaritalStatuses();

                    var maritalStatusChosenWatcher = setInterval(function () {
                        if (this.employee != null) {
                            // iCheck
                            $('.i-checks').iCheck({
                                checkboxClass: 'icheckbox_square-green',
                                radioClass: 'iradio_square-green'
                            });
                            clearInterval(maritalStatusChosenWatcher);
                        }
                    }, 1);

                    if (this.employee) {
                        $('input[name="gender"]').on('ifChecked', function (event) {
                            this.employee.gender = this.value;
                        });

                        this.switchGender(this.employee.gender);
                    }
                }.bind(this),
                function (response) {
                    if (response.status.code == 422) {
                        this.$route.router.go({
                            name: 'error-404'
                        });
                        console.log(response.entity);
                    }
                }.bind(this)
            );
        },
        submitForm: function () {
            var self = this;

            // jasny bug work around
            $('#first_name').focus();

            this.employee.marital_status_id = this.marital_status_obj.id;
            this.employee.nationality_id = this.nationality_obj.id;

            let params = {
                path: '/profile/personal-details',
                method: 'PATCH',
                entity: {'employee': this.employee},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            };

            client(params).then(
                function (response) {
                    switch (response.status.code) {
                        case 200:

                            self.updateLocalStorage(response.entity.employee.employee_id);

                            if (self.$route.path.indexOf('/pim') > -1) {
                                self.$route.router.go({
                                    name: 'pim-employee-list-personal-details',
                                    params: {employee_id: response.entity.employee.employee_id}
                                });
                            }

                            self.$route.params.employee_id = response.entity.employee.employee_id;
                            swal({title: response.entity.status, type: 'success', timer: 2000});
                            self.cancelForm();
                            break;
                        case 405:
                            swal({title: response.entity.status, type: 'warning', timer: 2000});
                            break;
                        case 500:
                            $('#first_name').focus();
                            swal({title: response.entity.status, type: 'error', timer: 2000});
                            break;
                    }
                }
            );
        },
        modifyForm: function () {

            $('.avatar').css('display', '');
            $('.job-title').css('display', 'none');

            $('.save-form').css('display', '');
            $('.modify-form').css('display', 'none');
            $('.vue-chosen').prop('disabled', false).trigger("chosen:updated");
            $('.form-control').prop('disabled', false);
            $('.i-checks').iCheck('enable');

            // datepicker for birth_date
            $('.input-group.date').datepicker({
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: true,
                calendarWeeks: true,
                autoclose: true,
                clearBtn: true
            }).datepicker('update', this.employee.birth_date);

            $('#first_name').focus();
        },
        cancelForm: function () {
            // retrieve original data since cancel button was pressed.
            this.queryDatabase();

            $('.avatar').css('display', 'none');
            $('.job-title').css('display', '');

            $('.save-form').css('display', 'none');
            $('.modify-form').css('display', '');
            $('.vue-chosen').prop('disabled', true).trigger("chosen:updated");
            ;
            $('.form-control').prop('disabled', true);
            $('.i-checks').iCheck('disable');

            // datepicker for birth_date
            $('#datepicker_birth_date .input-group.date').datepicker('remove');
        },
        switchGender: function (gender) {
            switch (gender) {
                case 'M' :
                    $('input[id="gender[1]"]').iCheck('check');
                    break;
                case 'F' :
                    $('input[id="gender[2]"]').iCheck('check');
                    break;
            }
        },
        updateLocalStorage: function (new_employee_id) {
            var self = this;

            if (self.original_employee_id == localStorage.getItem('employee_id')) {
                localStorage.setItem('employee_id', new_employee_id);
            }
        },
        chosenNationalities: function () {
            var self = this;

            // retrieve nationalities
            client({
                path: '/nationalities',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        self.nationalities_chosen = response.entity;
                    }

                    self.nationality_obj = self.nationalities_chosen[self.employee.nationality_id - 1];
                    $('.vue-chosen').trigger("chosen:updated");
                }
            );
        },
        chosenMaritalStatuses: function () {
            var self = this;

            // retrieve marital status
            client({
                path: '/marital-statuses',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        self.marital_statuses_chosen = response.entity;
                    }

                    self.marital_status_obj = self.marital_statuses_chosen[self.employee.marital_status_id - 1];
                    $('.vue-chosen').trigger("chosen:updated");
                }
            );
        }
    }
}
