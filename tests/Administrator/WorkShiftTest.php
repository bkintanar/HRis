<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class WorkShiftTest.
 */
class WorkShiftTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     * @author Bertrand Kintanar
     */
    public function testAddWorkShiftPositive()
    {
        $this->logMeIn();

        $this->click('Work Shifts')
            ->onPage('/admin/job/work-shifts')
            ->see('Add a new row')
            ->type('Test', 'name')
            ->type('01:00:00', 'from_time')
            ->type('24:00:00', 'to_time')
            ->press('Save changes', '#submit');

        $this->onPage('/admin/job/work-shifts')
            ->see('Record successfully added.')
            ->see('Test');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testDeleteWorkShiftPositive()
    {
        $this->testUpdateWorkShiftPositive();

        $id = $this->onPage('/admin/job/work-shifts')
            ->see('Tested')->filterByNameOrId('edit', 'button')->first()->attr('id');

        $_token = $this->onPage('/admin/job/work-shifts')
            ->see('Tested')->filterByNameOrId('_token', 'input')->attr('value');

        $this->post('/ajax/delete-work-shift', ['id' => $id, '_token' => $_token, '_method' => 'DELETE']);

        $this->dontSee('Tested');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testUpdateWorkShiftPositive()
    {
        $this->logMeIn();

        $id = $this->click('Work Shifts')->onPage('/admin/job/work-shifts')->filterByNameOrId('edit',
            'button')->first()->attr('id');

        $this->click('Work Shifts')
            ->onPage('/admin/job/work-shifts')
            ->type('Tested', 'name')
            ->type('03:00:00', 'from_time')
            ->type('11:00:00', 'to_time')
            ->type($id, 'work_shift_id')
            ->type('PATCH', '_method')
            ->press('Save changes');

        $this->onPage('/admin/job/work-shifts')
            ->see('Record successfully updated.')
            ->see('Tested');
    }
}
