<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Qualifications(Work Experience). [Positive Test]');

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

# Update new record
$I->see('Test');
$I->see('Suite');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('company', 'Tested');
$I->fillField('job_title', 'Suited');
$I->fillField('input[name=work_experience_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/qualifications');
$I->see('Record successfully updated.');
$I->see('Tested');
$I->see('Suited');
