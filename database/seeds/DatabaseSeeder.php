<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');
        $this->call('ActivationsTableSeeder');
        $this->call('RoleUsersTableSeeder');
        $this->call('MaritalStatusesTableSeeder');
        $this->call('NationalitiesTableSeeder');
        $this->call('CountriesTableSeeder');
        $this->call('ProvincesTableSeeder');
        $this->call('CitiesTableSeeder');
        $this->call('EmployeesTableSeeder');
        $this->call('JobTitlesTableSeeder');
        $this->call('DepartmentsTableSeeder');
        $this->call('EmploymentStatusesTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('WorkShiftsTableSeeder');
        $this->call('JobHistoriesTableSeeder');
        $this->call('TerminationReasonsTableSeeder');
        $this->call('RelationshipsTableSeeder');
        $this->call('NavlinksTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('TaxComputationsTableSeeder');
        $this->call('SSSContributionsTableSeeder');
        $this->call('SalaryComponentsTableSeeder');
        $this->call('EmployeeSalaryComponentsTableSeeder');
    }
}
