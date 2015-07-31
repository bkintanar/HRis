<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Qualifications(Work Experience). [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Profile
$I->click('Profile');
$I->seeCurrentUrlEquals('/profile/personal-details');

# Qualifications
$I->click('Qualifications');
$I->seeCurrentUrlEquals('/profile/qualifications');

# Add new record
$I->see('Add a new row');
$I->fillField('company', 'Test');
$I->fillField('job_title', 'Suite');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/qualifications');
$I->see('Record successfully added.');
