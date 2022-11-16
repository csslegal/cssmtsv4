<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\MyClass\TwoDatesBetween;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxVisaGraphicController extends Controller
{
    public $indexArray = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
    public $borderColorArray = [
        'rgba(21, 89, 84, 0.5)',
        'rgba(255, 162, 0, 0.5)',
        'rgba(103, 39, 112, 0.5)',
        'rgba(255, 55, 18, 0.5)',
        'rgba(29, 17, 72, 0.5)',
        'rgba(242, 202, 151, 0.5)',
        'rgba(119, 124, 238, 0.5)',
        'rgba(238, 119, 119, 0.5)',
        'rgba(141, 56, 201, 0.5)',
        'rgba(102, 152, 255, 0.5)',
        'rgba(56, 124, 68, 0.5)',
        'rgba(76, 196, 23, 0.5)',
    ];
    public $backgrounColorArray = [
        'rgba(21, 89, 84, 0.4)',
        'rgba(255, 162, 0, 0.4)',
        'rgba(103, 39, 112, 0.4)',
        'rgba(255, 55, 18, 0.4)',
        'rgba(29, 17, 72, 0.4)',
        'rgba(242, 202, 151, 0.4)',
        'rgba(119, 124, 238, 0.4)',
        'rgba(238, 119, 119, 0.4)',
        'rgba(141, 56, 201, 0.4)',
        'rgba(102, 152, 255, 0.4)',
        'rgba(56, 124, 68, 0.4)',
        'rgba(76, 196, 23, 0.4)',
    ];

    public function quota_day(Request $request)
    {
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];
        $arrayLabels = [];
        $arrayData = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $users = DB::table('users')->where('active', '=', '1')->where('user_type_id', '=', '2')->get();

        foreach ($users as $user) {
            $openCount = DB::table('visa_files')
                ->where('visa_files.advisor_id', '=', $user->id)
                ->whereDate('visa_files.created_at', '>=', date("Y-m-d", strtotime('this day')))
                ->whereDate('visa_files.created_at', '<=', date("Y-m-d", strtotime('this day')))
                ->get()->count();

            if ($openCount == 0) {
                continue;
            }
            array_push($arrayLabels, $user->name);
            array_push($arrayData, $openCount);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';
        $impLabels = '"' . implode('","', $arrayLabels) . '"';
        $impData =  implode(',', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Günlük Dosya Kotası (10)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function quota_week(Request $request)
    {
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];
        $arrayLabels = [];
        $arrayData = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $users = DB::table('users')->where('active', '=', '1')->where('user_type_id', '=', '2')->get();

        foreach ($users as $user) {
            $openCount = DB::table('visa_files')
                ->where('visa_files.advisor_id', '=', $user->id)
                ->whereDate('visa_files.created_at', '>=', date("Y-m-d", strtotime('monday this week')))
                ->whereDate('visa_files.created_at', '<=', date("Y-m-d", strtotime('sunday this week')))
                ->get()->count();

            if ($openCount == 0) {
                continue;
            }
            array_push($arrayLabels, $user->name);
            array_push($arrayData, $openCount);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';
        $impLabels = '"' . implode('","', $arrayLabels) . '"';
        $impData =  implode(',', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Haftalık Dosya Kotası (50)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function quota_mount(Request $request)
    {
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];
        $arrayLabels = [];
        $arrayData = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $users = DB::table('users')->where('active', '=', '1')->where('user_type_id', '=', '2')->get();

        foreach ($users as $user) {
            $openCount = DB::table('visa_files')
                ->where('visa_files.advisor_id', '=', $user->id)
                ->whereDate('visa_files.created_at', '>=', date('Y-m-01'))
                ->whereDate('visa_files.created_at', '<=', date('Y-m-31'))
                ->get()->count();

            if ($openCount == 0) {
                continue;
            }
            array_push($arrayLabels, $user->name);
            array_push($arrayData, $openCount);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';
        $impLabels = '"' . implode('","', $arrayLabels) . '"';
        $impData =  implode(',', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Aylık Dosya Kotası (200)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function quota_year(Request $request)
    {
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';

        $arrayLabels = [];
        $arrayData = [];

        $users = DB::table('users')->where('active', '=', '1')->where('user_type_id', '=', '2')->get();
        foreach ($users as $user) {
            $openCount = DB::table('visa_files')
                ->where('visa_files.advisor_id', '=', $user->id)
                ->whereDate('visa_files.created_at', '>=', date('Y-01-01'))
                ->whereDate('visa_files.created_at', '<=', date('Y-12-31'))
                ->get()->count();

            if ($openCount == 0) {
                continue;
            }
            array_push($arrayLabels, $user->name);
            array_push($arrayData, $openCount);
        }

        $impLabels = '"' . implode('","', $arrayLabels) . '"';
        $impData =  implode(',', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Yıllık Dosya Kotası (2400)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function grades_count(Request $request)
    {

        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';

        $arrayLabels = [];
        $arrayData = [];

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];
        if ($request->input('status') == "all") {
            $visaFilesGradesCount = DB::table('visa_files')
                ->select(['visa_file_grades.name AS visa_file_grades_name', DB::raw('count(*) as total')])
                ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                ->groupBy('visa_files.visa_file_grades_id')
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->pluck('total', 'visa_file_grades_name')->all();
        } else {
            $visaFilesGradesCount = DB::table('visa_files')
                ->select(['visa_file_grades.name AS visa_file_grades_name', DB::raw('count(*) as total')])
                ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                ->groupBy('visa_files.visa_file_grades_id')

                ->where('visa_files.active', '=', $cariDurum)
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->pluck('total', 'visa_file_grades_name')->all();
        }
        foreach ($visaFilesGradesCount as $col => $val) {
            $stringArrayKey = explode(' ', $col);
            array_push($arrayLabels, $stringArrayKey[0] . ' ' . $stringArrayKey[1]);
            array_push($arrayData, $val);
        }

        $impLabels = '"' . implode('", "', $arrayLabels) . '"';
        $impData = implode(', ', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Aşamalara Göre Analizler (Seçilen Tarihler Arası)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function application_office_count(Request $request)
    {
        shuffle($this->indexArray);

        $arrayBorder = [];
        $arrayBackground = [];

        foreach ($this->indexArray as $index) {
            array_push($arrayBorder, $this->borderColorArray[$index]);
            array_push($arrayBackground, $this->backgrounColorArray[$index]);
        }

        $impBorderColor = '"' . implode('","', $arrayBorder) . '"';
        $impBackGrounColor = '"' . implode('","', $arrayBackground) . '"';

        $arrayLabels = [];
        $arrayData = [];

        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];
        if ($request->input('status') == "all") {
            $visaFilesApplicationOfficeCount = DB::table('visa_files')
                ->select(['application_offices.name AS application_office_name', DB::raw('count(*) as total')])
                ->leftJoin('application_offices', 'application_offices.id', '=', 'visa_files.application_office_id')
                ->groupBy('visa_files.application_office_id')
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->pluck('total', 'application_office_name')->all();
        } else {
            $visaFilesApplicationOfficeCount = DB::table('visa_files')
                ->select(['application_offices.name AS application_office_name', DB::raw('count(*) as total')])
                ->leftJoin('application_offices', 'application_offices.id', '=', 'visa_files.application_office_id')
                ->groupBy('visa_files.application_office_id')

                ->where('visa_files.active', '=', $cariDurum)
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->pluck('total', 'application_office_name')->all();
        }
        foreach ($visaFilesApplicationOfficeCount as $col => $val) {
            array_push($arrayLabels, $col);
            array_push($arrayData, $val);
        }

        $impLabels = '"' . implode('", "', $arrayLabels) . '"';
        $impData = implode(', ', $arrayData);

        return '{
            "labels":[' . $impLabels . '],
            "borderColor":[' . $impBorderColor . '],
            "backgroundColor":[' . $impBackGrounColor . '],
            "title":"Başvuru Ofislere Göre Analizler (Seçilen Tarihler Arası)",
            "data": {
                "quantity":[' . $impData . ']
            }
        }';
    }

    public function visa_types_analist(Request $request)
    {
        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $arrayVisaFilesAdvisorsAnalist = [];

        $allVisaTypes = DB::table('visa_types')->select(['id', 'name'])->get();

        foreach ($allVisaTypes as $allVisaType) {

            if ($request->input('status') == "all") {

                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.visa_type_id', '=', $allVisaType->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.visa_type_id', '=', $allVisaType->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            } else {
                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.visa_type_id', '=', $allVisaType->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.visa_type_id', '=', $allVisaType->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            }
            if ($negativeCount == 0 && $positiveCount == 0)
                continue;
            array_push($arrayVisaFilesAdvisorsAnalist, array(
                $allVisaType->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
            ));
        }

        $data = '{
            "title":"Vize Tipleri Sonuc Analizleri(VİZE x RET & Seçilen Tarihler Arası)",
            "datasets":[';

        $oran = 0;
        $plusValue = 0;

        foreach ($arrayVisaFilesAdvisorsAnalist as $value) {
            //array random index
            $randomIndex = rand(0, count($this->backgrounColorArray) - 1);

            $tempOran = $value[1] / ($value[1] + $value[2]) * 100;

            if ($tempOran > $oran) {
                $oran = $tempOran;
                $plusValue++;
            }
            $data .= '{
                "label": "' . $value[0] .  '",
                "backgroundColor": "' . $this->backgrounColorArray[$randomIndex] . '",
                "data": [{
                    "x": ' . $value[1] . ',
                    "y": ' . $value[2] . ',
                    "r": ' . (env('ANALIST_RADIUS_DEFAULT_ORAN') + $plusValue) . '
                }]
            },';
        }
        $data = rtrim($data, ",");
        $data .= ']}';

        return $data;
    }

    public function advisor_analist(Request $request)
    {
        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $arrayVisaFilesAdvisorsAnalist = [];

        $allAdvisors = DB::table('users')
            ->select(['id', 'name'])->where('active', '=', 1)
            ->where('user_type_id', '=',  env('ADVISOR_USER_TYPE_ID'))
            ->get();

        foreach ($allAdvisors as $allAdvisor) {

            if ($request->input('status') == "all") {

                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $iadeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            } else {
                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $iadeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.advisor_id', '=', $allAdvisor->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            }
            if ($iadeCount == 0 && $negativeCount == 0 && $positiveCount == 0)
                continue;
            array_push($arrayVisaFilesAdvisorsAnalist, array(
                $allAdvisor->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
                $iadeCount == null ? 0 : $iadeCount
            ));
        }

        $data = '{
            "title":"Danışman Vize Sonuc Analizleri(VİZE x RET & Seçilen Tarihler Arası)",
            "datasets":[';

        $oran = 0;
        $plusValue = 0;

        foreach ($arrayVisaFilesAdvisorsAnalist as $value) {
            //array random index
            $randomIndex = rand(0, count($this->backgrounColorArray) - 1);

            $tempOran = $value[1] / ($value[1] + $value[2]) * 100;

            if ($tempOran > $oran) {
                $oran = $tempOran;
                $plusValue++;
            }
            $data .= '{
                "label": "' . $value[0] .  '",
                "backgroundColor": "' . $this->backgrounColorArray[$randomIndex] . '",
                "data": [{
                    "x": ' . $value[1] . ',
                    "y": ' . $value[2] . ',
                    "r": ' . (env('ANALIST_RADIUS_DEFAULT_ORAN') + $plusValue) . '
                }]
            },';
        }
        $data = rtrim($data, ",");
        $data .= ']}';

        return $data;
    }

    public function expert_analist(Request $request)
    {
        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $arrayVisaFilesExpertsAnalist = [];

        $allExperts = DB::table('users')->select(['id', 'name'])->where('active', '=', 1)
            ->where('user_type_id', '=',  env('EXPERT_USER_TYPE_ID'))->get();

        foreach ($allExperts as $allExpert) {

            if ($request->input('status') == "all") {

                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $iadeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            } else {
                $positiveCount =   DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $negativeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
                $iadeCount =  DB::table('visa_files')
                    ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.expert_id', '=', $allExpert->id)
                    ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->get()->count();
            }
            if ($iadeCount == 0 && $negativeCount == 0 && $positiveCount == 0)
                continue;

            array_push($arrayVisaFilesExpertsAnalist, array(
                $allExpert->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
                $iadeCount == null ? 0 : $iadeCount
            ));
        }

        $data = '{
            "title":"Uzman Vize Sonuc Analizleri(VİZE x RET & Seçilen Tarihler Arası)",
            "datasets":[';

        $oran = 0;
        $plusValue = 0;

        foreach ($arrayVisaFilesExpertsAnalist as $value) {
            //array random index
            $randomIndex = rand(0, count($this->backgrounColorArray) - 1);

            $tempOran = $value[1] / ($value[1] + $value[2]) * 100;

            if ($tempOran > $oran) {
                $oran = $tempOran;
                $plusValue++;
            }
            $data .= '{
                "label": "' . $value[0] .  '",
                "backgroundColor": "' . $this->backgrounColorArray[$randomIndex] . '",
                "data": [{
                    "x": ' . $value[1] . ',
                    "y": ' . $value[2] . ',
                    "r": ' . (env('ANALIST_RADIUS_DEFAULT_ORAN') + $plusValue) . '
                }]
            },';
        }
        $data = rtrim($data, ",");
        $data .= ']}';

        return $data;
    }

    public function translator_analist(Request $request)
    {
        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        if ($request->has('status') && $request->input('status') != '') {

            if ($request->input('status') == "cari") {
                $cariDurum = 1;
            } else {
                $cariDurum = 0;
            }
        } else {
            $cariDurum = 1;
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $arrayVisaFilesTranslationsAnalist = [];

        $allTranslations = DB::table('users')->select(['id', 'name'])->where('active', '=', 1)
            ->where('user_type_id', '=',  env('TRANSLATION_USER_TYPE_ID'))->get();

        foreach ($allTranslations as $allTranslation) {

            if ($request->input('status') == "all") {

                $visaFilesTranslation = DB::table('visa_files')
                    ->select([
                        DB::raw("COUNT(visa_files.id) as visa_files_count"),
                        DB::raw("SUM(visa_translations.translated_page) as translated_page_count"),
                        DB::raw("SUM(visa_translations.translated_word) as translated_word_count"),
                    ])
                    ->join('visa_translations', 'visa_translations.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.translator_id', '=', $allTranslation->id)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->first();
            } else {

                $visaFilesTranslation = DB::table('visa_files')
                    ->select([
                        DB::raw("COUNT(visa_files.id) as visa_files_count"),
                        DB::raw("SUM(visa_translations.translated_page) as translated_page_count"),
                        DB::raw("SUM(visa_translations.translated_word) as translated_word_count"),
                    ])
                    ->join('visa_translations', 'visa_translations.visa_file_id', '=', 'visa_files.id')
                    ->where('visa_files.translator_id', '=', $allTranslation->id)
                    ->where('visa_files.active', '=', $cariDurum)
                    ->whereDate('visa_files.created_at', '>=', $startDate)
                    ->whereDate('visa_files.created_at', '<=', $endDate)
                    ->first();
            }
            if ($visaFilesTranslation->visa_files_count == 0)
                continue;

            array_push($arrayVisaFilesTranslationsAnalist, array(
                $allTranslation->name,
                $visaFilesTranslation->visa_files_count == null ? 0 : $visaFilesTranslation->visa_files_count,
                $visaFilesTranslation->translated_page_count == null ? 0 : $visaFilesTranslation->translated_page_count,
                $visaFilesTranslation->translated_word_count == null ? 0 : $visaFilesTranslation->translated_word_count,
            ));
        }

        $data = '{
            "title":"Tercüman Vize Dosyası Tercüme Analizleri(Sayfa x Kelime & Seçilen Tarihler Arası)",
            "datasets":[';

        $oran = 0;
        $plusValue = 0;

        foreach ($arrayVisaFilesTranslationsAnalist as $value) {
            //array random index
            $randomIndex = rand(0, count($this->backgrounColorArray) - 1);

            $tempOran = $value[1] / ($value[1] + $value[2]) * 100;
            if ($tempOran > $oran) {
                $oran = $tempOran;
                $plusValue++;
            }
            $data .= '{
                "label": "' . $value[0] .  '",
                "backgroundColor": "' . $this->backgrounColorArray[$randomIndex] . '",
                "data": [{
                    "x": ' . $value[1] . ',
                    "y": ' . $value[2] . ',
                    "r": ' . (env('ANALIST_RADIUS_DEFAULT_ORAN') + $plusValue) . '
                }]
            },';
        }
        $data = rtrim($data, ",");
        $data .= ']}';

        return $data;
    }

    public function open_made_analist(Request $request)
    {
        $twoDatesBetween = new TwoDatesBetween(
            date("Y-m-d", strtotime('-1 year', strtotime(date("Y-m-d")))),
            date("Y-m-d", strtotime('+15 day', strtotime(date("Y-m-d"))))
        );

        $visaFileOpenArray = [];
        $visaFileMadeArray = [];
        $visaFileMountArray = [];

        foreach ($twoDatesBetween->mounts() as $mount) {

            $mountExp = explode('-', $mount);

            $openCount = DB::table('visa_files')
                ->whereMonth('visa_files.created_at', $mountExp[1])
                ->whereYear('visa_files.created_at', $mountExp[0])->get()->count();
            $madeCount = DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->whereMonth('visa_application_result.visa_file_close_date', $mountExp[1])
                ->whereYear('visa_application_result.visa_file_close_date', $mountExp[0])->get()->count();

            if ($openCount == 0 && $madeCount == 0) {
                continue;
            }
            array_push($visaFileMountArray, $mount);
            array_push($visaFileOpenArray, $openCount);
            array_push($visaFileMadeArray, $madeCount);
        }

        $impLabels = '"' . implode('", "', $visaFileMountArray) . '"';
        $impOpen = implode(', ', $visaFileOpenArray);
        $impMade = implode(', ', $visaFileMadeArray);


        return '{
            "title":"Açılan ve Yapılan Dosya Analizleri (Son 12 Ay)",
            "labels":[' . $impLabels . '],
            "datasets":[{
                "label": "Açılan Dosya Sayısı",
                "data": [' . $impOpen . '],
                "borderColor": "rgba(255, 55, 18, 1)","backgroundColor": "rgba(255, 55, 18, 0.5)",
                "borderWidth": 1,"borderRadius": 20,"borderSkipped": false
                },{
                "label": "Yapılan Dosya Sayısı",
                "data":[' . $impMade . '],
                "borderColor": "rgba(21, 89, 84, 1)","backgroundColor": "rgba(21, 89, 84, 0.5)",
                "borderWidth": 1,"borderRadius": 20,"borderSkipped": false
            }]
        }';
    }
}
