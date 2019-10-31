<?php


namespace App\Core;


class Validate
{
    /**
     * @param string $email
     * @return mixed
     */
    public static function isEmail($email = '')
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param int $number
     * @return bool
     */
    public static function isNumber($number = 0)
    {
        return is_numeric($number);
    }

    /**
     * @param string $str
     * @param int $min
     * @return bool
     */
    public static function minLength($str = '', $min = 0)
    {
        return strlen($str) >= $min;
    }

    /**
     * @param string $str
     * @param int $max
     * @return bool
     */
    public static function maxLength($str = '', $max = 0)
    {
        return strlen($str) <= $max;
    }

    /**
     * @param string $str
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function lengthRange($str = '', $min = 0, $max = 0)
    {
        return strlen($str) >= $min && strlen($str) <= $max;
    }

    /**
     * @param string $str
     * @return bool
     */
    public static function notEmpty($str = '')
    {
        return empty($str);
    }
}