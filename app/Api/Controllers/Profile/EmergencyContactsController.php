<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Exception;
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
     * Save the Profile - Emergency Contacts.
     *
     * @SWG\Post(
     *     path="/profile/emergency-contacts",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Save the Profile - Emergency Contacts.",
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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(EmergencyContactsRequest $request)
    {
        try {
            $emergency_contact = $this->emergency_contact->create($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['emergency_contact' => $emergency_contact, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Update the Profile - Emergency Contacts.
     *
     * @SWG\Patch(
     *     path="/profile/emergency-contacts",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Update the Profile - Emergency Contacts.",
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
     *         description="employee's emergency contact object that needs to be updated",
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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(EmergencyContactsRequest $request)
    {
        $emergency_contact = $this->emergency_contact->whereId($request->get('id'))->first();

        if (!$emergency_contact) {
            return $this->response()->array(['message' => UNABLE_RETRIEVE_MESSAGE, 'status_code' => 404])->statusCode(404);
        }

        try {
            $emergency_contact->update($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Delete the Profile - Emergency Contacts.
     *
     * @SWG\Delete(
     *     path="/profile/emergency-contacts",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Delete the Profile - Emergency Contacts.",
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
     *     @SWG\Response(response="422", description="Unable to delete record from the database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Unable to delete record from the database.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         description="Employee's emergency contact id to be deleted",
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
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmergencyContactsRequest $request)
    {
        $emergency_contact_id = $request->get('id');

        $response_code = $this->emergency_contact->whereId($emergency_contact_id)->delete();

        if (!$response_code) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }
}
