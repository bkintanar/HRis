<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers;

use HRis\Api\Eloquent\City;
use HRis\Api\Eloquent\Country;
use HRis\Api\Eloquent\CustomFieldType;
use HRis\Api\Eloquent\Department;
use HRis\Api\Eloquent\EducationLevel;
use HRis\Api\Eloquent\EmploymentStatus;
use HRis\Api\Eloquent\JobTitle;
use HRis\Api\Eloquent\Location;
use HRis\Api\Eloquent\MaritalStatus;
use HRis\Api\Eloquent\Nationality;
use HRis\Api\Eloquent\Navlink;
use HRis\Api\Eloquent\Province;
use HRis\Api\Eloquent\Relationship;
use HRis\Api\Eloquent\Skill;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class LookupTableController extends BaseController
{
    /**
     * @var City
     */
    protected $city;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Department
     */
    protected $department;

    /**
     * @var EducationLevel
     */
    protected $education_level;

    /**
     * @var EmploymentStatus
     */
    protected $employment_status;

    /**
     * @var JobTitle
     */
    protected $job_title;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var MaritalStatus
     */
    protected $marital_status;

    /**
     * @var Navlink
     */
    protected $navlink;

    /**
     * @var Nationality
     */
    protected $nationality;

    /**
     * @var Province
     */
    protected $province;

    /**
     * @var Relationship
     */
    protected $relationship;

    /**
     * @var Skill
     */
    protected $skill;

    /**
     * @var bool
     */
    protected $table_view;

    /**
     * InputSelectController constructor.
     *
     * @param City             $city
     * @param Country          $country
     * @param CustomFieldType  $custom_field_type
     * @param Department       $department
     * @param EducationLevel   $education_level
     * @param EmploymentStatus $employment_status
     * @param JobTitle         $job_title
     * @param Location         $location
     * @param MaritalStatus    $marital_status
     * @param Navlink          $navlink
     * @param Nationality      $nationality
     * @param Province         $province
     * @param Relationship     $relationship
     * @param Skill            $skill
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(City $city, Country $country, CustomFieldType $custom_field_type, Department $department, EducationLevel $education_level, EmploymentStatus $employment_status, JobTitle $job_title, Location $location, MaritalStatus $marital_status, Navlink $navlink, Nationality $nationality, Province $province, Relationship $relationship, Skill $skill)
    {
        $this->city = $city;
        $this->country = $country;
        $this->custom_field_type = $custom_field_type;
        $this->department = $department;
        $this->education_level = $education_level;
        $this->employment_status = $employment_status;
        $this->job_title = $job_title;
        $this->location = $location;
        $this->marital_status = $marital_status;
        $this->navlink = $navlink;
        $this->nationality = $nationality;
        $this->province = $province;
        $this->relationship = $relationship;
        $this->skill = $skill;

        $this->table_view = request()->get('table_view') === 'true' ? true : false;
    }

    /**
     * Get cities data for chosen options.
     *
     * @SWG\Get(
     *     path="/cities",
     *     tags={"Chosen Options"},
     *     summary="Get cities data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/City")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="province_id",
     *         in="query",
     *         description="Province primary key",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function cities(Request $request)
    {
        $province_id = $request->get('province_id');

        if (!$province_id) {
            return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
        }

        if ($this->table_view) {
            return $this->tableView($this->city->whereProvinceId($province_id));
        }

        return $this->chosen($this->city->whereProvinceId($province_id));
    }

    /**
     * @param      $model
     * @param null $custom_attribute
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function tableView($model, $custom_attribute = null)
    {
        if ($custom_attribute) {
            $data = $model->get(['name', 'id', 'class']);

            return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('data'));
        }

        $data = $model->lists('name', 'id');

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('data'));
    }

    /**
     * @param      $model
     * @param null $custom_attribute
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function chosen($model, $custom_attribute = null)
    {
        $attributes = $this->mergeAttributes($custom_attribute);

        $collection = $model->get($attributes);

        $chosen = [];
        foreach ($collection as $item) {
            if ($custom_attribute) {
                $chosen[] = ['id' => $item->id, 'name' => $item->name, 'class' => $item->class];
            } else {
                $chosen[] = ['id' => $item->id, 'name' => $item->name];
            }
        }

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('chosen'));
    }

    /**
     * @param $custom_attribute
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function mergeAttributes($custom_attribute)
    {
        $attributes = ['name', 'id'];

        if (is_array($custom_attribute)) {
            $attributes = array_merge($attributes, $custom_attribute);
        }

        return $attributes;
    }

    /**
     * Get countries data for chosen options.
     *
     * @SWG\Get(
     *     path="/countries",
     *     tags={"Chosen Options"},
     *     summary="Get countries data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Country")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
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
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function countries()
    {
        if ($this->table_view) {
            return $this->tableView($this->country);
        }

        return $this->chosen($this->country);
    }

    /**
     * Get departments data for chosen options.
     *
     * @SWG\Get(
     *     path="/departments",
     *     tags={"Chosen Options"},
     *     summary="Get departments data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Department")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function departments()
    {
        if ($this->table_view) {
            return $this->tableView($this->department);
        }

        return $this->chosen($this->department);
    }

    /**
     * Get education levels data for chosen options.
     *
     * @SWG\Get(
     *     path="/education-levels",
     *     tags={"Chosen Options"},
     *     summary="Get education levels data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/EducationLevel")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function educationLevels()
    {
        if ($this->table_view) {
            return $this->tableView($this->education_level);
        }

        return $this->chosen($this->education_level);
    }

    /**
     * Get employment statuses data for chosen options.
     *
     * @SWG\Get(
     *     path="/employment-statuses",
     *     tags={"Chosen Options"},
     *     summary="Get employment statuses data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/EmploymentStatus")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employmentStatuses()
    {
        if ($this->table_view) {
            return $this->tableView($this->employment_status, 'class');
        }

        return $this->chosen($this->employment_status, ['class']);
    }

    /**
     * Get job titles data for chosen options.
     *
     * @SWG\Get(
     *     path="/job-titles",
     *     tags={"Chosen Options"},
     *     summary="Get job titles data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/JobTitle")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function jobTitles()
    {
        if ($this->table_view) {
            return $this->tableView($this->job_title);
        }

        return $this->chosen($this->job_title);
    }

    /**
     * Get locations data for chosen options.
     *
     * @SWG\Get(
     *     path="/locations",
     *     tags={"Chosen Options"},
     *     summary="Get locations data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Location")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function locations()
    {
        if ($this->table_view) {
            return $this->tableView($this->location);
        }

        return $this->chosen($this->location);
    }

    /**
     * Get marital statuses data for chosen options.
     *
     * @SWG\Get(
     *     path="/marital-statuses",
     *     tags={"Chosen Options"},
     *     summary="Get marital statuses data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/MaritalStatus")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function maritalStatuses()
    {
        if ($this->table_view) {
            return $this->tableView($this->marital_status);
        }

        return $this->chosen($this->marital_status);
    }

    /**
     * Get nationalities data for chosen options.
     *
     * @SWG\Get(
     *     path="/nationalities",
     *     tags={"Chosen Options"},
     *     summary="Get nationalities data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Nationality")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function nationalities()
    {
        if ($this->table_view) {
            return $this->tableView($this->nationality);
        }

        return $this->chosen($this->nationality);
    }

    /**
     * Get provinces data for chosen options.
     *
     * @SWG\Get(
     *     path="/provinces",
     *     tags={"Chosen Options"},
     *     summary="Get provinces data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Province")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function provinces()
    {
        if ($this->table_view) {
            return $this->tableView($this->province);
        }

        return $this->chosen($this->province);
    }

    /**
     * Get relationships data for chosen options.
     *
     * @SWG\Get(
     *     path="/relationships",
     *     tags={"Chosen Options"},
     *     summary="Get relationships data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Relationship")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function relationships()
    {
        if ($this->table_view) {
            return $this->tableView($this->relationship);
        }

        return $this->chosen($this->relationship);
    }

    /**
     * Get skills data for chosen options.
     *
     * @SWG\Get(
     *     path="/skills",
     *     tags={"Chosen Options"},
     *     summary="Get skills data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Skill")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function skills()
    {
        if ($this->table_view) {
            return $this->tableView($this->skill);
        }

        return $this->chosen($this->skill);
    }

    /**
     * Get skills data for chosen options.
     *
     * @SWG\Get(
     *     path="/screens",
     *     tags={"Chosen Options"},
     *     summary="Get screens data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Screen")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function screens()
    {
        $navlinks = $this->navlink->whereParentId(-1);

        if ($this->table_view) {
            return $this->tableView($navlinks);
        }

        return $this->chosen($navlinks);
    }

    /**
     * Get skills data for chosen options.
     *
     * @SWG\Get(
     *     path="/types",
     *     tags={"Chosen Options"},
     *     summary="Get custom field types data for chosen options.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/CustomFieldType")
     *         ),
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer "
     *     ),
     *     @SWG\Parameter(
     *         name="table_view",
     *         in="query",
     *         description="Returns a table view",
     *         type="boolean",
     *         default=false
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function types()
    {
        if ($this->table_view) {
            return $this->tableView($this->custom_field_type);
        }

        return $this->chosen($this->custom_field_type);
    }
}
