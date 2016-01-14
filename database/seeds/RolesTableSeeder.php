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

        $root_permission = $arr = array_merge(
            $this->set('dashboard', ['view']),
            $this->set('profile', ['view']),
            $this->set('profile.personal-details', ['view', 'update']),
            $this->set('profile.contact-details', ['view', 'update']),
            $this->set('profile.emergency-contacts'),
            $this->set('profile.dependents'),
            $this->set('profile.job'),
            $this->set('profile.work-shifts'),
            $this->set('profile.salary'),
            $this->set('profile.qualifications'),
            $this->set('profile.qualifications.educations'),
            $this->set('profile.qualifications.skills'),
            $this->set('profile.qualifications.work-experiences'),
            $this->set('pim.personal-details', ['view', 'update']),
            $this->set('pim.contact-details', ['view', 'update']),
            $this->set('pim.emergency-contacts'),
            $this->set('pim.dependents'),
            $this->set('pim.job'),
            $this->set('pim.work-shifts'),
            $this->set('pim.salary'),
            $this->set('pim.qualifications'),
            $this->set('pim.qualifications.educations'),
            $this->set('pim.qualifications.skills'),
            $this->set('pim.qualifications.work-experiences'),
            $this->set('performance'),
            $this->set('performance.my-tracker'),
            $this->set('performance.employee-tracker'),
            $this->set('performance.configuration'),
            $this->set('performance.configuration.trackers'),
            $this->set('time'),
            $this->set('pim'),
            $this->set('pim.employee-list'),
            $this->set('admin'),
            $this->set('admin.user-management'),
            $this->set('admin.job'),
            $this->set('admin.job.titles'),
            $this->set('admin.job.pay-grades'),
            $this->set('admin.job.employment-status'),
            $this->set('admin.job.categories'),
            $this->set('admin.job.work-shifts'),
            $this->set('admin.qualifications'),
            $this->set('admin.qualifications.skills'),
            $this->set('admin.qualifications.educations'),
            $this->set('pim.configuration'),
            $this->set('pim.configuration.termination-reasons'),
            $this->set('pim.configuration.custom-field-sections'),
            $this->set('pim.configuration.custom-fields'),
            $this->set('perforamance.configuration'),
            $this->set('perforamance.configuration.trackers'),
            $this->set('time.attendance'),
            $this->set('time.attendance.employee-records'),
            $this->set('time.requisition'),
            $this->set('time.holidays-and-events'),
            $this->set('presence', ['view'])
        );

        switch ($role) {
            case 'root':
                $arr = $root_permission;
                break;
            case 'admin':
                $arr = $root_permission;
                break;
            case 'ess':
                $arr = array_merge(
                    $this->set('dashboard', ['view']),
                    $this->set('profile', ['view']),
                    $this->set('profile.personal-details', ['view', 'update']),
                    $this->set('profile.contact-details', ['view', 'update']),
                    $this->set('profile.emergency-contacts'),
                    $this->set('profile.dependents'),
                    $this->set('profile.job', ['view']),
                    $this->set('profile.work-shifts', ['view']),
                    $this->set('profile.salary', ['view']),
                    $this->set('profile.qualifications'),
                    $this->set('profile.qualifications.educations'),
                    $this->set('profile.qualifications.skills'),
                    $this->set('profile.qualifications.work-experiences'),
                    $this->set('performance', ['view']),
                    $this->set('performance.my-tracker', ['view']),
                    $this->set('presence', ['view'])
                );
                break;
        }

        return json_encode($arr);
    }

    public function set($label, $only = [])
    {
        $permit = ['create', 'update', 'view', 'delete'];

        // If $only array is empty return all permission
        if (!count($only)) {
            $only = $permit;
        }

        $arr = [];

        foreach ($only as $action) {
            if (in_array($action, $permit)) {
                $arr[$label.'.'.$action] = true;
            }
        }

        return $arr;
    }
}
