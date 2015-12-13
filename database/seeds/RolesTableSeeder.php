<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
        DB::table('roles')->delete();

        foreach ($this->data() as $role) {
            DB::table('roles')->insert($role);
        }
    }

    public function data()
    {
        return [
            [
                'slug'        => 'root',
                'name'        => 'Root',
                'permissions' => $this->permission('root'),
                'created_at'  => '2014-10-21 22:56:12',
                'updated_at'  => '2014-11-04 15:10:19',
            ],
            [
                'slug'        => 'administrator',
                'name'        => 'Administrator',
                'permissions' => $this->permission('admin'),
                'created_at'  => '2014-10-21 22:56:12',
                'updated_at'  => '2014-10-31 02:05:22',
            ],
            [
                'slug'        => 'ess',
                'name'        => 'Employee Self-service',
                'permissions' => $this->permission('ess'),
                'created_at'  => '2014-10-21 22:56:12',
                'updated_at'  => '2014-10-31 02:05:22',
            ],
        ];
    }

    private function permission($role)
    {
        $arr = [];

        switch ($role) {
            case 'root':
                $arr = array_merge(
                    permission('dashboard', ['view']),
                    permission('profile', ['view']),
                    permission('profile.personal-details', ['view', 'update']),
                    permission('profile.contact-details', ['view', 'update']),
                    permission('profile.emergency-contacts'),
                    permission('profile.dependents'),
                    permission('profile.job'),
                    permission('profile.work-shifts'),
                    permission('profile.salary'),
                    permission('profile.qualifications'),
                    permission('profile.qualifications.educations'),
                    permission('profile.qualifications.skills'),
                    permission('profile.qualifications.work-experiences'),
                    permission('pim.personal-details', ['view', 'update']),
                    permission('pim.contact-details', ['view', 'update']),
                    permission('pim.emergency-contacts'),
                    permission('pim.dependents'),
                    permission('pim.job'),
                    permission('pim.work-shifts'),
                    permission('pim.salary'),
                    permission('pim.qualifications'),
                    permission('pim.qualifications.educations'),
                    permission('pim.qualifications.skills'),
                    permission('pim.qualifications.work-experiences'),
                    permission('performance'),
                    permission('performance.my-tracker'),
                    permission('performance.employee-tracker'),
                    permission('performance.configuration'),
                    permission('performance.configuration.trackers'),
                    permission('time'),
                    permission('pim'),
                    permission('pim.employee-list'),
                    permission('admin'),
                    permission('admin.user-management'),
                    permission('admin.job'),
                    permission('admin.job.titles'),
                    permission('admin.job.pay-grades'),
                    permission('admin.job.employment-status'),
                    permission('admin.job.categories'),
                    permission('admin.job.work-shifts'),
                    permission('admin.qualifications'),
                    permission('admin.qualifications.skills'),
                    permission('admin.qualifications.educations'),
                    permission('pim.configuration'),
                    permission('pim.configuration.termination-reasons'),
                    permission('pim.configuration.custom-field-sections'),
                    permission('perforamance.configuration'),
                    permission('perforamance.configuration.trackers'),
                    permission('time.attendance'),
                    permission('time.attendance.employee-records'),
                    permission('time.requisition'),
                    permission('time.holidays-and-events'),
                    permission('presence', ['view'])
                );
                break;
            case 'admin':
                $arr = array_merge(
                    permission('dashboard', ['view']),
                    permission('profile', ['view']),
                    permission('profile.personal-details', ['view', 'update']),
                    permission('profile.contact-details', ['view', 'update']),
                    permission('profile.emergency-contacts'),
                    permission('profile.dependents'),
                    permission('profile.job'),
                    permission('profile.work-shifts'),
                    permission('profile.salary'),
                    permission('profile.qualifications'),
                    permission('profile.qualifications.educations'),
                    permission('profile.qualifications.skills'),
                    permission('profile.qualifications.work-experiences'),
                    permission('pim.personal-details', ['view', 'update']),
                    permission('pim.contact-details', ['view', 'update']),
                    permission('pim.emergency-contacts'),
                    permission('pim.dependents'),
                    permission('pim.job'),
                    permission('pim.work-shifts'),
                    permission('pim.salary'),
                    permission('pim.qualifications'),
                    permission('pim.qualifications.educations'),
                    permission('pim.qualifications.skills'),
                    permission('pim.qualifications.work-experiences'),
                    permission('performance'),
                    permission('performance.my-tracker'),
                    permission('performance.employee-tracker'),
                    permission('performance.configuration'),
                    permission('performance.configuration.trackers'),
                    permission('time'),
                    permission('pim'),
                    permission('pim.employee-list'),
                    permission('admin'),
                    permission('admin.user-management'),
                    permission('admin.job'),
                    permission('admin.job.titles'),
                    permission('admin.job.pay-grades'),
                    permission('admin.job.employment-status'),
                    permission('admin.job.categories'),
                    permission('admin.job.work-shifts'),
                    permission('admin.qualifications'),
                    permission('admin.qualifications.skills'),
                    permission('admin.qualifications.educations'),
                    permission('pim.configuration'),
                    permission('pim.configuration.termination-reasons'),
                    permission('pim.configuration.custom-fields'),
                    permission('perforamance.configuration'),
                    permission('perforamance.configuration.trackers'),
                    permission('time.attendance'),
                    permission('time.attendance.employee-records'),
                    permission('time.requisition'),
                    permission('time.holidays-and-events'),
                    permission('presence', ['view'])
                );
                break;
            case 'ess':
                $arr = array_merge(
                    permission('dashboard', ['view']),
                    permission('profile', ['view']),
                    permission('profile.personal-details', ['view', 'update']),
                    permission('profile.contact-details', ['view', 'update']),
                    permission('profile.emergency-contacts'),
                    permission('profile.dependents'),
                    permission('profile.job', ['view']),
                    permission('profile.work-shifts', ['view']),
                    permission('profile.salary', ['view']),
                    permission('profile.qualifications'),
                    permission('profile.qualifications.educations'),
                    permission('profile.qualifications.skills'),
                    permission('profile.qualifications.work-experiences'),
                    permission('performance', ['view']),
                    permission('performance.my-tracker', ['view']),
                    permission('presence', ['view'])
                );
                break;
        }

        return json_encode($arr);
    }
}
