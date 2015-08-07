<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class TerminationReasonTest
 */
class TerminationReasonTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     * @author Bertrand Kintanar
     */
    public function testAddTerminationReasonPositive()
    {
        $this->logMeIn();

        $this->click('Termination Reasons')
            ->onPage('/pim/configuration/termination-reasons')
            ->see('Add a new row')
            ->type('Test', 'name')
            ->press('Save changes', '#submit');

        $this->onPage('/pim/configuration/termination-reasons')
            ->see('Resigned');
    }

//    public function testUpdateTerminationReasonPositive()
//    {
//        $this->logMeIn();
//
//        $id = $this->click('Termination Reasons')->onPage('/pim/configuration/termination-reasons')->filterByNameOrId("edit", 'button')->first()->attr('id');
//
//        $this->click('Termination Reasons')
//            ->onPage('/pim/configuration/termination-reasons')
//            ->type('Tested', 'name')
//            ->type($id, 'termination_reason_id')
//            ->type('PATCH', '_method')
//            ->press('Save changes');
//
//        $this->onPage('/pim/configuration/termination-reasons')
//            ->see('Record successfully updated.')
//            ->see('Tested');
//    }
//
//    public function testDeleteTerminationReasonPositive()
//    {
//        $this->testUpdateTerminationReasonPositive();
//
//        $id = $this->onPage('/pim/configuration/termination-reasons')
//            ->see('Tested')->filterByNameOrId("edit", 'button')->first()->attr('id');
//
//        $_token = $this->onPage('/pim/configuration/termination-reasons')
//            ->see('Tested')->filterByNameOrId("_token", 'input')->attr('value');
//
//        $this->post('/ajax/delete-work-shift', ['id' => $id, '_token' => $_token, '_method' => 'DELETE']);
//
//        $this->dontSee('Tested');
//    }
}
