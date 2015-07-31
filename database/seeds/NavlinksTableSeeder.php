<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NavlinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
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
                    'icon'       => 'fa-th-large',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 2,
                    'name'       => 'Profile',
                    'href'       => 'profile',
                    'icon'       => 'fa-user',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 3,
                    'name'       => 'Personal Details',
                    'href'       => 'profile/personal-details',
                    'icon'       => 'fa-file-text-o ',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 4,
                    'name'       => 'Contact Details',
                    'href'       => 'profile/contact-details',
                    'icon'       => 'fa-phone-square',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 5,
                    'name'       => 'Emergency Contacts',
                    'href'       => 'profile/emergency-contacts',
                    'icon'       => 'fa-plus-square ',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 6,
                    'name'       => 'Dependents',
                    'href'       => 'profile/dependents',
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
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 8,
                    'name'       => 'Work Shifts',
                    'href'       => 'profile/work-shifts',
                    'icon'       => 'fa-clock-o',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 9,
                    'name'       => 'Salary',
                    'href'       => 'profile/salary',
                    'icon'       => 'fa-money',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 10,
                    'name'       => 'Qualifications',
                    'href'       => 'profile/qualifications',
                    'icon'       => 'fa-bookmark',
                    'parent_id'  => - 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 11,
                    'name'       => 'Performance',
                    'href'       => 'performance',
                    'icon'       => 'fa-bar-chart-o',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 12,
                    'name'       => 'My Trackers',
                    'href'       => 'performance/my-tracker',
                    'icon'       => 'fa-comments-o',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 13,
                    'name'       => 'Employee Trackers',
                    'href'       => 'performance/employee-tracker',
                    'icon'       => 'fa-comments',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 14,
                    'name'       => 'Time',
                    'href'       => 'time',
                    'icon'       => 'fa-clock-o',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 15,
                    'name'       => 'PIM',
                    'href'       => 'pim',
                    'icon'       => 'fa-cogs',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 16,
                    'name'       => 'Employee List',
                    'href'       => 'pim/employee-list',
                    'icon'       => 'fa-list-ul',
                    'parent_id'  => 15,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 17,
                    'name'       => 'Administrator',
                    'href'       => 'admin',
                    'icon'       => 'fa-group',
                    'parent_id'  => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 18,
                    'name'       => 'User Management',
                    'href'       => 'admin/user-management',
                    'icon'       => 'fa-suitcase',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 19,
                    'name'       => 'Job',
                    'href'       => 'admin/job',
                    'icon'       => 'fa-list-ol',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 20,
                    'name'       => 'Job Titles',
                    'href'       => 'admin/job/titles',
                    'icon'       => 'fa-certificate',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 21,
                    'name'       => 'Pay Grades',
                    'href'       => 'admin/job/pay-grades',
                    'icon'       => 'fa-bullseye',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 22,
                    'name'       => 'Employment Status',
                    'href'       => 'admin/job/employment-status',
                    'icon'       => 'fa-info-circle',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 23,
                    'name'       => 'Job Categories',
                    'href'       => 'admin/job/categories',
                    'icon'       => 'fa-sitemap',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 24,
                    'name'       => 'Work Shifts',
                    'href'       => 'admin/job/work-shifts',
                    'icon'       => 'fa-clock-o ',
                    'parent_id'  => 19,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 25,
                    'name'       => 'Qualifications',
                    'href'       => 'admin/qualifications',
                    'icon'       => 'fa-check-square-o',
                    'parent_id'  => 17,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 26,
                    'name'       => 'Skills',
                    'href'       => 'admin/qualifications/skills',
                    'icon'       => 'fa-wrench ',
                    'parent_id'  => 25,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 27,
                    'name'       => 'Education',
                    'href'       => 'admin/qualifications/educations',
                    'icon'       => 'fa-graduation-cap',
                    'parent_id'  => 25,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 28,
                    'name'       => 'Configuration',
                    'href'       => 'pim/configuration',
                    'icon'       => 'fa-cog',
                    'parent_id'  => 15,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 29,
                    'name'       => 'Termination Reasons',
                    'href'       => 'pim/configuration/termination-reasons',
                    'icon'       => 'fa-exclamation-triangle',
                    'parent_id'  => 28,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 30,
                    'name'       => 'Configuration',
                    'href'       => 'performance/configuration',
                    'icon'       => 'fa-cog',
                    'parent_id'  => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 31,
                    'name'       => 'Trackers',
                    'href'       => 'performance/configuration/trackers',
                    'icon'       => 'fa-tasks',
                    'parent_id'  => 30,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 32,
                    'name'       => 'Attendance',
                    'href'       => 'time/attendance',
                    'icon'       => 'fa-calendar-o',
                    'parent_id'  => 14,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id'         => 33,
                    'name'       => 'Employee Records',
                    'href'       => 'time/attendance/employee-records',
                    'icon'       => 'fa-reorder',
                    'parent_id'  => 32,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
