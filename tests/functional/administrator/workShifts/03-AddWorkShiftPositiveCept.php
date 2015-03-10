<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Pay Grades. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Job Title
$I->click('Work Shifts');
$I->seeCurrentUrlEquals('/admin/job/work-shifts');

# Add new record
$I->see('Add a new row');
$I->fillField('name', 'test');
$I->fillField('from_time', '01:00:00');
$I->fillField('to_time', '24:00:00');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/work-shifts');
$I->see('Record successfully added.');

