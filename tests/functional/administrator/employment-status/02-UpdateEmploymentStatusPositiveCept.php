<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Employment Status. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Employment Status
$I->click('Employment Status');
$I->seeCurrentUrlEquals('/admin/job/employment-status');

# Add new record
$I->see('Test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('name', 'Tested');
$I->fillField('input[name=employment_status_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/employment-status');
$I->see('Record successfully updated.');
$I->see('Tested');

