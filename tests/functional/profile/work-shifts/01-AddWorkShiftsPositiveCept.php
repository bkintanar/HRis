<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Work Shifts. [Positive Test]');

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
$I->click('Work Shifts');
$I->seeCurrentUrlEquals('/profile/work-shifts');

# Add new record
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/work-shifts/edit');
$I->selectOption('form select[name=work_shift_id]', 'Admin');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/work-shifts');
$I->see('Record successfully updated.');

