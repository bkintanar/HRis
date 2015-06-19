<?php

namespace HRis;

/**
 * Class TablePresenter
 * @package HRis
 */
class TablePresenter
{

    /**
     * @param $logged_user
     * @param $table
     * @return string
     */
    public static function display($logged_user, $table)
    {

        $data['logged_user'] = $logged_user;
        $data['table'] = $table;

        $data['data_table'] = view('tables.' . $table['model']['dashed'])->with($data)->render();

        return view('partials.table')->with($data)->render();
    }
}
