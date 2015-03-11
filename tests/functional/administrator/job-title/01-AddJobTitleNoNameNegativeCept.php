<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Job Title. [Negative Test]');

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
$I->see('Add a new row');
$I->fillField('name', '');
$I->fillField('description', 'Description Test: ' . Carbon::now()->toDateTimeString());
$I->click('Save changes');

$I->expect('the form is not submitted');
$I->see('Record successfully added.');

