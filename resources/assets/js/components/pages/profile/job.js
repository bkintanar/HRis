module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'],
    compiled: function () {
        this.$dispatch('update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Job Details');
    },
    data: function () {
        return {
            editMode: false,
            employee_id: '',
            job_titles_chosen: [{}],
            job_title_obj: {},
            employment_statuses_chosen: [{}],
            employment_status_obj: {},
            departments_chosen: [{}],
            department_obj: {},
            locations_chosen: [{}],
            location_obj: {}
        }
    },
    ready: function () {
        this.queryDatabase();
    },
    methods: {
        queryDatabase: function () {
            var that = this;

            if (this.$route.path.indexOf('/pim') > -1) {
                this.employee_id = this.$route.params.employee_id;
            } else {
                this.employee_id = localStorage.getItem('employee_id');
            }

            let params = {
                path: '/employee/get-by-employee-id?include=user,job_histories',
                entity: {'employee_id': this.employee_id},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            };

            client(params).then(
                function (response) {

                    that.$dispatch('update-employee', response.entity.data);

                    that.chosenJobTitles();
                    that.chosenEmploymentStatuses();
                    that.chosenDepartments();
                    that.chosenLocations();
                },
                function (response) {
                    if (response.status.code == 422) {
                        that.$route.router.go({
                            name: 'error-404'
                        });
                        console.log(response.entity);
                    }
                }
            );
        },
        deleteRecord: function (job_history, index) {
            var that = this;

            var previousWindowKeyDown = window.onkeydown; // https://github.com/t4t5/sweetalert/issues/127
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                type: 'warning',
                confirmButtonClass: 'confirm-class',
                cancelButtonClass: 'cancel-class',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                swal.disableButtons();
                window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
                if (isConfirm) {

                    let params = {
                        path: '/profile/job',
                        method: 'DELETE',
                        entity: {'id': job_history.id},
                        headers: {'Authorization': localStorage.getItem('jwt-token')}
                    };

                    client(params).then(
                        function (response) {

                            switch (response.status.code) {
                                case 200:
                                    swal({title: response.entity.status, type: 'success', timer: 2000});
                                    that.employee.job_histories.data.splice(index, 1);
                                    that.setCurrentJobHistory();
                                    break;
                                case 500:
                                    swal({title: response.entity.status, type: 'error', timer: 2000});
                                    break;
                            }
                        },
                        function (response) {
                            if (response.status.code == 422) {
                                that.$route.router.go({
                                    name: 'error-404'
                                });
                                console.log(response.entity);
                            }
                        }
                    );

                } else {
                    swal('Cancelled', 'No record has been deleted', 'error');
                }
            });
        },
        setCurrentJobHistory: function () {
            var that = this;

            var current_job_history = that.employee.job_histories.data[0];

            that.employee.job_history.data.job_title_id = current_job_history.job_title_id;
            that.employee.job_history.data.department_id = current_job_history.department_id;
            that.employee.job_history.data.employment_status_id = current_job_history.employment_status_id;
            that.employee.job_history.data.work_shift_id = current_job_history.work_shift_id;
            that.employee.job_history.data.location_id = current_job_history.location_id;

            that.job_title_obj = that.job_titles_chosen[that.employee.job_history.data.job_title_id - 1];
            that.employment_status_obj = that.employment_statuses_chosen[that.employee.job_history.data.employment_status_id - 1];
            that.department_obj = that.departments_chosen[that.employee.job_history.data.department_id - 1];
            that.location_obj = that.locations_chosen[that.employee.job_history.data.location_id - 1];

            that.employee.job_history.data.effective_date = current_job_history.effective_date;
            that.employee.job_history.data.comments = current_job_history.comments;

            that.updateLoggedUser(current_job_history);
        },

        modifyForm: function () {

            $('.save-form').css('display', '');
            $('.modify-form').css('display', 'none');
            $('.vue-chosen').prop('disabled', false).trigger("chosen:updated");
            $('.form-control').prop('disabled', false);
            $('.i-checks').iCheck('enable');

            this.toggleDatepickers(true);

            $('#first_name').focus();
        },

        cancelForm: function () {
            // retrieve original data since cancel button was pressed.
            this.queryDatabase();

            $('.save-form').css('display', 'none');
            $('.modify-form').css('display', '');
            $('.vue-chosen').prop('disabled', true).trigger("chosen:updated");
            $('.form-control').prop('disabled', true);

            this.toggleDatepickers(false);
        },

        chosenJobTitles: function () {
            var that = this;

            // retrieve job-titles
            client({
                path: '/job-titles',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        that.job_titles_chosen = response.entity;
                    }

                    if (that.employee) {
                        that.job_title_obj = that.job_titles_chosen[that.employee.job_history.data.job_title_id - 1];
                    }

                    $('.vue-chosen').trigger('chosen:updated');
                }
            );
        },

        chosenEmploymentStatuses: function () {
            var that = this;

            // retrieve employment-statuses
            client({
                path: '/employment-statuses',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        that.employment_statuses_chosen = response.entity;
                    }

                    if (that.employee) {
                        that.employment_status_obj = that.employment_statuses_chosen[that.employee.job_history.data.employment_status_id - 1];
                    }

                    $('.vue-chosen').trigger('chosen:updated');
                }
            );
        },

        chosenDepartments: function () {
            var that = this;

            // retrieve departments
            client({
                path: '/departments',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        that.departments_chosen = response.entity;
                    }

                    if (that.employee) {
                        that.department_obj = that.departments_chosen[that.employee.job_history.data.department_id - 1];
                    }

                    $('.vue-chosen').trigger('chosen:updated');
                }
            );
        },

        chosenLocations: function () {
            var that = this;

            // retrieve locations
            client({
                path: '/locations',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        that.locations_chosen = response.entity;
                    }

                    if (that.employee) {
                        that.location_obj = that.locations_chosen[that.employee.job_history.data.location_id - 1];
                    }

                    $('.vue-chosen').trigger('chosen:updated');
                }
            );
        },

        toggleDatepickers: function (enable) {

            if (enable) {
                $('.input-group.date').datepicker({
                    format: 'yyyy-mm-dd',
                    keyboardNavigation: false,
                    forceParse: true,
                    calendarWeeks: true,
                    autoclose: true,
                    clearBtn: true
                });

                $('#datepicker_effective_date .input-group.date').datepicker('update', this.employee.job_history.effective_date);
                $('#datepicker_joined_date .input-group.date').datepicker('update', this.employee.joined_date);
                $('#datepicker_probation_end_date .input-group.date').datepicker('update', this.employee.probation_end_date);
                $('#datepicker_permanency_date .input-group.date').datepicker('update', this.employee.permanency_date);
            }
            else {
                $('#datepicker_effective_date .input-group.date').datepicker('remove');
                $('#datepicker_joined_date .input-group.date').datepicker('remove');
                $('#datepicker_probation_end_date .input-group.date').datepicker('remove');
                $('#datepicker_permanency_date .input-group.date').datepicker('remove');
            }
        },

        submitForm: function () {
            var that = this;

            // jasny bug work around
            $('#comments').focus();

            if (!that.employee.job_history.data.effective_date) {
                swal({title: 'Effective Date is a required field', type: 'error', timer: 2000});
                $('#effective_date').focus();
                return false;
            }

            // Set Chosen data
            this.employee.job_history.data.job_title_id = this.job_title_obj.id;
            this.employee.job_history.data.employment_status_id = this.employment_status_obj.id;
            this.employee.job_history.data.department_id = this.department_obj.id;
            this.employee.job_history.data.location_id = this.location_obj.id;

            client({
                path: '/profile/job',
                method: 'PATCH',
                entity: {'employee': this.employee},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    switch (response.status.code) {
                        case 200:
                            if (response.entity.job_history) {
                                that.employee.job_histories.data.unshift(response.entity.job_history);
                                that.updateLoggedUser(response.entity.job_history);
                            }
                            swal({title: response.entity.status, type: 'success', timer: 2000});
                            that.cancelForm();
                            break;
                        case 405:
                            swal({title: response.text, type: 'warning', timer: 2000});
                            break;
                        case 500:
                            $('#first_name').focus();
                            swal({title: response.text, type: 'error', timer: 2000});
                            break;
                    }
                }
            );
        },

        updateLoggedUser: function (current_job_history) {
            if (this.logged.employee.data.id == this.employee.id) {
                this.logged.employee.data.job_history.data.job_title_id = current_job_history.job_title_id;
                localStorage.setItem('logged', btoa(JSON.stringify(this.logged)));
            }
        }
    }
};
