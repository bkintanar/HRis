<?php

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function (Router $api) {

    // Set our namespace for the underlying routes
    $api->group([
        'namespace' => 'HRis\Api\Controllers',
        'middleware' => [
            'cors',
            'api.throttle'
        ],
        'limit' => 100,
        'expires' => 5], function (Router $api) {

        // Login route
        $api->post('login', 'Auth\AuthController@authenticate');                                            // docs done
        $api->post('register', 'Auth\AuthController@register');

        $api->get('auth/refresh', [
            'middleware' => [
                'before' => 'jwt.auth',
                'after'  => 'jwt.refresh',
            ],
            function () {
                return response()->json(['code' => 200, 'text' => 'Token refreshed']);
            },
        ]);

        // All routes in here are protected and thus need a valid token
        $api->group(['protected' => true, 'middleware' => 'jwt.auth'], function (Router $api) {

            // Authentication
            $api->get('logout', 'Auth\AuthController@logout');                                              // docs done
            $api->get('validate_token', 'Auth\AuthController@validateToken');
            $api->get('users/me', 'Auth\AuthController@me');
            $api->post('sidebar', 'Auth\AuthController@sidebar');

            // Profile
            $api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function (Router $api) {
                $api->patch('personal-details', 'PersonalDetailsController@update');                        // docs done

                $api->patch('contact-details', 'PersonalDetailsController@update');                         // docs done

                $api->post('emergency-contacts', 'EmergencyContactsController@store');
                $api->patch('emergency-contacts', 'EmergencyContactsController@update');
                $api->delete('emergency-contacts', 'EmergencyContactsController@destroy');

                $api->post('dependents', 'DependentsController@store');
                $api->patch('dependents', 'DependentsController@update');
                $api->delete('dependents', 'DependentsController@destroy');

                $api->patch('job', 'JobController@update');
                $api->delete('job', 'JobController@destroy');

                $api->group(['prefix' => 'qualifications'], function (Router $api) {
                    $api->post('work-experiences', 'QualificationsController@storeWorkExperience');
                    $api->delete('work-experiences', 'QualificationsController@destroyWorkExperience');
                    $api->patch('work-experiences', 'QualificationsController@updateWorkExperience');
                    $api->post('educations', 'QualificationsController@storeEducation');
                    $api->delete('educations', 'QualificationsController@destroyEducation');
                    $api->patch('educations', 'QualificationsController@updateEducation');
                    $api->post('skills', 'QualificationsController@storeSkill');
                    $api->delete('skills', 'QualificationsController@destroySkill');
                    $api->patch('skills', 'QualificationsController@updateSkill');
                });
            });

            // Employee
            $api->group(['prefix' => 'employee'], function (Router $api) {
                $api->post('get-by-employee-id', 'EmployeeController@getByEmployeeId');
            });

            // PIM
            $api->group(['prefix' => 'pim', 'namespace' => 'PIM'], function (Router $api) {
                $api->get('employee-list', 'EmployeeListController@index');
            });

            // Chosen
            $api->get('cities', 'LookupTableController@cities');                                            // docs done
            $api->get('countries', 'LookupTableController@countries');                                      // docs done
            $api->get('departments', 'LookupTableController@departments');                                  // docs done
            $api->get('education-levels', 'LookupTableController@educationLevels');                         // docs done
            $api->get('employment-statuses', 'LookupTableController@employmentStatuses');                   // docs done
            $api->get('job-titles', 'LookupTableController@jobTitles');                                     // docs done
            $api->get('locations', 'LookupTableController@locations');                                      // docs done
            $api->get('marital-statuses', 'LookupTableController@maritalStatuses');                         // docs done
            $api->get('nationalities', 'LookupTableController@nationalities');                              // docs done
            $api->get('provinces', 'LookupTableController@provinces');                                      // docs done
            $api->get('relationships', 'LookupTableController@relationships');                              // docs done
            $api->get('skills', 'LookupTableController@skills');                                            // docs done
        });

    });

});
