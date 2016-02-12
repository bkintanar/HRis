<?php

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
