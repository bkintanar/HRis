<?php namespace HRis\Services;


class Pagination {

    public static function setupPagination($data, $path)
    {
        $path = '/' . $path . '/?page=';

        $data =  [
            'currentPage'     => $data->currentPage(),
            'prevPageUrl'     => $path . ($data->currentPage() == 1 ? 1 : $data->currentPage() - 1),
            'firstPageUrl'    => $path . '1',
            'lastPageUrl'     => $path . $data->lastPage(),
            'nextPageUrl'     => $data->nextPageUrl(),
            'hasMorePages'    => $data->hasMorePages(),
            'total'           => $data->total(),
            'count'           => $data->count(),
            'total_displayed' => ($data->currentPage() == $data->lastPage()) ? ($data->currentPage() - 1) * DATAS_PER_PAGE + $data->count() : $data->currentPage() * $data->count(),
         ];

        return \View::make('partials.pagination', $data);
    }

} 