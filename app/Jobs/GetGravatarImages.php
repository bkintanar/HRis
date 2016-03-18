<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Jobs;

use HRis\Api\Eloquent\Employee;
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
