<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;

/**
 * Class AnnotationsServiceProvider.
 */
class AnnotationsServiceProvider extends ServiceProvider
{
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
        HRis\Http\Controllers\Administration\Job\EmploymentStatusController::class,
        HRis\Http\Controllers\Administration\Job\PayGradeController::class,
        HRis\Http\Controllers\Administration\Job\TitleController::class,
        HRis\Http\Controllers\Administration\Job\WorkShiftController::class,
        HRis\Http\Controllers\Administration\NationalityController::class,
        HRis\Http\Controllers\Administration\Qualifications\EducationController::class,
        HRis\Http\Controllers\Administration\Qualifications\SkillController::class,
        HRis\Http\Controllers\Administration\UserManagementController::class,
        HRis\Http\Controllers\AjaxController::class,
        HRis\Http\Controllers\Auth\AuthController::class,
        HRis\Http\Controllers\Auth\PasswordController::class,
        HRis\Http\Controllers\HomeController::class,
        HRis\Http\Controllers\PIM\Configuration\TerminationReasonsController::class,
        HRis\Http\Controllers\PIM\Configuration\CustomFieldsController::class,
        HRis\Http\Controllers\PIM\EmployeeListController::class,
        HRis\Http\Controllers\Profile\ContactDetailsController::class,
        HRis\Http\Controllers\Profile\DependentsController::class,
        HRis\Http\Controllers\Profile\EmergencyContactsController::class,
        HRis\Http\Controllers\Profile\JobController::class,
        HRis\Http\Controllers\Profile\MainController::class,
        HRis\Http\Controllers\Profile\PersonalDetailsController::class,
        HRis\Http\Controllers\Profile\PermissionController::class,
        HRis\Http\Controllers\Profile\SalaryComputationsController::class,
        HRis\Http\Controllers\Profile\QualificationsController::class,
        HRis\Http\Controllers\Profile\WorkShiftController::class,
        HRis\Http\Controllers\Time\Attendance\EmployeeRecordsController::class,
        HRis\Http\Controllers\Time\Attendance\PresenceController::class,
        HRis\Http\Controllers\Time\RequisitionController::class,
    ];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanEverything = true;

    /**
     * Automatically scan local.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;
}
