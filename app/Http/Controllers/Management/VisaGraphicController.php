<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;

class VisaGraphicController extends Controller
{
    /**
     *
     */
    public function index()
    {
        return view('management.visa.graphic.index');
    }
    /**
     *
     */
    public function getCalendar()
    {
        return view('management.visa.graphic.calendar');
    }
}
