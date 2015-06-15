<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmploymentStatusTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
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
            ->see('Record successfully added.');
    }

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

    public function testDeleteEmploymentStatusPositive()
    {
        $this->testUpdateEmploymentStatusPositive();

        $this->onPage('/admin/job/employment-status')
            ->see('Tested');

        /*

# Add new record
$I->see('Tested');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/delete-employment-status', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested');
        */
    }
}
