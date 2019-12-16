<?php

namespace Jetfuel\SolarLunar;

class Lunar
{
    public $year;
    public $month;
    public $day;
    public $isLeap;

    public static function create(int $year, int $month, int $day, bool $isLeap): Lunar
    {
        $obj = new static();
        $obj->year = $year;
        $obj->month = $month;
        $obj->day = $day;
        $obj->isLeap = $isLeap;

        return $obj;
    }
}
