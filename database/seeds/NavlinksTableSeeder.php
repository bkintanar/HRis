<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NavlinksTableSeeder extends Seeder {

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
				['id' => 1, 'name' => 'Dashboard', 'href' => 'dashboard', 'icon' => 'fa-th-large', 'parent_id' => 0, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 2, 'name' => 'Profile', 'href' => 'profile', 'icon' => 'fa-user', 'parent_id' => 0, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 3, 'name' => 'Personal Details', 'href' => 'profile/personal-details', 'icon' => 'fa-file-text-o ', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 4, 'name' => 'Contact Details', 'href' => 'profile/contact-details', 'icon' => 'fa-phone-square', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 5, 'name' => 'Emergency Contacts', 'href' => 'profile/emergency-contacts', 'icon' => 'fa-plus-square ', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 6, 'name' => 'Dependents', 'href' => 'profile/dependents', 'icon' => 'fa-child', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 7, 'name' => 'Job', 'profile/job', 'href' => 'fa-briefcase', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 8, 'name' => 'Salary', 'href' => 'profile/salary', 'icon' => 'fa-money', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 9, 'name' => 'Qualifications', 'href' => 'profile/qualifications', 'icon' => 'fa-bookmark', 'parent_id' => -1, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 10, 'name' => 'Performance', 'href' => 'performance', 'icon' => 'fa-bar-chart-o', 'parent_id' => 0, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 11, 'name' => 'My Trackers', 'href' => 'performance/my-tracker', 'icon' => 'fa-comments-o', 'parent_id' => 10, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 12, 'name' => 'Employee Trackers', 'href' => 'performance/employee-tracker', 'icon' => 'fa-comments', 'parent_id' => 10, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 13, 'name' => 'PIM', 'href' => 'pim', 'icon' => 'fa-cogs', 'parent_id' => 0, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 14, 'name' => 'Employee List', 'href' => 'pim/employee-list', 'icon' => 'fa-list-ul', 'parent_id' => 13, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 15, 'name' => 'Administrator', 'href' => 'admin', 'icon' => 'fa-group', 'parent_id' => 0, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 16, 'name' => 'User Management', 'href' => 'admin/user-management', 'icon' => 'fa-suitcase', 'parent_id' => 15, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 17, 'name' => 'Job', 'href' => 'admin/job', 'icon' => 'fa-list-ol', 'parent_id' => 15, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 18, 'name' => 'Job Titles', 'href' => 'admin/job/titles', 'icon' => 'fa-certificate', 'parent_id' => 17, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 19, 'name' => 'Pay Grades', 'href' => 'admin/job/pay-grades', 'icon' => 'fa-bullseye', 'parent_id' => 17, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 20, 'name' => 'Employment Status', 'href' => 'admin/job/employment-status', 'icon' => 'fa-info-circle', 'parent_id' => 17, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 21, 'name' => 'Job Categories', 'href' => 'admin/job/categories', 'icon' => 'fa-sitemap', 'parent_id' => 17, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 22, 'name' => 'Work Shifts', 'href' => 'admin/job/work-shifts', 'icon' => 'fa-clock-o ', 'parent_id' => 17, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 23, 'name' => 'Qualifications', 'href' => 'admin/qualifications', 'icon' => 'fa-check-square-o', 'parent_id' => 15, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 24, 'name' => 'Skills', 'href' => 'admin/qualifications/skills', 'icon' => 'fa-wrench ', 'parent_id' => 23, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 25, 'name' => 'Education', 'href' => 'admin/qualifications/educations', 'icon' => 'fa-graduation-cap', 'parent_id' => 23, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 26, 'name' => 'Configuration', 'href' => 'pim/configuration', 'icon' => 'fa-cog', 'parent_id' => 13, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 27, 'name' => 'Termination Reasons', 'href' => 'pim/configuration/termination-reasons', 'icon' => 'fa-exclamation-triangle', 'parent_id' => 26, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 28, 'name' => 'Configuration', 'href' => 'performance/configuration', 'icon' => 'fa-cog', 'parent_id' => 10, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
				['id' => 29, 'name' => 'Trackers', 'href' => 'performance/configuration/trackers', 'icon' => 'fa-tasks', 'parent_id' => 28, 'created_at' => '0000-00-00 00:00:00', 'updated_at' => '0000-00-00 00:00:00'],
            ]
        );
	}

}
