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
 * Class EmploymentStatusTest.
 */
class EmploymentStatusTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     * @author Bertrand Kintanar
     */
    public function testAddEmploymentStatusPositive()
    {
        $this->logMeIn();

        $this->click('Employment Status')
            ->onPage('/admin/job/employment-status')
            ->see('Add a new row')
            ->type('Test', 'name')
            ->type('Test Class', 'class')
            ->press('Save changes', '#submit');

        $this->onPage('/admin/job/employment-status')
            ->see('Record successfully added.')
            ->see('Test');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testDeleteEmploymentStatusPositive()
    {
        $this->testUpdateEmploymentStatusPositive();

        $id = $this->onPage('/admin/job/employment-status')
            ->see('Tested')->filterByNameOrId('edit', 'button')->last()->attr('id');

        $_token = $this->onPage('/admin/job/employment-status')
            ->see('Tested')->filterByNameOrId('_token', 'input')->attr('value');

        $this->post('/ajax/delete-employment-status', ['id' => $id, '_token' => $_token, '_method' => 'DELETE']);

        $this->dontSee('Tested');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testUpdateEmploymentStatusPositive()
    {
        $this->logMeIn();

        $this->click('Employment Status')
            ->onPage('/admin/job/employment-status')
            ->type('Tested', 'name')
            ->type('Test Class', 'class')
            ->type(3, 'employment_status_id')
            ->type('PATCH', '_method')
            ->press('Save changes');

        $this->onPage('/admin/job/employment-status')
            ->see('Record successfully updated.')
            ->see('Tested');
    }
}
