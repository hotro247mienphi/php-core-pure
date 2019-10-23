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
     * @param $sql
     * @return mixed|string|string[]|null
     */
    public static function trimQuery($sql){
        $sql = str_replace(PHP_EOL, '', $sql);
        $sql = preg_replace('#(\s+)#', ' ', $sql);
        return $sql;
    }

    /**
     * @param $sql
     * @param array $bindParam
     * @return bool|\PDOStatement
     */
    public static function exec($sql, $bindParam = [])
    {

        /** @var \PDO $conn */
        $conn = self::getConnect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($bindParam);

        // error_log($sql . PHP_EOL . var_export($bindParam, true) . PHP_EOL, 3, LOG_FILE);
        return $stmt;
    }

    /**
     * @param string $sql
     * @param array $bindParam
     * @param array $bindParamInt
     * @return bool|\PDOStatement
     */
    public static function _select($sql = '', $bindParam = [], $bindParamInt = [])
    {
        $sql = self::trimQuery($sql);

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

        // error_log($sql . PHP_EOL . var_export($bindParam, true) . PHP_EOL . var_export($bindParamInt, true) . PHP_EOL, 3, LOG_FILE);
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

    /**
     * @param string $table
     * @param array $data
     * @return bool|\PDOStatement
     */
    public static function insert($table = '', $data = [])
    {
        $fields = $values = $bindParams = [];

        foreach ($data as $key => $val):
            $fields[] = "`{$key}`";
            $values[] = ":{$key}";

            $bindParams[":{$key}"] = $val;
        endforeach;

        $sql = "INSERT INTO {$table}(" . join(',', $fields) . ") VALUES (" . join(',', $values) . ")";
        $sql = self::trimQuery($sql);

        return self::exec($sql, $bindParams);
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return bool|\PDOStatement
     */
    public static function update($table = '', $data = [], $where = [])
    {
        $fieldsSet = $fieldsWhere = $bindParams = [];

        foreach ($data as $key => $val):
            $fieldsSet[] = "`{$key}`=:{$key}";
            $bindParams[":{$key}"] = $val;
        endforeach;

        foreach ($where as $key => $val):
            $fieldsWhere[] = "`{$key}`=:{$key}";
            $bindParams[":{$key}"] = $val;
        endforeach;

        $sql = "UPDATE {$table} SET " . join(',', $fieldsSet) . " WHERE " . join(',', $fieldsWhere);
        $sql = self::trimQuery($sql);

        return self::exec($sql, $bindParams);
    }

    /**
     * @param $table
     * @param array $where
     * @return bool|\PDOStatement
     */
    public static function delete($table, $where = [])
    {
        $fieldsWhere = $bindParams = [];

        foreach ($where as $key => $val):
            $fieldsWhere[] = "`{$key}`=:{$key}";
            $bindParams[":{$key}"] = $val;
        endforeach;

        $sql = "DELETE FROM {$table} WHERE " . join(',', $fieldsWhere);
        $sql = self::trimQuery($sql);

        return self::exec($sql, $bindParams);
    }
}