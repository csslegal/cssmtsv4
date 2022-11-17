<?php

namespace App\MyClass;

class GetTimeAgo
{
    /**
     * parametre set Time()
     * @return .. Ago
     */
    function getTimeAgo($time)
    {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return '1 sn önce';
        }
        $condition = array(
            12 * 30 * 24 * 60 * 60 => 'yıl',
            30 * 24 * 60 * 60 => 'ay',
            24 * 60 * 60 => 'gün',
            60 * 60 => 'saat',
            60 => 'dk',
            1 => 'sn'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                return $t . ' ' . $str;
            }
        }
    }
}
