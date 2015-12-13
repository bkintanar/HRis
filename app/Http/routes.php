<?php
$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function ($api) {

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'HRis\Api\Controllers', 'middleware' => 'cors'], function ($api) {

		// Login route
		$api->post('login', 'Auth\AuthController@authenticate');
		$api->post('register', 'Auth\AuthController@register');

		// Dogs! All routes in here are protected and thus need a valid token
		//$api->group( [ 'protected' => true, 'middleware' => 'jwt.refresh' ], function ($api) {
		$api->group( [ 'middleware' => 'jwt.refresh' ], function ($api) {

			$api->get('users/me', 'Auth\AuthController@me');
			$api->post('sidebar', 'Auth\AuthController@sidebar');
			$api->get('validate_token', 'Auth\AuthController@validateToken');

			$api->group(['prefix' => 'employee'], function ($api) {
				$api->post('get-by-employee-id', 'EmployeeController@getByEmployeeId');
			});

			$api->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($api) {
				$api->patch('personal-details', 'PersonalDetailsController@update');
				$api->patch('contact-details', 'PersonalDetailsController@update');
				$api->get('emergency-contacts', 'EmergencyContactsController@index');
				$api->post('emergency-contacts', 'EmergencyContactsController@store');
				$api->patch('emergency-contacts', 'EmergencyContactsController@update');
				$api->delete('emergency-contacts', 'EmergencyContactsController@destroy');
			});



			$api->get('signout', 'Auth\AuthController@signout');

				$api->get('dogs', 'DogsController@index');
			$api->post('dogs', 'DogsController@store');
			$api->get('dogs/{id}', 'DogsController@show');
			$api->delete('dogs/{id}', 'DogsController@destroy');
			$api->put('dogs/{id}', 'DogsController@update');

		});

		// Chosen
		$api->get('cities', 'InputSelectController@cities');
		$api->get('countries', 'InputSelectController@countries');
		$api->get('departments', 'InputSelectController@departments');
		$api->get('education-levels', 'InputSelectController@educationLevels');
		$api->get('employment-statuses', 'InputSelectController@employmentStatuses');
		$api->get('job-titles', 'InputSelectController@jobTitles');
		$api->get('locations', 'InputSelectController@locations');
		$api->get('marital-statuses', 'InputSelectController@maritalStatuses');
		$api->get('nationalities', 'InputSelectController@nationalities');
		$api->get('provinces', 'InputSelectController@provinces');
		$api->get('relationships', 'InputSelectController@relationships');
		$api->get('skills', 'InputSelectController@skills');

	});

});
