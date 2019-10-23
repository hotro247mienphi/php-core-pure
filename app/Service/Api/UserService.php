<?php


namespace App\Service\Api;

use App\Core\Mysql;

class UserService
{
    public function dataIndexAction()
    {
        $sql = "SELECT `id`, `name`, `email`, `status`, `created_at` FROM `users`";
        $data = Mysql::selectAll($sql);
        return [
            'data' => $data,
        ];
    }
}