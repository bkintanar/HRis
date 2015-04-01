<?php namespace HRis\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;

class AnnotationsServiceProvider extends ServiceProvider {

    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [
        'HRis\Http\Controllers\HomeController',
        'HRis\Http\Controllers\Auth\AuthController',
        'HRis\Http\Controllers\Auth\PasswordController',
        'HRis\Http\Controllers\AjaxController',
        'HRis\Http\Controllers\HomeController',
        'HRis\Http\Controllers\Profile\MainController',
        'HRis\Http\Controllers\Profile\PersonalDetailsController',
        'HRis\Http\Controllers\Profile\ContactDetailsController',
        'HRis\Http\Controllers\Profile\EmergencyContactsController',
        'HRis\Http\Controllers\Profile\DependentsController',
        'HRis\Http\Controllers\Profile\JobController',
        'HRis\Http\Controllers\Profile\SalaryComputationsController',
        'HRis\Http\Controllers\Profile\QualificationsController',
        'HRis\Http\Controllers\Profile\WorkShiftController',
//        'HRis\Http\Controllers\Profile\PermissionController',
        'HRis\Http\Controllers\PIM\EmployeeListController',
        'HRis\Http\Controllers\PIM\Configuration\TerminationReasonsController',
        'HRis\Http\Controllers\Administration\Job\TitleController',
        'HRis\Http\Controllers\Administration\Job\PayGradeController',
        'HRis\Http\Controllers\Administration\Job\WorkShiftController',
        'HRis\Http\Controllers\Administration\Job\EmploymentStatusController',
        'HRis\Http\Controllers\Administration\Qualifications\SkillController',
        'HRis\Http\Controllers\Administration\Qualifications\EducationController',
        'HRis\Http\Controllers\Administration\UserManagementController',
        'HRis\Http\Controllers\Administration\NationalityController',
        'HRis\Http\Controllers\Time\Attendance\EmployeeRecordsController',
    ];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

}
