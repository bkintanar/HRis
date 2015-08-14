<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NavlinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('navlinks')->delete();

        DB::table('navlinks')->insert(
            [
                [
                    'id'         => 1,
                    'name'       => 'Dashboard',
                    'href'       => 'dashboard',
                    'permission' => 1,
                    'icon'       => 'fa-th-large',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 2,
                    'name'       => 'Profile',
                    'href'       => 'profile',
                    'permission' => 1,
                    'icon'       => 'fa-user',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 3,
                    'name'       => 'Personal Details',
                    'href'       => 'profile/personal-details',
                    'permission' => 3,
                    'icon'       => 'fa-file-text-o ',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 4,
                    'name'       => 'Contact Details',
                    'href'       => 'profile/contact-details',
                    'permission' => 3,
                    'icon'       => 'fa-phone-square',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 5,
                    'name'       => 'Emergency Contacts',
                    'href'       => 'profile/emergency-contacts',
                    'permission' => 15,
                    'icon'       => 'fa-plus-square ',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 6,
                    'name'       => 'Dependents',
                    'href'       => 'profile/dependents',
                    'permission' => 15,
                    'icon'       => 'fa-child',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 7,
                    'name'       => 'Job',
                    'profile/job',
                    'href'       => 'fa-briefcase',
                    'permission' => 15,
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 8,
                    'name'       => 'Work Shifts',
                    'href'       => 'profile/work-shifts',
                    'permission' => 15,
                    'icon'       => 'fa-clock-o',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 9,
                    'name'       => 'Salary',
                    'href'       => 'profile/salary',
                    'permission' => 15,
                    'icon'       => 'fa-money',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 10,
                    'name'       => 'Qualifications',
                    'href'       => 'profile/qualifications',
                    'permission' => 15,
                    'icon'       => 'fa-bookmark',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 11,
                    'name'       => 'Performance',
                    'href'       => 'performance',
                    'permission' => 15,
                    'icon'       => 'fa-bar-chart-o',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 12,
                    'name'       => 'My Trackers',
                    'href'       => 'performance/my-tracker',
                    'permission' => 15,
                    'icon'       => 'fa-comments-o',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 13,
                    'name'       => 'Employee Trackers',
                    'href'       => 'performance/employee-tracker',
                    'permission' => 15,
                    'icon'       => 'fa-comments',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 14,
                    'name'       => 'Time',
                    'href'       => 'time',
                    'permission' => 15,
                    'icon'       => 'fa-clock-o',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 15,
                    'name'       => 'PIM',
                    'href'       => 'pim',
                    'permission' => 15,
                    'icon'       => 'fa-cogs',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 16,
                    'name'       => 'Employee List',
                    'href'       => 'pim/employee-list',
                    'permission' => 15,
                    'icon'       => 'fa-list-ul',
                    'parent_id'  => 15,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 17,
                    'name'       => 'Administrator',
                    'href'       => 'admin',
                    'permission' => 15,
                    'icon'       => 'fa-group',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 18,
                    'name'       => 'User Management',
                    'href'       => 'admin/user-management',
                    'permission' => 15,
                    'icon'       => 'fa-suitcase',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 19,
                    'name'       => 'Job',
                    'href'       => 'admin/job',
                    'permission' => 15,
                    'icon'       => 'fa-list-ol',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 20,
                    'name'       => 'Job Titles',
                    'href'       => 'admin/job/titles',
                    'permission' => 15,
                    'icon'       => 'fa-certificate',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 21,
                    'name'       => 'Pay Grades',
                    'href'       => 'admin/job/pay-grades',
                    'permission' => 15,
                    'icon'       => 'fa-bullseye',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 22,
                    'name'       => 'Employment Status',
                    'href'       => 'admin/job/employment-status',
                    'permission' => 15,
                    'icon'       => 'fa-info-circle',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 23,
                    'name'       => 'Job Categories',
                    'href'       => 'admin/job/categories',
                    'permission' => 15,
                    'icon'       => 'fa-sitemap',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 24,
                    'name'       => 'Work Shifts',
                    'href'       => 'admin/job/work-shifts',
                    'permission' => 15,
                    'icon'       => 'fa-clock-o ',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 25,
                    'name'       => 'Qualifications',
                    'href'       => 'admin/qualifications',
                    'permission' => 15,
                    'icon'       => 'fa-check-square-o',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 26,
                    'name'       => 'Skills',
                    'href'       => 'admin/qualifications/skills',
                    'permission' => 15,
                    'icon'       => 'fa-wrench ',
                    'parent_id'  => 25,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 27,
                    'name'       => 'Education',
                    'href'       => 'admin/qualifications/educations',
                    'permission' => 15,
                    'icon'       => 'fa-graduation-cap',
                    'parent_id'  => 25,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 28,
                    'name'       => 'Configuration',
                    'href'       => 'pim/configuration',
                    'permission' => 15,
                    'icon'       => 'fa-cog',
                    'parent_id'  => 15,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 29,
                    'name'       => 'Termination Reasons',
                    'href'       => 'pim/configuration/termination-reasons',
                    'permission' => 15,
                    'icon'       => 'fa-exclamation-triangle',
                    'parent_id'  => 28,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 30,
                    'name'       => 'Configuration',
                    'href'       => 'performance/configuration',
                    'permission' => 15,
                    'icon'       => 'fa-cog',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 31,
                    'name'       => 'Trackers',
                    'href'       => 'performance/configuration/trackers',
                    'permission' => 15,
                    'icon'       => 'fa-tasks',
                    'parent_id'  => 30,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 32,
                    'name'       => 'Attendance',
                    'href'       => 'time/attendance',
                    'permission' => 15,
                    'icon'       => 'fa-calendar-o',
                    'parent_id'  => 14,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 33,
                    'name'       => 'Employee Records',
                    'href'       => 'time/attendance/employee-records',
                    'permission' => 15,
                    'icon'       => 'fa-reorder',
                    'parent_id'  => 32,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
