module.exports = {

    configRouter: function (router) {

        router.map({
            '*': {
                component: require('./compiled/pages/404.vue')
            },
            'error-404': {
                name: 'error-404',
                component: require('./compiled/pages/404.vue')
            },
            '/': {
                component: require('./compiled/pages/default-page.vue'),
                subRoutes: {
                    '/dashboard': {
                        name: 'dashboard',
                        component: require('./compiled/pages/dashboard.vue'),
                        auth: true
                    },
                    '/profile': {
                        name: 'profile',
                        component: require('./compiled/pages/page.vue'),
                        auth: true,
                        subRoutes: {
                            '/personal-details': {
                                name: 'profile-personal-details',
                                component: require('./compiled/pages/profile/personal-details.vue'),
                                auth: true
                            },
                            '/contact-details': {
                                name: 'profile-contact-details',
                                component: require('./compiled/pages/profile/contact-details.vue'),
                                auth: true
                            },
                            '/emergency-contacts': {
                                name: 'profile-emergency-contacts',
                                component: require('./compiled/pages/profile/emergency-contacts.vue'),
                                auth: true
                            },
                            '/dependents': {
                                name: 'profile-dependents',
                                component: require('./compiled/pages/profile/dependents.vue'),
                                auth: true
                            },
                            '/job': {
                                name: 'profile-job',
                                component: require('./compiled/pages/profile/job.vue'),
                                auth: true
                            },
                            '/work-shifts': {
                                name: 'profile-work-shifts',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/salary': {
                                name: 'profile-salary',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/qualifications': {
                                name: 'profile-qualifications',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            }
                        }
                    },
                    '/presence': {
                        name: 'presence',
                        component: require('./compiled/pages/page.vue'),
                        auth: true
                    },
                    '/performance': {
                        name: 'performance',
                        component: require('./compiled/pages/page.vue'),
                        auth: true,
                        subRoutes: {
                            '/my-tracker': {
                                name: 'performance-my-tracker',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/employee-tracker': {
                                name: 'performance-employee-tracker',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/configuration': {
                                name: 'performance-configuration',
                                component: require('./compiled/pages/page.vue'),
                                auth: true,
                                subRoutes: {
                                    '/trackers': {
                                        name: 'performance-configuration-trackers',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    }
                                }
                            }
                        }
                    },
                    '/time': {
                        name: 'time',
                        component: require('./compiled/pages/page.vue'),
                        auth: true,
                        subRoutes: {
                            '/attendance': {
                                name: 'time-attendance',
                                component: require('./compiled/pages/page.vue'),
                                auth: true,
                                subRoutes: {
                                    '/employee-records': {
                                        name: 'time-attendance-employee-records',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/overtime-records': {
                                        name: 'time-attendance-overtime-records',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    }
                                }
                            },
                            '/requisition': {
                                name: 'time-requisition',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/holidays': {
                                name: 'time-holidays',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/holidays-and-events': {
                                name: 'time-holidays-and-events',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            }
                        }
                    },
                    '/pim': {
                        name: 'pim',
                        component: require('./compiled/pages/page.vue'),
                        auth: true,
                        subRoutes: {
                            '/employee-list': {
                                name: 'pim-employee-list',
                                component: require('./compiled/pages/pim/employee-list.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/personal-details': {
                                name: 'pim-employee-list-personal-details',
                                component: require('./compiled/pages/profile/personal-details.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/contact-details': {
                                name: 'pim-employee-list-contact-details',
                                component: require('./compiled/pages/profile/contact-details.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/emergency-contacts': {
                                name: 'pim-employee-list-emergency-contacts',
                                component: require('./compiled/pages/profile/emergency-contacts.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/dependents': {
                                name: 'pim-employee-list-dependents',
                                component: require('./compiled/pages/profile/dependents.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/job': {
                                name: 'pim-employee-list-job',
                                component: require('./compiled/pages/profile/job.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/work-shifts': {
                                name: 'pim-employee-list-work-shifts',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/salary': {
                                name: 'pim-employee-list-salary',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/employee-list/:employee_id/qualifications': {
                                name: 'pim-employee-list-qualifications',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/configuration': {
                                name: 'pim-configuration',
                                auth: true,
                                component: require('./compiled/pages/page.vue'),
                                subRoutes: {
                                    '/termination-reasons': {
                                        name: 'pim-configuration-termination-reasons',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/custom-field-sections': {
                                        name: 'pim-configuration-custom-field-sections',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    }
                                }
                            }
                        }
                    },
                    '/admin': {
                        name: 'admin',
                        component: require('./compiled/pages/page.vue'),
                        auth: true,
                        subRoutes: {
                            '/user-management': {
                                name: 'admin-user-management',
                                component: require('./compiled/pages/page.vue'),
                                auth: true
                            },
                            '/job': {
                                name: 'admin-job',
                                component: require('./compiled/pages/page.vue'),
                                auth: true,
                                subRoutes: {
                                    '/titles': {
                                        name: 'admin-job-titles',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/pay-grades': {
                                        name: 'admin-job-pay-grades',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/employment-status': {
                                        name: 'admin-job-employment-status',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/categories': {
                                        name: 'admin-job-categories',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/work-shifts': {
                                        name: 'admin-job-work-shifts',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    }
                                }
                            },
                            '/qualifications': {
                                name: 'admin-qualifications',
                                component: require('./compiled/pages/page.vue'),
                                auth: true,
                                subRoutes: {
                                    '/skills': {
                                        name: 'admin-qualifications-skills',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    },
                                    '/educations': {
                                        name: 'admin-qualifications-educations',
                                        component: require('./compiled/pages/page.vue'),
                                        auth: true
                                    }
                                }
                            }
                        }
                    }
                }
            },
            '/login': {
                name: 'login',
                component: require('./compiled/pages/auth/login.vue'),
                guest: true
            }
        });

        router.redirect({
            '/': '/dashboard',
            '/profile': '/profile/personal-details',
            '/pim': '/pim/employee-list',
            '/admin/job': '/admin/job/titles',
            '/admin/qualifications': '/admin/qualifications/skills',
            '/translator': '/translator/translations'
        });

        router.beforeEach(function (transition) {

            var auth = localStorage.getItem('jwt-token');

            if (transition.to.auth) {
                if (auth) {

                    let params = {
                        path: '/auth/refresh',
                        method: 'GET',
                        headers: {'Authorization': localStorage.getItem('jwt-token')}
                    };

                    client(params).then(
                        function (response) {

                            var token = response.request.headers.Authorization;

                            localStorage.setItem('jwt-token', token);
                            transition.next();
                        },
                        function() {
                            transition.redirect('/logout');
                        }
                    );
                } else {
                    transition.redirect('/login');
                }
            } else {
                if (transition.to.path == '/login' && auth) {
                    transition.redirect('/dashboard');
                } else {
                    transition.next();
                }
            }
        })
    }
}
;
