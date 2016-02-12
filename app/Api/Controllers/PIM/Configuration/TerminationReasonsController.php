<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\PIM\Configuration;

use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\TerminationReason;
use HRis\Api\Requests\PIM\Configuration\TerminationReasonRequest;
use Swagger\Annotations as SWG;

/**
 * Class TerminationReasonsController.
 */
class TerminationReasonsController extends BaseController
{
    /**
     * @var TerminationReason
     */
    protected $termination_reason;

    /**
     * @param TerminationReason $termination_reason
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(TerminationReason $termination_reason)
    {
        $this->termination_reason = $termination_reason;
    }

    /**
     * Delete the PIM Configuration - Termination Reason.
     *
     * @SWG\Delete(
     *     path="/pim/configuration/termination-reasons",
     *     tags={"PIM - Configuration"},
     *     consumes={"application/json"},
     *     summary="Delete the PIM Configuration - Termination Reason.",
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
     *         description="Termination reason id to be deleted",
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
     * @param TerminationReasonRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(TerminationReasonRequest $request)
    {
        return $this->destroyModel($request, $this->termination_reason);
    }

    /**
     * Retrieve the PIM Configuration - Termination Reason.
     *
     * @SWG\Get(
     *     path="/pim/configuration/termination-reasons",
     *     tags={"PIM - Configuration"},
     *     consumes={"application/json"},
     *     summary="Save the PIM Configuration - Termination Reason.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"data", "table", "message", "status_code"},
     *             @SWG\Property(property="data", type="object",
     *                 @SWG\Property(property="total", type="integer", default=22),
     *                 @SWG\Property(property="per_page", type="integer", default=10),
     *                 @SWG\Property(property="current_page", type="integer", default=1),
     *                 @SWG\Property(property="last_page", type="integer", default=3),
     *                 @SWG\Property(property="next_page_url", type="string", default="https://api.hris.dev/api/pim/configuration/termination-reasons?page=2"),
     *                 @SWG\Property(property="prev_page_url", type="string", default="null"),
     *                 @SWG\Property(property="from", type="integer", default=1),
     *                 @SWG\Property(property="to", type="integer", default=10),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(title="termination_reason", ref="#/definitions/TerminationReason"),
     *                 ),
     *             ),
     *             @SWG\Property(property="table", type="object",
     *                 @SWG\Property(property="title", type="string", default="Termination Reason"),
     *                 @SWG\Property(property="permission", type="string", default="pim.configuration.termination-reasons"),
     *                 @SWG\Property(property="headers", type="array",
     *                     @SWG\Items(title="Id", type="string", default="Id"),
     *                 ),
     *                 @SWG\Property(property="model", type="object",
     *                     @SWG\Property(property="singular", type="string", default="termination_reason"),
     *                     @SWG\Property(property="plural", type="string", default="termination_reasons"),
     *                     @SWG\Property(property="dashed", type="string", default="termination-reasons"),
     *                 ),
     *                 @SWG\Property(property="data", type="array"),
     *             ),
     *             @SWG\Property(property="message", type="string", default="Record successfully added.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=true,
     *         type="string",
     *         default="1"
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
     * @param TerminationReasonRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(TerminationReasonRequest $request)
    {
        $termination_reasons = $this->termination_reason->paginate(ROWS_PER_PAGE);

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, ['data' => $termination_reasons, 'table' => $this->setupDataTable($termination_reasons)]);
    }

    /**
     * Setup table for termination reason.
     *
     * @param $termination_reasons
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function setupDataTable($termination_reasons)
    {
        $table = [];

        $table['title'] = 'Termination Reasons';
        $table['permission'] = 'pim.configuration.termination-reasons';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = [
            'singular' => 'termination_reason',
            'plural'   => 'termination_reasons',
            'dashed'   => 'termination-reasons',
        ];
        $table['items'] = $termination_reasons;

        return $table;
    }

    /**
     * Save the PIM Configuration - Termination Reason.
     *
     * @SWG\Post(
     *     path="/pim/configuration/termination-reasons",
     *     tags={"PIM - Configuration"},
     *     consumes={"application/json"},
     *     summary="Save the PIM Configuration - Termination Reason.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"termination_reason", "message", "status_code"},
     *             @SWG\Property(property="termination_reason", ref="#/definitions/TerminationReason"),
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
     *         name="termination_reason",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/TerminationReason")
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
     * @param TerminationReasonRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(TerminationReasonRequest $request)
    {
        return $this->storeModel($request, $this->termination_reason, 'termination_reason');
    }

    /**
     * Update the PIM Configuration - Termination Reason.
     *
     * @SWG\Patch(
     *     path="/pim/configuration/termination-reasons",
     *     tags={"PIM - Configuration"},
     *     consumes={"application/json"},
     *     summary="Update the PIM Configuration - Termination Reason.",
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
     *         name="termination_reason",
     *         in="body",
     *         required=true,
     *         description="termination reason object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/TerminationReason")
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
     * @param TerminationReasonRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(TerminationReasonRequest $request)
    {
        return $this->updateModel($request, $this->termination_reason);
    }
}
