<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Work Shift. [Positive Test]');

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
$I->see('test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->fillField('input[name=work_shift_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->fillField('name', 'tested');
$I->fillField('from_time', '03:00:00');
$I->fillField('to_time', '11:00:00');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/work-shifts');
$I->see('Record successfully updated.');

