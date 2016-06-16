<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

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
        $this->call(UsersTableSeeder::class);
        $this->call(ActivationsTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(MaritalStatusesTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(JobTitlesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(EmploymentStatusesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(WorkShiftsTableSeeder::class);
        $this->call(JobHistoriesTableSeeder::class);
        $this->call(TerminationReasonsTableSeeder::class);
        $this->call(RelationshipsTableSeeder::class);
        $this->call(NavlinksTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TaxComputationsTableSeeder::class);
        $this->call(SSSContributionsTableSeeder::class);
        $this->call(SalaryComponentsTableSeeder::class);
        $this->call(EmployeeSalaryComponentsTableSeeder::class);
        $this->call(CustomFieldTypeSeeder::class);
    }
}
