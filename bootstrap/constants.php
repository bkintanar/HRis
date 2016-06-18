<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

const PERMISSION_VIEW = 1;
const PERMISSION_UPDATE = 2;
const PERMISSION_DELETE = 4;
const PERMISSION_CREATE = 8;

const ROWS_PER_PAGE = 10;

const PROFILE_IDS = 2;

// Standard failed message
const UNABLE_ADD_MESSAGE = 'Unable to add record to the database.';
const UNABLE_RETRIEVE_MESSAGE = 'Unable to retrieve record from database.';
const UNABLE_UPDATE_MESSAGE = 'Unable to update record.';
const UNABLE_DELETE_MESSAGE = 'Unable to delete record from the database.';
const UNPROCESSABLE_ENTITY = '422 Unprocessable Entity';

// Standard success message
const SUCCESS_ADD_MESSAGE = 'Record successfully added.';
const SUCCESS_RETRIEVE_MESSAGE = 'Record successfully retrieved.';
const SUCCESS_UPDATE_MESSAGE = 'Record successfully updated.';
const SUCCESS_DELETE_MESSAGE = 'Record successfully deleted.';

const EMPLOYEE_ID_IN_MESSAGE = 'Employee Id already in use.';
const EMPLOYEE_ID_NOT_FOUND = 'Employee Id not found.';

const SUCCESS_RETRIEVE_SIDEBAR_MESSAGE = 'Navlinks successfully retrieved.';
const SUCCESS_TOKEN_REFRESH_MESSAGE = 'Token successfully refreshed.';
const SUCCESS_TOKEN_CREATED_MESSAGE = 'Token successfully created.';

const UNABLE_TO_CREATE_TIMELOG = 'Unable to create timelog.';
