<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Work Shift. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Work Shifts
$I->click('Work Shifts');
$I->seeCurrentUrlEquals('/admin/job/work-shifts');

# Add new record
$I->see('tested');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/delete-work-shift', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested');


