<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Http\Controllers\Admin\Job;

use Api\Controllers\BaseController;
use HRis\Api\Eloquent\JobTitle;
use HRis\Api\Requests\Admin\Job\JobTitleRequest;

class JobTitleController extends BaseController
{
    private $job_title;

    /**
     * @param JobTitle $job_title
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(JobTitle $job_title)
    {
        $this->job_title = $job_title;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index()
    {
        return $this->xhr($this->job_title->all());
    }

    /**
     * @param JobTitleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(JobTitleRequest $request)
    {
        $job_title = $this->job_title->whereId($request->get('job_title_id'))->first();

        if (!$job_title) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $job_title->update($request->all());
        } catch (Exception $e) {
            return $this->xhr(UNABLE_UPDATE_MESSAGE, 500);
        }

        return $this->xhr(SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * @param JobTitleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(JobTitleRequest $request)
    {
        try {
            $job_title = $this->job_title->create($request->all());
        } catch (Exception $e) {
            return $this->xhr(UNABLE_ADD_MESSAGE, 500);
        }

        return $this->xhr(['job_title' => $job_title, 'text' => SUCCESS_ADD_MESSAGE]);
    }

    /**
     * @param JobTitleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(JobTitleRequest $request)
    {
        $job_title_id = $request->get('id');

        try {
            $this->job_title->whereId($job_title_id)->delete();
        } catch (Exception $e) {
            return $this->xhr(UNABLE_DELETE_MESSAGE);
        }

        return $this->xhr(SUCCESS_DELETE_MESSAGE);
    }
}
