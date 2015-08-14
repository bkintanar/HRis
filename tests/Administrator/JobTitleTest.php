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
 * Class JobTitleTest.
 */
class JobTitleTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     * @author Bertrand Kintanar
     */
    public function testAddJobTitlePositive()
    {
        $this->logMeIn();

        $this->click('Job Titles')
            ->onPage('/admin/job/titles')
            ->see('Add a new row')
            ->type('Test', 'name')
            ->type('Test Description', 'description')
            ->press('Save changes', '#submit');

        $this->onPage('/admin/job/titles')
            ->see('Record successfully added.')
            ->see('Test');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testDeleteJobTitlePositive()
    {
        $this->testUpdateJobTitlePositive();

        $id = $this->onPage('/admin/job/titles')
            ->see('Tested')->filterByNameOrId('edit', 'button')->first()->attr('id');

        $_token = $this->onPage('/admin/job/titles')
            ->see('Tested')->filterByNameOrId('_token', 'input')->attr('value');

        $this->post('/ajax/delete-job-title', ['id' => $id, '_token' => $_token, '_method' => 'DELETE']);

        $this->dontSee('Tested');
    }

    /**
     * @author Bertrand Kintanar
     */
    public function testUpdateJobTitlePositive()
    {
        $this->logMeIn();

        $id = $this->click('Job Titles')->onPage('/admin/job/titles')->filterByNameOrId('edit',
            'button')->first()->attr('id');

        $this->click('Job Titles')
            ->onPage('/admin/job/titles')
            ->type('Tested', 'name')
            ->type('Test Class', 'description')
            ->type($id, 'job_title_id')
            ->type('PATCH', '_method')
            ->press('Save changes');

        $this->onPage('/admin/job/titles')
            ->see('Record successfully updated.')
            ->see('Tested');
    }
}
