<?php

namespace App\MyClass;

class TwoDatesBetween
{
    private $startDate;
    private $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function days()
    {
        $aryRange = array();
        $iDateFrom = mktime(1, 0, 0, substr($this->startDate, 5, 2), substr($this->startDate, 8, 2), substr($this->startDate, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($this->endDate, 5, 2), substr($this->endDate, 8, 2), substr($this->endDate, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-n-j', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-n-j', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function mounts()
    {
        $aryRange = array();
        $iDateFrom = mktime(1, 0, 0, substr($this->startDate, 5, 2), substr($this->startDate, 8, 2), substr($this->startDate, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($this->endDate, 5, 2), substr($this->endDate, 8, 2), substr($this->endDate, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            while ($iDateFrom < $iDateTo) {
                array_push($aryRange, date('Y-m', $iDateFrom));
                $iDateFrom += (86400 * 31); // add 24 hours
            }
        }
        return $aryRange;
    }
    public function years()
    {
        $aryRange = array();

        $start = explode("-", $this->startDate);
        $end = explode("-", $this->endDate);

        $startYear = $start[0];
        $endYear = $end[0];

        if ($endYear >= $startYear) {
            array_push($aryRange, $startYear); // first entry
            while ($startYear <= $endYear) {
                array_push($aryRange, $startYear);
                $startYear++;
            }
        }
        return $aryRange;
    }
}
