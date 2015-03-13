<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Job Title. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Job Title
$I->click('Job Titles');
$I->seeCurrentUrlEquals('/admin/job/titles');

# Add new record
$I->see('Test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('name', 'Tested');
$I->fillField('description', 'Description Tested: ' . Carbon::now()->toDateString());
$I->fillField('input[name=work_shift_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/titles');
$I->see('Record successfully updated.');
$I->see('Tested');

