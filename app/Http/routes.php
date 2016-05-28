<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Dingo\Api\Routing\Router;
use Illuminate\Database\Eloquent\ModelNotFoundException;

$api = app(Router::class);
$response = app(Dingo\Api\Http\Response\Factory::class);

app(Dingo\Api\Exception\Handler::class)->register(function (ModelNotFoundException $e) use ($response) {

    $response_array = [
        'message'     => '422 Unprocessable Entity',
        'status_code' => 422,
    ];

    return $response->withArray($response_array)->statusCode($response_array['status_code']);
});

// Version 1 of our API
$api->version('v1', function (Router $api) {

    // Set our namespace for the underlying routes
    $api->group([
        'namespace'  => 'HRis\Api\Controllers',
        'middleware' => [
            'cors',
            'api.throttle',
        ],
        'limit'      => 200,
        'expires'    => 5,
    ], function (Router $api) {

        $api->get('/', 'BaseController@apiInformation');

        // Login route
        $api->post('login', 'Auth\AuthController@authenticate');                                                      // docs done
        $api->post('register', 'Auth\AuthController@register');

        $api->get('auth/refresh', 'Auth\AuthController@token');

        // All routes in here are protected and thus need a valid token
        $api->group(['protected' => true, 'middleware' => 'jwt.auth'], function (Router $api) {

            // Authentication
            $api->get('logout', 'Auth\AuthController@logout');                                                        // docs done
            $api->get('users/me', 'Auth\AuthController@me');
            $api->post('sidebar', 'Auth\AuthController@sidebar');

            // Employee
            $api->get('employee/{employee}', 'EmployeeController@show');

            // Profile
            $api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function (Router $api) {
                $api->patch('personal-details', 'PersonalDetailsController@update');                                  // docs done

                $api->patch('contact-details', 'PersonalDetailsController@update');                                   // docs done

                $api->post('emergency-contacts', 'EmergencyContactsController@store');                                // docs done
                $api->patch('emergency-contacts', 'EmergencyContactsController@update');                              // docs done
                $api->delete('emergency-contacts/{emergency_contact}', 'EmergencyContactsController@destroy');        // docs done

                $api->post('dependents', 'DependentsController@store');                                               // docs done
                $api->patch('dependents', 'DependentsController@update');                                             // docs done
                $api->delete('dependents/{dependent}', 'DependentsController@destroy');                               // docs done

                $api->post('reports-to', 'ReportsToController@store');                                                // docs done
                $api->patch('reports-to', 'ReportsToController@update');                                              // docs done
                $api->delete('reports-to/{employee_supervisor}', 'ReportsToController@destroy');                      // docs done

                $api->patch('job', 'JobController@update');
                $api->delete('job/{job_history}', 'JobController@destroy');

                $api->group(['prefix' => 'qualifications'], function (Router $api) {
                    $api->post('work-experiences', 'QualificationsController@storeWorkExperience');
                    $api->delete('work-experiences/{work_experience}', 'QualificationsController@destroyWorkExperience');
                    $api->patch('work-experiences', 'QualificationsController@updateWorkExperience');
                    $api->post('educations', 'QualificationsController@storeEducation');
                    $api->delete('educations/{education}', 'QualificationsController@destroyEducation');
                    $api->patch('educations', 'QualificationsController@updateEducation');
                    $api->post('skills', 'QualificationsController@storeSkill');
                    $api->delete('skills/{employee_skill}', 'QualificationsController@destroySkill');
                    $api->patch('skills', 'QualificationsController@updateSkill');
                });

                $api->patch('custom-fields', 'CustomFieldsController@update');
            });

            // PIM
            $api->group(['prefix' => 'pim', 'namespace' => 'PIM'], function (Router $api) {
                $api->get('employee-list', 'EmployeeListController@index');

                // Configuration
                $api->group(['prefix' => 'configuration', 'namespace' => 'Configuration'], function (Router $api) {

                    $api->get('termination-reasons', 'TerminationReasonsController@index');                           // docs done
                    $api->get('termination-reasons/{termination_reason}', 'TerminationReasonsController@show');       // docs done
                    $api->post('termination-reasons', 'TerminationReasonsController@store');                          // docs done
                    $api->patch('termination-reasons', 'TerminationReasonsController@update');                        // docs done
                    $api->delete('termination-reasons/{termination_reason}', 'TerminationReasonsController@destroy'); // docs done

                    $api->get('custom-field-sections', 'CustomFieldsController@index');
                    $api->post('custom-field-sections', 'CustomFieldsController@store');
                    $api->patch('custom-field-sections', 'CustomFieldsController@update');
                    $api->delete('custom-field-sections/{custom_field_section}', 'CustomFieldsController@destroy');
                    $api->post('custom-field-sections-by-screen-id', 'CustomFieldsController@getCustomFieldSectionsByScreenId');

                    $api->get('custom-fields', 'CustomFieldsController@show');
                    $api->post('custom-fields', 'CustomFieldsController@storeCustomField');
                    $api->patch('custom-fields', 'CustomFieldsController@updateCustomField');
                    $api->delete('custom-fields/{custom_field}', 'CustomFieldsController@destroyCustomField');
                });
            });

            // Admin
            $api->group(['prefix' => 'admin', 'namespace' => 'Admin'], function (Router $api) {

                // Job
                $api->group(['prefix' => 'job', 'namespace' => 'Job'], function (Router $api) {
                    $api->get('titles', 'JobTitlesController@index');                                                 // docs done
                    $api->get('titles/{job_title}', 'JobTitlesController@show');                                      // docs done
                    $api->post('titles', 'JobTitlesController@store');                                                // docs done
                    $api->patch('titles', 'JobTitlesController@update');                                              // docs done
                    $api->delete('titles/{job_title}', 'JobTitlesController@destroy');                                // docs done

                    $api->get('employment-status', 'EmploymentStatusController@index');                               // docs done
                    $api->get('employment-status/{employment_status}', 'EmploymentStatusController@show');            // docs done
                    $api->post('employment-status', 'EmploymentStatusController@store');                              // docs done
                    $api->patch('employment-status', 'EmploymentStatusController@update');                            // docs done
                    $api->delete('employment-status/{employment_status}', 'EmploymentStatusController@destroy');      // docs done

                    $api->get('pay-grades', 'PayGradesController@index');                                             // docs done
                    $api->get('pay-grades/{pay_grade}', 'PayGradesController@show');                                  // docs done
                    $api->post('pay-grades', 'PayGradesController@store');                                            // docs done
                    $api->patch('pay-grades', 'PayGradesController@update');                                          // docs done
                    $api->delete('pay-grades/{pay_grade}', 'PayGradesController@destroy');                            // docs done
                });

                // Qualification
                $api->group(['prefix' => 'qualifications', 'namespace' => 'Qualifications'], function (Router $api) {
                    $api->get('educations', 'EducationsController@index');                                            // docs done
                    $api->get('educations/{education_level}', 'EducationsController@show');                           // docs done
                    $api->post('educations', 'EducationsController@store');                                           // docs done
                    $api->patch('educations', 'EducationsController@update');                                         // docs done
                    $api->delete('educations/{education_level}', 'EducationsController@destroy');                     // docs done
                });
            });

            // Presence
            $api->group(['prefix' => 'presence', 'namespace' => 'Presence'], function (Router $api) {
                $api->get('timelogs', 'TimelogController@index');
                $api->get('alert/time-in', 'TimelogController@attemptTimeIn');
                $api->get('alert/time-out', 'TimelogController@attemptTimeOut');
                $api->post('time-in', 'TimelogController@timeIn');
                $api->post('time-out', 'TimelogController@timeOut');
                $api->get('server-time', 'TimelogController@serverTime');
            });

            // Chosen
            $api->get('cities', 'LookupTableController@cities');                                                      // docs done
            $api->get('countries', 'LookupTableController@countries');                                                // docs done
            $api->get('departments', 'LookupTableController@departments');                                            // docs done
            $api->get('education-levels', 'LookupTableController@educationLevels');                                   // docs done
            $api->get('employment-statuses', 'LookupTableController@employmentStatuses');                             // docs done
            $api->get('job-titles', 'LookupTableController@jobTitles');                                               // docs done
            $api->get('locations', 'LookupTableController@locations');                                                // docs done
            $api->get('marital-statuses', 'LookupTableController@maritalStatuses');                                   // docs done
            $api->get('screens', 'LookupTableController@screens');                                                    // docs done
            $api->get('types', 'LookupTableController@types');                                                        // docs done
            $api->get('nationalities', 'LookupTableController@nationalities');                                        // docs done
            $api->get('provinces', 'LookupTableController@provinces');                                                // docs done
            $api->get('relationships', 'LookupTableController@relationships');                                        // docs done
            $api->get('skills', 'LookupTableController@skills');                                                      // docs done
        });

        $api->get('playground', 'PlaygroundController@index');
    });

});
