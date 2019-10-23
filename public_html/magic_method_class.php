<?php

const STATUS_PENDING = 3;
const STATUS_RECEIVED = 5;
const STATUS_SUCCESS = 7;
const STATUS_CANCEL = 9;

const HR = '<hr/>';

function listStatus($addAll = false, $addVal = 'Tất Cả', $addKey = 0)
{
    $data = $addAll ? [$addKey => $addVal] : [];
    $data[STATUS_PENDING] = 'Đang Duyệt';
    $data[STATUS_RECEIVED] = 'Đã Nhận';
    $data[STATUS_SUCCESS] = 'Thành Công';
    $data[STATUS_CANCEL] = 'Đã Hủy';
    return $data;
}

/**
 * Interface PhuongTien
 */
interface PhuongTien
{
    public function chay();
}

/**
 * Class PhuongTienDuongBo
 */
class PhuongTienDuongBo implements PhuongTien
{
    protected $attributes = [];
    public $hasWakeup = false;

    public function __debugInfo()
    {
        // TODO: Implement __debugInfo() method.
        return $this->attributes;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return get_called_class();
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
        $this->hasWakeup = true;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if (property_exists($this, $name)) {
            return $this[$name];
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->attributes[$name] = $value;
    }

    public function chay()
    {
        // TODO: Implement chay() method.
        return 'freeway: ' . HR;
    }
}

/**
 * Trait TiepNhienLieu
 */
trait TiepNhienLieu
{
    public function doXang()
    {
        return 'Xang day binh';
    }
}

/**
 * Class XeDap
 */
class XeDap extends PhuongTienDuongBo
{
    public function chay()
    {
        return parent::chay() . 'xe dap chay' . HR;
    }
}

/**
 * Class XeMay
 */
class XeMay extends PhuongTienDuongBo
{
    use TiepNhienLieu;

    public function chay()
    {
        return parent::chay() . 'xe may chay' . HR;
    }
}

/**
 * Class Oto
 */
class Oto extends PhuongTienDuongBo
{
    public function chay()
    {
        return parent::chay() . 'oto chay' . HR;
    }
}

/* --------------------------------------------------------------- */
$xemay = new XeMay();
echo $xemay->doXang();
echo HR;

$xemay->hasWakeup = true;

echo $xemay->hasWakeup;

var_dump(method_exists($xemay, 'hasWakeup'));
var_dump(property_exists($xemay, 'hasWakeup'));
