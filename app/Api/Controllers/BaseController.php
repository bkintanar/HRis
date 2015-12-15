<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="api.hris.dev",
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="HRis",
 *         description="Human Resource and Payroll System",
 *         @SWG\Contact(
 *             email="bertrand.kintanar@gmail.com"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Fork HRis on GitHub",
 *         url="https://github.com/bkintanar/HRis"
 *     )
 * )
 */
class BaseController extends Controller
{
    use Helpers;
}
