<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UsersTableSeeder');
		$this->call('UsersGroupsTableSeeder');
		$this->call('TerminationReasonsTableSeeder');
		$this->call('RelationshipsTableSeeder');
		$this->call('ProvincesTableSeeder');
		$this->call('NavlinksTableSeeder');
		$this->call('NationalitiesTableSeeder');
		$this->call('MaritalStatusesTableSeeder');
		$this->call('JobTitlesTableSeeder');
		$this->call('GroupsTableSeeder');
		$this->call('EmploymentStatusesTableSeeder');
		$this->call('DepartmentsTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('CitiesTableSeeder');
	}

}
