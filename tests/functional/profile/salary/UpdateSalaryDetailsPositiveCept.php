<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Salary Details. [Positive Test]');

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

# Salary
$I->click('Salary');
$I->seeCurrentUrlEquals('/profile/salary');
//$id = $I->grabAttributeFrom('input[name=employee_id]', 'value');
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/salary/edit');
$I->fillField('input[id=salary]', '10000.00');
$I->see('Save changes');

# Modify record
//$I->see('employee ' . $value);
//$I->fillField('input[id=salary]', '10000.00');
//$I->fillField('input[name=employee_id]', $id);
//$I->fillField('input[name=_method]', 'PATCH');
//$I->see('Save changes');

