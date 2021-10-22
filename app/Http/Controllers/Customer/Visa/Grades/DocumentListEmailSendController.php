<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DocumentListEmailSendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select(
                [
                    'customers.id AS id',
                    'visa_files.id AS visa_file_id',
                ]
            )
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        $languages = DB::table('language')->get();

        return view('customer.visa.grades.document-list-email-send')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'languages' => $languages,
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  store($id, $visa_file_id, Request $request)
    {
        $request->validate(['dil' => 'required|numeric',]);

        $customerDetails = DB::table('customers')->where('id', '=', $id)->first();

        $visaSubDocumentListEmailContent = DB::table('visa_emails_document_list')
            ->select(
                "visa_types.name AS vt_name",
                "visa_sub_types.name AS vta_name",
                "visa_emails_document_list.content AS content"
            )

            ->join('visa_files', 'visa_files.visa_sub_type_id', '=', "visa_emails_document_list.visa_sub_type_id")
            ->leftJoin("visa_sub_types", "visa_sub_types.id", "=", "visa_files.visa_sub_type_id")
            ->leftJoin("visa_types", "visa_types.id", "=", "visa_sub_types.visa_type_id")

            ->where(
                [
                    'visa_files.id' => $visa_file_id,
                    "visa_emails_document_list.language_id" => $request->input("dil")
                ]
            )

            ->first();

        if ($visaSubDocumentListEmailContent != null) {

            $data = [
                'title' => "CSS legal PDF Dökümleri",
                'baslik' => "Evrak Listesi",
                'documentList' => $visaSubDocumentListEmailContent,
            ];

            $pdf = PDF::loadView('pdf.document-list', $data);
            $fileName = time() . '.pdf';
            $pdf->save('C:/xampp/htdocs/laravel/cssmtsv4/storage/app/public/pdf/' . $fileName);

            /** Mail::send('email.document-list', [null], function ($m) use ($customerDetails, $fileName) {
             * $m->to($customerDetails->email, $customerDetails->name)
             * ->subject('Evrak Listesi E-maili | ' . date("His"))
             * ->attach('C:/xampp/htdocs/laravel/cssmtsv4/storage/app/public/' . $fileName);
             * //->bcc('mehmetaliturkan@engin.group', $name = null);
             * });
             */

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)
                ->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            DB::table('visa_files')
                ->where("id", "=", $visa_file_id)
                ->update(['visa_file_grades_id' => $nextGrades]);

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Evrak listesi email gönderildi',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('email_logs')->insert(
                [
                    'customer_id' => $id,
                    'access_id' => 1, //vize işlem emaili
                    'content' => $visaSubDocumentListEmailContent->content,
                    'subject' => 'CSSlegal Evrak Listesi ' . date("YmDHis"),
                    'user_id' => $request->session()->get('userId'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]
            );
            $request->session()
                ->flash('mesajSuccess', 'Evrak listesi e-maili gönderildi');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()
                ->flash('mesajInfo', 'Evrak listesi e-maili bulunamadı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
