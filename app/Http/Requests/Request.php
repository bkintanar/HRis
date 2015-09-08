<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request.
 */
abstract class Request extends FormRequest
{
    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }

    /**
     * Get the sort param.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function sort()
    {
        return $this->get('sort') != '' ? $this->get('sort') : 'id';
    }

    /**
     * Get the direction param.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function direction()
    {
        return $this->get('direction') != '' ? $this->get('direction') : 'asc';
    }

    /**
     * Get the pagination settings.
     *
     * @return array
     *
     * @author Harlequin Doyon
     */
    public function paginationSettings()
    {
        return ['path' => $this->path(), 'sort' => $this->sort(), 'direction' => $this->direction()];
    }
}
