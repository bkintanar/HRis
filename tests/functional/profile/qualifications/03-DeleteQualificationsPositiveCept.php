<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Qualifications(Work Experience). [Positive Test]');

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

# Delete record
$I->see('Tested');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');
$I->fillField('input[name=work_experience_id]', $id);

$I->sendAjaxPostRequest('/ajax/profile/qualifications/work-experience', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested');
