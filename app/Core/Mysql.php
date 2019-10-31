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

    /** @var \PDO $instance */
    public static $instance;

    /**
     * @return \PDO
     */
    public static function getInstance()
    {
        if (self::$instance instanceof \PDO) {
            return self::$instance;
        }
        self::connect();
        return self::$instance;
    }

    /**
     * connect to database and assign to $instance
     */
    public static function connect()
    {
        $db = Config::get('db');
        try {
            self::$instance = new \PDO("mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}", $db['user'], $db['pass']);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log($e->getMessage(), 3, ERROR_FILE);
        }
    }

    /**
     * @param $sql
     * @return mixed|string|string[]|null
     */
    public static function trimQuery($sql)
    {
        $sql = str_replace(PHP_EOL, '', $sql);
        $sql = preg_replace('#(\s+)#', ' ', $sql);
        return $sql;
    }

    /**
     * @param $sql
     * @param array $bindParam
     * @return mixed
     */
    public static function exec($sql, $bindParam = [])
    {
        $sql = self::trimQuery($sql);
        $conn = self::getInstance();
        $stmt = $conn->prepare($sql);
        $stmt->execute($bindParam);

        // error_log($sql . PHP_EOL . var_export($bindParam, true) . PHP_EOL, 3, LOG_FILE);
        return $conn;
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
        $conn = self::getInstance();
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
     * @param null $id
     * @return mixed
     */
    public static function findById($table = '', $id = null)
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE `id`=:id', $table);
        $stmt = self::_select($sql, ['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $where
     * @return mixed
     */
    public static function find($table = '', $columns = [], $where = [])
    {
        $fields = $fieldsWhere = $bindParams = [];

        foreach ($columns as $key => $val):
            $fields[] = "`{$key}`";
            $bindParams[":{$key}"] = $val;
        endforeach;

        foreach ($where as $item):
            $fieldsWhere[] = "`{$item[0]}` {$item[1]} :{$item[0]}";
            $bindParams[":{$item[0]}"] = $item[2];
        endforeach;

        $sql = sprintf('SELECT %s FROM `%s` WHERE %s', $table, join(',', $fields), join(',', $fieldsWhere));
        $stmt = self::_select($sql, $bindParams);

        return $stmt->fetchAll();
    }

    /**
     * @param string $table
     * @param array $data
     * @return \PDO
     */
    public static function insert($table = '', $data = [])
    {
        $fields = $values = $bindParams = [];

        foreach ($data as $key => $val):
            $fields[] = "`{$key}`";
            $values[] = ":{$key}";
            $bindParams[":{$key}"] = $val;
        endforeach;

        $sql = sprintf('INSERT INTO `%s`(%s) VALUES(%s)', $table, join(',', $fields), join(',', $values));
        return self::exec($sql, $bindParams);
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return \PDO
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

        $sql = sprintf('UPDATE `%s` SET %s WHERE %s', $table, join(',', $fieldsSet), join(',', $fieldsWhere));

        return self::exec($sql, $bindParams);
    }

    /**
     * @param $table
     * @param array $where
     * @return \PDO
     */
    public static function delete($table, $where = [])
    {
        $fieldsWhere = $bindParams = [];

        foreach ($where as $key => $val):
            $fieldsWhere[] = "`{$key}`=:{$key}";
            $bindParams[":{$key}"] = $val;
        endforeach;

        $sql = sprintf('DELETE FROM %s WHERE %s', $table, join(',', $fieldsWhere));

        return self::exec($sql, $bindParams);
    }
}