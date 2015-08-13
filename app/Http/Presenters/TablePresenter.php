<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Presenters;

/**
 * Class TablePresenter
 * @package HRis\Http\Presenters
 */
class TablePresenter
{
    /**
     * @param $logged_user
     * @param $table
     * @return string
     * @author Bertrand Kintanar
     */
    public static function display($logged_user, $table)
    {
        $data['logged_user'] = $logged_user;
        $data['table'] = $table;

        $data['data_table'] = view('partials.tables.' . str_replace('admin.', 'administration.',
                $table['permission']))->with($data)->render();

        return view('partials.table')->with($data)->render();
    }
}
