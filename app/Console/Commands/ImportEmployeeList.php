<?php namespace HRis\Console\Commands;

use Carbon\Carbon;
use HRis\Eloquent\City;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSalaryComponent;
use HRis\Eloquent\SalaryComponent;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportEmployeeList extends Command {

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:employee';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path() . '/employee.csv');

        $csv->setOffset(2);
        $data = $csv->query();

        foreach ($data as $lineIndex => $row)
        {
            $data = [];
            $data['employee_id'] = $row[0];
            $data['joined_date'] = Carbon::parse($row[1])->toDateString();
            $data['birth_date'] = Carbon::parse($row[23])->toDateString() ? : null;
            $data['first_name'] = utf8_encode($row[4]);
            $data['middle_name'] = utf8_encode($row[5]) ? : null;
            $data['last_name'] = utf8_encode($row[6]);
            $data['suffix_name'] = utf8_encode($row[7]) ? : null;
            $data['address_1'] = utf8_encode($row[9]);
            $data['address_city_id'] = City::whereName($row[10])->pluck('id') ? : null;
            $data['address_province_id'] = 25;
            $data['address_country_id'] = 185;
            $data['address_postal_code'] = $row[11] ? : null;
            $data['social_security'] = $row[15] ? : null;
            $data['tax_identification'] = $row[16] ? : null;
            $data['philhealth'] = $row[17] ? : null;
            $data['hdmf_pagibig'] = $row[18] ? : null;
            $data['mid_rtn'] = $row[19] ? : null;

            $temp = Employee::create($data);
            foreach (SalaryComponent::all() as $value)
            {
                $salary_components = ['employee_id' => $temp->id, 'component_id' => $value->id, 'value' => 0];
                EmployeeSalaryComponent::create($salary_components);
            }
//            dd($data);
        }
    }

}
