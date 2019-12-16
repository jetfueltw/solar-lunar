<?php

namespace Jetfuel\SolarLunar;

class Solar
{
    public $year;
    public $month;
    public $day;

    public static function create(int $year, int $month, int $day): Solar
    {
        $obj = new static();
        $obj->year = $year;
        $obj->month = $month;
        $obj->day = $day;

        return $obj;
    }
}
