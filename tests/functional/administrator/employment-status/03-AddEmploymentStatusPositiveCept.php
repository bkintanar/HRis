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
$I->click('Employment Status');
$I->seeCurrentUrlEquals('/admin/job/employment-status');

# Add new record
$I->see('Add a new row');
$I->fillField('name', 'Test');
$I->fillField('class', 'Test Class');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/employment-status');
$I->see('Record successfully added.');

