<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobTitleTest extends \TestCase
{
    use DatabaseTransactions;

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

    public function testDeleteJobTitlePositive()
    {
        $this->testUpdateJobTitlePositive();

        $id = $this->onPage('/admin/job/titles')
            ->see('Tested')->filterByNameOrId("edit", 'button')->first()->attr('id');

        $_token = $this->onPage('/admin/job/titles')
            ->see('Tested')->filterByNameOrId("_token", 'input')->attr('value');

        $this->post('/ajax/delete-job-title', ['id' => $id, '_token' => $_token, '_method' => 'DELETE']);

        $this->dontSee('Tested');
    }

    public function testUpdateJobTitlePositive()
    {
        $this->logMeIn();

        $id = $this->click('Job Titles')->onPage('/admin/job/titles')->filterByNameOrId("edit",
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
