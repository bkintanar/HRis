<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Pay Grades. [Positive Test]');

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
$I->see('Test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->fillField('input[name=pay_grade_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->fillField('name', 'Tested');
$I->fillField('min_salary', '015000');
$I->fillField('max_salary', '025000');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/admin/job/pay-grades');
$I->see('Record successfully updated.');

