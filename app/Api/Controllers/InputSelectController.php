<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers;

use HRis\Api\Eloquent\City;
use HRis\Api\Eloquent\Country;
use HRis\Api\Eloquent\Department;
use HRis\Api\Eloquent\EducationLevel;
use HRis\Api\Eloquent\EmploymentStatus;
use HRis\Api\Eloquent\JobTitle;
use HRis\Api\Eloquent\Location;
use HRis\Api\Eloquent\MaritalStatus;
use HRis\Api\Eloquent\Nationality;
use HRis\Api\Eloquent\Province;
use HRis\Api\Eloquent\Relationship;
use HRis\Api\Eloquent\Skill;
use Illuminate\Http\Request;

class InputSelectController extends BaseController
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
     * InputSelectController constructor.
     *
     * @param City             $city
     * @param Country          $country
     * @param Department       $department
     * @param EducationLevel   $education_level
     * @param EmploymentStatus $employment_status
     * @param JobTitle         $job_title
     * @param Location         $location
     * @param MaritalStatus    $marital_status
     * @param Nationality      $nationality
     * @param Province         $province
     * @param Relationship     $relationship
     * @param Skill            $skill
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(City $city, Country $country, Department $department, EducationLevel $education_level, EmploymentStatus $employment_status, JobTitle $job_title, Location $location, MaritalStatus $marital_status, Nationality $nationality, Province $province, Relationship $relationship, Skill $skill)
    {
        $this->city = $city;
        $this->country = $country;
        $this->department = $department;
        $this->education_level = $education_level;
        $this->employment_status = $employment_status;
        $this->job_title = $job_title;
        $this->location = $location;
        $this->marital_status = $marital_status;
        $this->nationality = $nationality;
        $this->province = $province;
        $this->relationship = $relationship;
        $this->skill = $skill;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function cities(Request $request)
    {
        $province_id = $request->get('province_id');

        if (!$province_id) {
            return response()->json([]);
        }

        return $this->chosen($this->city->whereProvinceId($province_id));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function countries(Request $request)
    {
        return $this->chosen($this->country);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function departments(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->department);
        }

        return $this->chosen($this->department);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function educationLevels(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->education_level);
        }

        return $this->chosen($this->education_level);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employmentStatuses(Request $request)
    {
        if ($request->get('table_view')) {
            $this->tableView($this->employment_status, 'class');
        }

        return $this->chosen($this->employment_status, ['class']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function jobTitles(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->job_title);
        }

        return $this->chosen($this->job_title);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function locations(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->location);
        }

        return $this->chosen($this->location);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function maritalStatuses(Request $request)
    {
        return $this->chosen($this->marital_status);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function nationalities(Request $request)
    {
        return $this->chosen($this->nationality);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function provinces(Request $request)
    {
        return $this->chosen($this->province);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function relationships(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->relationship);
        }

        return $this->chosen($this->relationship);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function skills(Request $request)
    {
        if ($request->get('table_view')) {
            return $this->tableView($this->skill);
        }

        return $this->chosen($this->skill);
    }

    /**
     * @param      $model
     * @param null $custom_attribute
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function tableView($model, $custom_attribute = null)
    {
        if ($custom_attribute) {
            return response()->json($model->get(['name', 'id', 'class']));
        }

        return response()->json($model->lists('name', 'id'));
    }

    /**
     * @param      $model
     * @param null $custom_attribute
     *
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json($chosen);
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
}
