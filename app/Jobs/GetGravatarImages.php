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

namespace HRis\Jobs;

use Irradiate\Eloquent\Employee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class GetGravatarImages extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * Create a new job instance.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->employee->avatar = Gravatar::exists($this->employee->work_email) ? Gravatar::src($this->employee->work_email, 400) : '/images/profile/default/0.png';

        $this->employee->save();

        $message = 'Successfully updated avatar of employee_id '.$this->employee->id;

        Log::info($message);
    }
}
