<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update My Job Details. [Positive Test]');

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

# Job
$I->click('Job');
$I->seeCurrentUrlEquals('/profile/job');

# Update Job record
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/job/edit');
//$I->selectOption('form select[name=job_title_id]', 'Team Leader');
//$I->fillField('input[name=effective_date]', Carbon::now()->toDateString());
//$I->fillField('textarea[name=comments]', 'Test Suite');
//$I->click('Save changes');
//
//$I->seeCurrentUrlEquals('/profile/job');
//$I->see('Record successfully updated.');
//
//

