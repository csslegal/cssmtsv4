<?php


namespace App\MyClass;


use Illuminate\Support\Facades\DB;


class VisaFileGradesName
{
    /**
     * @where Id visa file grades
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return name
     */
    public function getName()
    {
        $nameQuery = DB::table('visa_file_grades')
            ->select('name')
            ->where('id', '=', $this->id)
            ->first();

        return $nameQuery->name;
    }
}
