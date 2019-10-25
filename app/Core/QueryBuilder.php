<?php

namespace App\Core;

/**
 * Class QueryBuilder
 * @package App\Core
 */
class QueryBuilder
{
    protected $_select = '*';
    protected $_table = '';
    protected $_where = '';
    protected $_orderby = '';
    protected $_groupby = '';
    protected $_limit = null;
    protected $_offset = null;

    protected $_bindParams = [];
    protected $_bindParamsInt = [];
    protected $_query = '';

    /**
     * @param int $len
     * @return bool|string
     */
    protected function randomKey($len = 10)
    {
        return 'bp_' . substr(md5(mt_rand()), 0, $len);
    }

    /**
     * @param string $key
     * @param $value
     */
    protected function addBindParam($key, $value)
    {
        $this->_bindParams[$key] = $value;
    }

    /**
     * @param string $key
     * @param $value
     */
    protected function addBindParamInt($key, $value)
    {
        $this->_bindParamsInt[$key] = $value;
    }

    /**
     * @return array
     */
    public function getBindParams()
    {
        return [$this->_bindParams, $this->_bindParamsInt];
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function select(array $columns)
    {
        $this->_select = '`' . join('`, `', $columns) . '`';
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function addSelect(array $columns)
    {
        if (strlen($this->_select) > 1) {
            $this->_select .= ', `' . join('`, `', $columns) . '`';
        } else {
            $this->select($columns);
        }
        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function from($table = '')
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * @param string $key
     * @param string $compare
     * @param string $value
     * @return $this
     */
    public function where($key = '', $compare = '', $value = '')
    {
        $keyBind = $this->randomKey();

        if (!$value) {
            $this->_where = sprintf("`%s` = :%s", $key, $keyBind);
            $this->addBindParam($keyBind, $compare);

        } else {
            $this->_where = sprintf("`%s` %s :%s", $key, $compare, $keyBind);
            $this->addBindParam($keyBind, $value);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $compare
     * @param string $value
     * @return $this
     */
    public function andWhere($key = '', $compare = '', $value = '')
    {
        $keyBind = $this->randomKey();
        if (empty($this->_where)) {
            $this->where($key, $compare, $value);
        } else {
            if (!$value) {
                $this->_where .= sprintf(" AND `%s` = :%s", $key, $keyBind);
                $this->addBindParam($keyBind, $compare);
            } else {
                $this->_where .= sprintf(" AND `%s` %s :%s", $key, $compare, $keyBind);
                $this->addBindParam($keyBind, $value);
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $compare
     * @param string $value
     * @return $this
     */
    public function orWhere($key = '', $compare = '', $value = '')
    {
        $keyBind = $this->randomKey();

        if (empty($this->_where)) {
            $this->where($key, $compare, $value);
        } else {
            if (!$value) {
                $this->_where .= sprintf(" OR `%s` = :%s", $key, $keyBind);
                $this->addBindParam($keyBind, $compare);
            } else {
                $this->_where .= sprintf(" OR `%s` %s :%s", $key, $compare, $keyBind);
                $this->addBindParam($keyBind, $value);
            }
        }
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function orWhereGroup(array $params)
    {
        $keyBind = $this->randomKey();

        $condition = [];
        foreach ($params as $param):
            if (count($param) === 2) {
                $condition[] = sprintf("`%s` = :%s", $param[0], $keyBind);
                $this->addBindParam($keyBind, $param[1]);
            }

            if (count($param) === 3) {
                $condition[] = sprintf("`%s` %s %s", $param[0], strtoupper($param[1]), $keyBind);
                $this->addBindParam($keyBind, $param[2]);
            }

        endforeach;

        if (empty($this->_where)) {
            $this->_where = join(' OR ', $condition);
        } else {
            $this->_where .= ' OR (' . join(' OR ', $condition) . ')';
        }
        return $this;
    }

    /**
     * @param $column
     * @param string $type
     * @return $this
     */
    public function order($column, $type = 'asc')
    {
        $this->_orderby = sprintf(" `%s` %s ", $column, $type);
        return $this;
    }

    /**
     * @param null $limit
     * @return $this
     */
    public function limit($limit = null)
    {
        $keyBind = $this->randomKey();
        $this->_limit = ":{$keyBind}";
        $this->addBindParamInt($keyBind, $limit);
        return $this;
    }

    /**
     * @param null $offset
     * @return $this
     */
    public function offset($offset = null)
    {
        $keyBind = $this->randomKey();
        $this->_offset = ":{$keyBind}";
        $this->addBindParamInt($keyBind, $offset);
        return $this;
    }

    /**
     * @param string $column
     * @return $this
     */
    public function group($column = '')
    {
        $this->_groupby = $column;
        return $this;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $this->_query = sprintf('SELECT %s FROM %s', $this->_select, $this->_table);

        if (!empty($this->_where)) {
            $this->_query .= sprintf(' WHERE %s', $this->_where);
        }

        if ($this->_orderby) {
            $this->_query .= sprintf(' ORDER BY %s', $this->_orderby);
        }

        if ($this->_groupby) {
            $this->_query .= sprintf(' GROUP BY %s', $this->_groupby);
        }

        if ($this->_limit) {
            if ($this->_offset) {
                $this->_query .= sprintf(' LIMIT %s OFFSET %s', $this->_limit, $this->_offset);
            } else {
                $this->_query .= sprintf(' LIMIT %s', $this->_limit);
            }
        }

        $this->_query = preg_replace('#(\s+)#', ' ', str_replace(PHP_EOL, '', $this->_query));

        return $this->_query;
    }

    /**
     * flush
     */
    public function flush()
    {
        $this->_select = '*';
        $this->_table = '';
        $this->_where = '';
        $this->_orderby = '';
        $this->_groupby = '';
        $this->_limit = null;
        $this->_offset = null;

        $this->_bindParams = [];
        $this->_bindParamsInt = [];
        $this->_query = '';
    }
}