<?php

namespace App\Service;

use App\Core\Mysql;

/**
 * Class HomeService
 * @package App\Service
 */
class HomeService
{
    /**
     * @return array
     */
    public function dataIndexAction()
    {
        $sql = "SELECT `id`, `name`, `email`, `status`, `created_at` FROM `users` WHERE `id` > :id AND `status` = :status ORDER BY :sort_by DESC LIMIT :limit OFFSET :offset";

        $bindForSql = [
            'id' => 10,
            'status' => 1,
            'sort_by' => 'created_at',
        ];

        $bindIntForSql = [
            'offset' => 10,
            'limit' => 24
        ];

        $data = Mysql::selectAll($sql, $bindForSql, $bindIntForSql);


        // TODO: insert
        /*Mysql::insertBind('users', [
            'name'=> 'thuannd',
            'email'=> 'thuannd@gmail.com',
            'password'=> 'secrect',
            'status'=> 1,
        ]);*/

        // TODO: update
        /*Mysql::update('users', [
            'name' => 'thuannd - pure',
            'password' => md5('secrect'),
        ], ['id' => 208]);*/

        // TODO: delete
        Mysql::delete('users', ['id' => 208]);

        return [
            'data' => $data,
        ];
    }
}