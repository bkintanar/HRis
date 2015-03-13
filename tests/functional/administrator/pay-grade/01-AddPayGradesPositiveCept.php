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

# Pay Grades
$I->click('Pay Grades');
$I->seeCurrentUrlEquals('/admin/job/pay-grades');

# Add new record
$I->see('Add a new row');
$I->fillField('name', 'Test');
$I->fillField('min_salary', '010000');
$I->fillField('max_salary', '020000');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/pay-grades');
$I->see('Record successfully added.');

