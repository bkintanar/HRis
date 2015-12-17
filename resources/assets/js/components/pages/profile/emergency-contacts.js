module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'],
    compiled: function () {
        this.$dispatch('update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Emergency Contacts');
    },
    data: function () {
        return {
            editMode: false,
            employee_id: '',
            emergency_contacts: [],
            relationships: [],
            relationships_chosen: [{}],
            relationship_obj: {},
            modal: {
                first_name: '',
                middle_name: '',
                last_name: '',
                relationship_id: '',
                home_phone: '',
                mobile_phone: '',
                emergency_contact_id: 0
            }
        }
    },
    ready: function () {
        var that = this;
        this.queryDatabase();
        this.chosenRelationships();

        $("#emergencyContactsForm").submit(function (e) {
            return false;
        });
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
                path: '/employee/get-by-employee-id?include=user,emergency_contacts',
                entity: {'employee_id': this.employee_id},
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            };

            client(params).then(
                function (response) {

                    that.$dispatch('update-employee', response.entity.data);

                    client({
                        path: '/relationships?table_view=true',
                        headers: {'Authorization': localStorage.getItem('jwt-token')}
                    }).then(
                        function (response) {
                            that.relationships = response.entity;
                        });

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
        toggleModal: function () {

            this.editMode = false;

            this.modal.first_name = '';
            this.modal.middle_name = '';
            this.modal.last_name = '';
            this.modal.relationship_id = '';
            this.relationship_obj = '';
            this.modal.home_phone = '';
            this.modal.mobile_phone = '';

            $('#emergency_contact_modal').modal('toggle');
            $('#emergency_contact_modal').on('shown.bs.modal', function () {
                $('.vue-chosen', this).trigger('chosen:updated');
                $('#first_name').focus();
            });
        },
        submitForm: function () {

            var that = this;

            // jasny bug work around
            $('#first_name').focus();

            that.modal.employee_id = that.employee.id;
            that.modal.relationship_id = that.relationship_obj.id;

            if (that.modal.relationship_id && that.modal.first_name && that.modal.last_name) {

                client({
                    path: '/profile/emergency-contacts',
                    method: that.editMode ? 'PATCH' : 'POST',
                    entity: that.modal,
                    headers: {'Authorization': localStorage.getItem('jwt-token')}
                }).then(
                    function (response) {
                        switch (response.status.code) {
                            case 200:
                                $('#emergency_contact_modal').modal('toggle');
                                if (that.editMode) {
                                    that.updateRowInTable();
                                    swal({title: response.entity.status, type: 'success', timer: 2000});
                                }
                                else {
                                    that.employee.emergency_contacts.data.push(response.entity.emergency_contact);
                                    swal({title: response.entity.status, type: 'success', timer: 2000});
                                }
                                break;
                            case 500:
                                swal({title: response.entity.status, type: 'error', timer: 2000});
                                break;
                        }
                        $('.vue-chosen').trigger('chosen:updated');
                    }
                );
            }
            else {
                $('#emergency_contact_modal').on('shown.bs.modal', function () {
                    $('.vue-chosen', this).trigger('chosen:open');
                });
            }
        },
        updateRowInTable: function () {
            this.employee.emergency_contacts.data[this.editIndex].first_name = this.modal.first_name;
            this.employee.emergency_contacts.data[this.editIndex].middle_name = this.modal.middle_name;
            this.employee.emergency_contacts.data[this.editIndex].last_name = this.modal.last_name;
            this.employee.emergency_contacts.data[this.editIndex].relationship_id = this.modal.relationship_id;
            this.employee.emergency_contacts.data[this.editIndex].home_phone = this.modal.home_phone;
            this.employee.emergency_contacts.data[this.editIndex].mobile_phone = this.modal.mobile_phone;
        },
        editRecord: function (emergency_contact, index) {
            var that = this;

            this.editMode = true;
            this.editIndex = index;

            that.assignValuesToModal(emergency_contact);

            $('#emergency_contact_modal').modal('toggle');

            $('#emergency_contact_modal').on('shown.bs.modal', function () {
                $('.vue-chosen', this).trigger('chosen:updated');
            });

            $('#first_name').focus();
        },
        deleteRecord: function (emergency_contact, index) {
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
                    client({
                        path: '/profile/emergency-contacts',
                        method: 'DELETE',
                        entity: {id: emergency_contact.id},
                        headers: {'Authorization': localStorage.getItem('jwt-token')}
                    }).then(
                        function (response) {
                            switch (response.status.code) {
                                case 200:
                                    swal({title: response.entity.status, type: 'success', timer: 2000});
                                    that.employee.emergency_contacts.data.splice(index, 1);
                                    break;
                                case 500:
                                    swal({title: response.entity.status, type: 'error', timer: 2000});
                                    break;
                            }
                        }
                    );
                } else {
                    swal('Cancelled', 'No record has been deleted', 'error');
                }
            });
        },
        assignValuesToModal: function (emergency_contact) {
            this.modal.emergency_contact_id = emergency_contact.id;
            this.modal.first_name = emergency_contact.first_name;
            this.modal.middle_name = emergency_contact.middle_name;
            this.modal.last_name = emergency_contact.last_name;
            this.modal.relationship_id = emergency_contact.relationship_id;
            this.relationship_obj = this.relationships_chosen[emergency_contact.relationship_id - 1];
            this.modal.home_phone = emergency_contact.home_phone;
            this.modal.mobile_phone = emergency_contact.mobile_phone;
        },
        chosenRelationships: function () {

            var that = this;

            // retrieve relationshops
            client({
                path: '/relationships',
                headers: {'Authorization': localStorage.getItem('jwt-token')}
            }).then(
                function (response) {
                    if (response) {
                        that.relationships_chosen = response.entity;
                    }
                    $('.vue-chosen').trigger('chosen:updated');
                }
            );
        }
    }
};
