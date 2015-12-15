<?php

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function (Router $api) {

    // Set our namespace for the underlying routes
    $api->group(['namespace' => 'HRis\Api\Controllers', 'middleware' => 'cors'], function (Router $api) {

        // Login route
        $api->post('login', 'Auth\AuthController@authenticate');
        $api->post('register', 'Auth\AuthController@register');

        // Dogs! All routes in here are protected and thus need a valid token
        //$api->group( [ 'protected' => true, 'middleware' => 'jwt.refresh' ], function (Router $api) {
        $api->group(['middleware' => 'jwt.refresh'], function (Router $api) {

            // Authentication
            $api->get('logout', 'Auth\AuthController@logout');
            $api->get('validate_token', 'Auth\AuthController@validateToken');
            $api->get('users/me', 'Auth\AuthController@me');
            $api->post('sidebar', 'Auth\AuthController@sidebar');

            // Profile
            $api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function (Router $api) {
                $api->patch('personal-details', 'PersonalDetailsController@update');
                $api->patch('contact-details', 'PersonalDetailsController@update');
                $api->get('emergency-contacts', 'EmergencyContactsController@index');
                $api->post('emergency-contacts', 'EmergencyContactsController@store');
                $api->patch('emergency-contacts', 'EmergencyContactsController@update');
                $api->delete('emergency-contacts', 'EmergencyContactsController@destroy');
            });

            // Employee
            $api->group(['prefix' => 'employee'], function (Router $api) {
                $api->post('get-by-employee-id', 'EmployeeController@getByEmployeeId');
            });

            // Chosen
            $api->get('cities', 'LookupTableController@cities');
            $api->get('countries', 'LookupTableController@countries');
            $api->get('departments', 'LookupTableController@departments');
            $api->get('education-levels', 'LookupTableController@educationLevels');
            $api->get('employment-statuses', 'LookupTableController@employmentStatuses');
            $api->get('job-titles', 'LookupTableController@jobTitles');
            $api->get('locations', 'LookupTableController@locations');
            $api->get('marital-statuses', 'LookupTableController@maritalStatuses');
            $api->get('nationalities', 'LookupTableController@nationalities');
            $api->get('provinces', 'LookupTableController@provinces');
            $api->get('relationships', 'LookupTableController@relationships');
            $api->get('skills', 'LookupTableController@skills');

        });

    });

});
