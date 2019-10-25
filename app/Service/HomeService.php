<?php

namespace App\Service;

use App\Core\Mysql;
use App\Core\QueryBuilder;

/**
 * Class HomeService
 * @package App\Service
 */
class HomeService
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $builder = new QueryBuilder();

        $builder->from('users')
            ->select(['id', 'name', 'email', 'status', 'created_at'])
            ->where('id', '>', 10)
            ->andWhere('id', '<', 100)
            ->andWhere('status', 1)
            ->order('created_at', 'desc')
            ->limit(200);

        $data = Mysql::selectAll($builder->generate(), ...$builder->getBindParams());

        $builder->flush();

        return [
            'data' => $data,
        ];
    }
}