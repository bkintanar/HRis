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
 
namespace HRis\Api\Controllers\Profile;

use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\EmergencyContact;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\EmergencyContactsRequest;
use Swagger\Annotations as SWG;

class EmergencyContactsController extends BaseController
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var EmergencyContact
     */
    protected $emergency_contact;

    /**
     * @param Employee         $employee
     * @param EmergencyContact $emergency_contact
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, EmergencyContact $emergency_contact)
    {
        $this->employee = $employee;
        $this->emergency_contact = $emergency_contact;
    }

    /**
     * Stores a single instance of Emergency Contact.
     *
     * @SWG\Post(
     *     path="/profile/emergency-contacts",
     *     description="This route provides the ability to store a single instance of Emergency Contact.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Stores a single instance of Emergency Contact.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"emergency_contact", "message", "status_code"},
     *             @SWG\Property(property="emergency_contact", ref="#/definitions/EmergencyContact"),
     *             @SWG\Property(property="message", type="string", default="Record successfully added.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=201, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Response(response="422", description="Unable to add record to the database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Unable to add record to the database.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="emergency_contact",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/EmergencyContact")
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     * )
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(EmergencyContactsRequest $request)
    {
        return $this->storeModel($request, $this->emergency_contact, 'emergency_contact');
    }

    /**
     * Updates a single instance of Emergency Contact.
     *
     * @SWG\Patch(
     *     path="/profile/emergency-contacts",
     *     description="This route provides the ability to update a single instance of Emergency Contact.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Updates a single instance of Emergency Contact.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Record successfully updated.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Response(response="404", description="Unable to retrieve record from database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Unable to retrieve record from database.", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Response(response="422", description="Unable to update record.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Unable to update record.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="emergency_contact",
     *         in="body",
     *         required=true,
     *         description="Emergency contact object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/EmergencyContact")
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     * )
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(EmergencyContactsRequest $request)
    {
        return $this->updateModel($request, $this->emergency_contact);
    }

    /**
     * Deletes a single instance of Emergency Contact.
     *
     * @SWG\Delete(
     *     path="/profile/emergency-contacts/{emergency_contact}",
     *     description="This route provides the ability to delete a Emergency Contact.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Deletes a single instance of Emergency Contact.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Record successfully deleted.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Response(response="422", description="422 Unprocessable Entity",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="422 Unprocessable Entity", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="emergency_contact",
     *         in="path",
     *         description="Emergency contact id to be deleted",
     *         required=true,
     *         type="integer",
     *         format="int64",
     *         default=1,
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     * )
     *
     * @param EmergencyContact         $emergency_contact
     * @param EmergencyContactsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmergencyContact $emergency_contact, EmergencyContactsRequest $request)
    {
        return $this->destroyModel($emergency_contact, $this->emergency_contact);
    }
}
