<?php


namespace App\MyClass;


use Illuminate\Support\Facades\DB;


class VisaFileGradesName
{
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        $nameQuery = DB::table('visa_file_grades')
            ->select('name')->where('id', '=', $this->id)->first();

        return $nameQuery->name;
    }
}
