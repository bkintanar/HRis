module.exports = {
    props: ['employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission'],
    data: function () {
        return {
            logged: {
                avatar: '',
                id: null,
                employee: {
                    data: {
                        first_name: '',
                        last_name: '',
                        job_history: {
                            data: {
                                job_title_id: ''
                            }
                        }
                    }
                }
            }
        }
    },

    compiled: function () {
        this.logged = JSON.parse(atob(localStorage.getItem('logged')));
        this.logged.employee_id = localStorage.getItem('employee_id');
        this.logged.avatar = localStorage.getItem('avatar');
        this.logged.has_access = JSON.parse(atob(localStorage.getItem('permissions')));
    }
};
