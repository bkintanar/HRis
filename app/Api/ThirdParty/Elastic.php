<?php

namespace HRis\Api\ThirdParty;

use Elasticsearch\Client;
use Irradiate\Eloquent\Employee;

class Elastic
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Elastic constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Delete a single item.
     *
     * @param array $parameters
     *
     * @return array
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    /**
     * Index multiple items.
     *
     * This method normalises the 'bulk' method of the Elastic Search
     * Client to have a signature more similar to 'index'.
     *
     * @param array $collection [[index, type, id, body], [index, type, id, body]...]
     *
     * @return array
     */
    public function indexMany(array $collection)
    {
        $parameters = [];

        foreach ($collection as $item) {
            $parameters['body'][] = [
                'index' => [
                    '_id'    => $item['id'],
                    '_index' => $item['index'],
                    '_type'  => $item['type'],
                ],
            ];

            $parameters['body'][] = $item['body'];
        }

        return $this->client->bulk($parameters);
    }

    /**
     * Delete Index.
     *
     * This suppresses any exceptions thrown by trying
     * to delete a non-existent index by first
     * checking if it exists, then deleting.
     *
     * @param string $name
     *
     * @return bool
     */
    public function deleteIndex($name)
    {
        if (!$this->indexExists($name)) {
            return true;
        }

        return $this->client->indices()->delete([
            'index' => $name,
        ]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function indexExists($name)
    {
        return $this->client->indices()->exists(['index' => $name]);
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function searchEmployee($request)
    {
        //        $query = [
//            'multi_match' => [
//                [
//                    'query'  => $request['query'],
//                    'fields' => [
//                        'employee_id^10', 'face_id', 'first_name^10', 'middle_name', 'last_name^9', 'suffix_name',
//                        'avatar', 'gender', 'address_1', 'address_2', 'address_postal_code', 'home_phone',
//                        'mobile_phone', 'work_email', 'other_email', 'social_security', 'tax_identification',
//                        'philhealth', 'hdmf_pagibig', 'mid_rtn', 'birth_date', 'remarks', 'joined_date',
//                        'probation_end_date', 'permanency_date', 'resign_date', 'city.name', 'country.name',
//                        'marital_status.name', 'nationality.name', 'province.name', 'user.email^8'
//                    ],
//                ],
//            ],
//        ];

        $query = [
            'query_string' => [
                'query'                => $request['query'].' OR *'.$request['query'].'*',
                'use_dis_max'          => true,
                'fuzzy_max_expansions' => 50,
                'fuzziness'            => 'AUTO',
            ],
        ];

        $parameters = [
            'index' => 'hris',
            'type'  => 'employee',
            'body'  => [
                'query' => $query,
            ],
        ];

        return $this->search($parameters);
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function search(array $parameters)
    {
        return $this->client->search($parameters);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Index all employees.
     *
     * @param Employee $employee
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function indexAllEmployees(Employee $employee)
    {
        $employees = $employee->with($employee->includes())->get();

        foreach ($employees as $employee) {
            $this->index([
                'index' => 'hris',
                'type'  => 'employee',
                'id'    => $employee->id,
                'body'  => $employee->toArray(),
            ]);
        }

        return $employees->count();
    }

    /**
     * Index a single item.
     *
     * @param array $parameters [index, type, id, body]
     *
     * @return array
     */
    public function index(array $parameters)
    {
        return $this->client->index($parameters);
    }
}
