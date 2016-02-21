<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use HRis\Api\Eloquent\Navlink;
use Illuminate\Database\Seeder;

class NavlinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('navlinks')->delete();

        foreach ($this->links() as $link) {
            if (!is_numeric($link['parent_id'])) {
                $link['parent_id'] = Navlink::whereHref($link['parent_id'])->first()->id;
            }

            Navlink::create($link);
        }
    }

    private function links()
    {
        return [
            [
                'name'       => 'Dashboard',
                'href'       => 'dashboard',
                'permission' => 1,
                'icon'       => 'fa-th-large',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'Profile',
                'href'       => 'profile',
                'permission' => 1,
                'icon'       => 'fa-user',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'Personal Details',
                'href'       => 'profile/personal-details',
                'permission' => 3,
                'icon'       => 'fa-file-text-o ',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Contact Details',
                'href'       => 'profile/contact-details',
                'permission' => 3,
                'icon'       => 'fa-phone-square',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Emergency Contacts',
                'href'       => 'profile/emergency-contacts',
                'permission' => 15,
                'icon'       => 'fa-plus-square ',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Dependents',
                'href'       => 'profile/dependents',
                'permission' => 15,
                'icon'       => 'fa-child',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Job',
                'href'       => 'profile/job',
                'icon'       => 'fa-briefcase',
                'permission' => 15,
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Work Shifts',
                'href'       => 'profile/work-shifts',
                'permission' => 15,
                'icon'       => 'fa-clock-o',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Salary',
                'href'       => 'profile/salary',
                'permission' => 15,
                'icon'       => 'fa-money',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Qualifications',
                'href'       => 'profile/qualifications',
                'permission' => 15,
                'icon'       => 'fa-bookmark',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Projects',
                'href'       => 'profile/projects',
                'permission' => 15,
                'icon'       => 'fa-product-hunt',
                'parent_id'  => -1,
            ],
            [
                'name'       => 'Presence',
                'href'       => 'presence',
                'permission' => 15,
                'icon'       => 'fa-calendar-check-o',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'Performance',
                'href'       => 'performance',
                'permission' => 15,
                'icon'       => 'fa-bar-chart-o',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'My Trackers',
                'href'       => 'performance/my-tracker',
                'permission' => 15,
                'icon'       => 'fa-comments-o',
                'parent_id'  => 'performance',
            ],
            [
                'name'       => 'Employee Trackers',
                'href'       => 'performance/employee-tracker',
                'permission' => 15,
                'icon'       => 'fa-comments',
                'parent_id'  => 'performance',
            ],
            [
                'name'       => 'Time',
                'href'       => 'time',
                'permission' => 15,
                'icon'       => 'fa-clock-o',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'PIM',
                'href'       => 'pim',
                'permission' => 15,
                'icon'       => 'fa-cogs',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'Employee List',
                'href'       => 'pim/employee-list',
                'permission' => 15,
                'icon'       => 'fa-list-ul',
                'parent_id'  => 'pim',
            ],
            [
                'name'       => 'Administrator',
                'href'       => 'admin',
                'permission' => 15,
                'icon'       => 'fa-group',
                'parent_id'  => 0,
            ],
            [
                'name'       => 'User Management',
                'href'       => 'admin/user-management',
                'permission' => 15,
                'icon'       => 'fa-suitcase',
                'parent_id'  => 'admin',
            ],
            [
                'name'       => 'Job',
                'href'       => 'admin/job',
                'permission' => 15,
                'icon'       => 'fa-list-ol',
                'parent_id'  => 'admin',
            ],
            [
                'name'       => 'Job Titles',
                'href'       => 'admin/job/titles',
                'permission' => 15,
                'icon'       => 'fa-certificate',
                'parent_id'  => 'admin/job',
            ],
            [
                'name'       => 'Pay Grades',
                'href'       => 'admin/job/pay-grades',
                'permission' => 15,
                'icon'       => 'fa-bullseye',
                'parent_id'  => 'admin/job',
            ],
            [
                'name'       => 'Employment Status',
                'href'       => 'admin/job/employment-status',
                'permission' => 15,
                'icon'       => 'fa-info-circle',
                'parent_id'  => 'admin/job',
            ],
            [
                'name'       => 'Job Categories',
                'href'       => 'admin/job/categories',
                'permission' => 15,
                'icon'       => 'fa-sitemap',
                'parent_id'  => 'admin/job',
            ],
            [
                'name'       => 'Work Shifts',
                'href'       => 'admin/job/work-shifts',
                'permission' => 15,
                'icon'       => 'fa-clock-o ',
                'parent_id'  => 'admin/job',
            ],
            [
                'name'       => 'Qualifications',
                'href'       => 'admin/qualifications',
                'permission' => 15,
                'icon'       => 'fa-check-square-o',
                'parent_id'  => 'admin',
            ],
            [
                'name'       => 'Skills',
                'href'       => 'admin/qualifications/skills',
                'permission' => 15,
                'icon'       => 'fa-wrench ',
                'parent_id'  => 'admin/qualifications',
            ],
            [
                'name'       => 'Education',
                'href'       => 'admin/qualifications/educations',
                'permission' => 15,
                'icon'       => 'fa-graduation-cap',
                'parent_id'  => 'admin/qualifications',
            ],
            [
                'name'       => 'Configuration',
                'href'       => 'pim/configuration',
                'permission' => 15,
                'icon'       => 'fa-cog',
                'parent_id'  => 'pim',
            ],
            [
                'name'       => 'Termination Reasons',
                'href'       => 'pim/configuration/termination-reasons',
                'permission' => 15,
                'icon'       => 'fa-exclamation-triangle',
                'parent_id'  => 'pim/configuration',
            ],
            [
                'name'       => 'Configuration',
                'href'       => 'performance/configuration',
                'permission' => 15,
                'icon'       => 'fa-cog',
                'parent_id'  => 'performance',
            ],
            [
                'name'       => 'Trackers',
                'href'       => 'performance/configuration/trackers',
                'permission' => 15,
                'icon'       => 'fa-tasks',
                'parent_id'  => 'performance/configuration',
            ],
            [
                'name'       => 'Attendance',
                'href'       => 'time/attendance',
                'permission' => 15,
                'icon'       => 'fa-calendar-o',
                'parent_id'  => 'time',
            ],
            [
                'name'       => 'Employee Records',
                'href'       => 'time/attendance/employee-records',
                'permission' => 15,
                'icon'       => 'fa-list-ul',
                'parent_id'  => 'time/attendance',
            ],
            [
                'name'       => 'Requesition',
                'href'       => 'time/requisition',
                'permission' => 15,
                'icon'       => 'fa-bookmark',
                'parent_id'  => 'time',
            ],
            [
                'name'       => 'Holidays and Events',
                'href'       => 'time/holidays-and-events',
                'permission' => 15,
                'icon'       => 'fa-rocket',
                'parent_id'  => 'time',
            ],

            [
                'name'       => 'Custom Fields',
                'href'       => 'pim/configuration/custom-field-sections',
                'permission' => 15,
                'icon'       => 'fa-reorder',
                'parent_id'  => 'pim/configuration',
            ],
        ];
    }
}
