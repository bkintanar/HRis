<?php namespace HRis\Services;


use Request;

class Pagination {

    public static function setupPagination($data, $settings)
    {
        $path = '/' . $settings['path'] . '/?page=';
        $sort = '&sort=' . $settings['sort'];
        $direction = '&direction=' . $settings['direction'];
        $data = [
            'currentPage'     => $data->currentPage(),
            'prevPageUrl'     => $path . ($data->currentPage() == 1 ? 1 : $data->currentPage() - 1),
            'nextPageUrl'     => $data->nextPageUrl(),
            'totalPages'      => $data->lastPage(),
            'total'           => $data->total(),
            'pathPage'        => $path,
            'sortPage'        => $sort,
            'directionPage'        => $direction,
            'total_displayed' => ($data->currentPage() == $data->lastPage()) ? ($data->currentPage() - 1) * DATAS_PER_PAGE + $data->count() : $data->currentPage() * $data->count(),
        ];

        return \View::make('partials.pagination', $data);
    }

    public static function getSortLinks($column, $name, $settings)
    {
        $fullUrl = Request::fullUrl();
        $direction = $settings['direction'];

        if (strpos($fullUrl, $column) !== false)
        {
            $direction = $direction == 'asc' ? 'desc' : 'asc';
        }

        return '<a href="/' . $settings['path'] . "?page=1&sort=$column&direction=$direction" . '">' . $name . '  <span class="' . $direction . ' "></span> </a>';
    }

} 