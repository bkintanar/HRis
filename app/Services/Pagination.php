<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Services;

use Request;

/**
 * Class Pagination.
 */
class Pagination
{
    /**
     * @param $column
     * @param $name
     * @param $settings
     *
     * @return string
     *
     * @author Jim Callanta
     */
    public static function getSortLinks($column, $name, $settings)
    {
        $fullUrl = Request::fullUrl();
        $direction = $settings['direction'];

        if (strpos($fullUrl, $column) !== false) {
            $direction = $direction == 'asc' ? 'desc' : 'asc';
        }

        return '<a href="/'.$settings['path']."?page=1&sort=$column&direction=$direction".'">'.$name.'  <span class="'.$direction.' "></span> </a>';
    }

    /**
     * @param $data
     * @param $settings
     *
     * @return mixed
     *
     * @author Jim Callanta
     */
    public static function setupPagination($data, $settings)
    {
        $path = '/'.$settings['path'].'/?page=';
        $sort = '&sort='.$settings['sort'];
        $direction = '&direction='.$settings['direction'];

        if ($data->lastPage() > 10) {
            if ($data->currentPage() < 10) {
                $start_page = 1;
            } else {
                if ($data->currentPage() + 4 <= $data->lastPage()) {
                }
            }
        }
        $end_page = $data->lastPage();

        $data = [
            'currentPage'     => $data->currentPage(),
            'prevPageUrl'     => $path.($data->currentPage() == 1 ? 1 : $data->currentPage() - 1),
            'nextPageUrl'     => $data->nextPageUrl(),
            'totalPages'      => $data->lastPage(),
            'total'           => $data->total(),
            'start_page'      => 1,
            'end_page'        => $end_page,
            'pathPage'        => $path,
            'sortPage'        => $sort,
            'directionPage'   => $direction,
            'total_displayed' => ($data->currentPage() == $data->lastPage()) ? ($data->currentPage() - 1) * DATAS_PER_PAGE + $data->count() : $data->currentPage() * $data->count(),
        ];

        return view()->make('partials.pagination', $data);
    }
}
