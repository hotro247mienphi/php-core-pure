<?php

namespace App\Core;

/**
 * Class Mysql
 * @package App\Core
 *
 * PDOStatement::bindParam nhận giá trị value là 1 biến con trỏ
 * PDOStatement::bindValue nhận giá trị value là 1 biến thường
 */
class Mysql
{

    public static $instance;

    /**
     * @return mixed
     */
    public static function getConnect()
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::connect();

        return self::$instance;
    }

    public static function connect()
    {
        $servername = env('DB_HOST', 'localhost');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $dbname = env('DB_DATABASE', 'test');
        $charset = env('DB_CHARSET', 'utf8');

        try {
            self::$instance = new \PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log($e->getMessage(), 3, ERROR_FILE);
        }
    }

    /**
     * @param string $sql
     * @param array $bindParam
     * @param array $bindParamInt
     * @return bool|\PDOStatement
     */
    public static function _select($sql = '', $bindParam = [], $bindParamInt = [])
    {
        $sql = str_replace(PHP_EOL, '', $sql);
        $sql = preg_replace('#(\s+)#', ' ', $sql);

        /** @var \PDO $conn */
        $conn = self::getConnect();
        $stmt = $conn->prepare($sql);

        if ($bindParam) {
            foreach ($bindParam as $key => $val):
                $stmt->bindValue(":$key", $val);
            endforeach;
        }

        if ($bindParamInt) {
            foreach ($bindParamInt as $key => $val):
                $stmt->bindValue(":$key", $val, \PDO::PARAM_INT);
            endforeach;
        }

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_OBJ);

        // error_log($sql . PHP_EOL . var_export($bindParam, true) . PHP_EOL . var_export($bindParamInt, true).PHP_EOL, 3, LOG_FILE);
        return $stmt;
    }

    /**
     * @param string $sql
     * @param array $bindParam
     * @param array $bindParamInt
     * @return array
     */
    public static function selectAll($sql = '', $bindParam = [], $bindParamInt = [])
    {
        $stmt = self::_select($sql, $bindParam, $bindParamInt);
        return $stmt->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $bindParam
     * @param array $bindParamInt
     * @return mixed
     */
    public static function selectOne($sql = '', $bindParam = [], $bindParamInt = [])
    {
        $stmt = self::_select($sql, $bindParam, $bindParamInt);
        return $stmt->fetch();
    }

}