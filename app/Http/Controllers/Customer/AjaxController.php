<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    public function get_grades(Request $request, $id)
    {
        $visaIDgradesID = DB::table('customers')
            ->select(['customers.id AS id', 'visa_files.id AS visa_file_id', 'visa_files.visa_file_grades_id AS visa_grades_id',])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        // print_r($request->session()->all());

        if ($visaIDgradesID == null) {
            echo 'NOT_FOUND_VISA_FILE';
        } else {

            if (!$request->session()->has(
                $visaIDgradesID->visa_file_id . '_grades_id'
            )) {
                $request->session()->put(
                    $visaIDgradesID->visa_file_id . '_grades_id',
                    $visaIDgradesID->visa_grades_id
                );
                echo 'SET';
            } else {

                if ($request->session()->get(
                    $visaIDgradesID->visa_file_id . '_grades_id'
                ) != $visaIDgradesID->visa_grades_id) {

                    $request->session()->forget(
                        $visaIDgradesID->visa_file_id . '_grades_id'
                    );
                    echo 'REFRESH';
                } else {

                    echo 'WAIT';
                }
            }
        }
    }

    public function post_name_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('name')
            ->where('name', '=', mb_convert_case(
                mb_strtolower($request->get('name')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_telefon_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('telefon')
            ->where('telefon', '=', mb_convert_case(
                mb_strtolower($request->get('telefon')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_email_kontrol(Request $request)
    {
        echo DB::table('customers')
            ->select('email')
            ->where('email', '=', mb_convert_case(
                mb_strtolower($request->get('email')),
                MB_CASE_TITLE,
                "UTF-8"
            ))
            ->count() > 0 ? true : false;
    }

    public function post_not_goster(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('customer_notes')
                ->select('content')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_email_goster(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            return DB::table('email_logs')
                ->select('content')
                ->where('id', '=', $request->input('id'))
                ->first();
        } else {

            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_not_sil(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            if (DB::table('customer_notes')
                ->where('id', '=', $request->input('id'))
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Kayıt başarıyla silindi');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silme işlemi tamamlanamadı');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı istek yapıldı');
        }
    }

    public function post_visa_sub_type(Request $request)
    {
        $getVisaTypes = DB::table('visa_sub_types')
            ->where('visa_type_id', '=', $request->input('id'))
            ->get();

        return ($getVisaTypes);
    }

    public function post_visa_file_log_content(Request $request)
    {
        $getVisaTypes = DB::table('visa_file_logs')
            ->select('content')
            ->where('id', '=', $request->input('id'))
            ->first();

        return ($getVisaTypes);
    }

    public function post_visa_archive_log(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            $visaFileLogs = DB::table('visa_file_logs')
                ->select([
                    'visa_file_logs.id AS id',
                    'visa_file_logs.subject AS subject',
                    'visa_file_logs.created_at AS created_at',
                    'users.name AS user_name',
                ])
                ->join('visa_files', 'visa_files.id', '=', 'visa_file_logs.visa_file_id')
                ->leftJoin('users', 'users.id', '=', 'visa_file_logs.user_id')
                ->where('visa_files.id', '=', $request->input('id'))
                ->orderByDesc('visa_file_logs.id')
                ->get();
            $sonuc = "<div class='card card-primary mb-3'><div class='card-header bg-primary text-white'>Loglar</div><div class='card-body scroll'>
                    <table style='width:100%' class='table table-striped table-bordered table-sm table-light'>
                        <thead>
                        <th>ID</th>
                        <th>İşlem</th>
                        <th>Detay</th>
                        <th>Tarih</th>
                        <th>İşlem Yapan</th>
                        </thead>
                        <tbody>";
            if ($visaFileLogs->count() == 0) {
                $sonuc .= "<tr><td colspan='5'>Kayıt bulunamadı</td></tr>";
            }
            foreach ($visaFileLogs as $visaFileLog) {
                $sonuc .= "<tr>
                                <td>" .  $visaFileLog->id . "</td>
                                <td>" .  $visaFileLog->subject . "</td>
                                <td><button class='btn btn-sm text-dark border' onclick='goster($visaFileLog->id)' title='İçeriği göster' data-bs-toggle='modal' data-bs-target='#exampleModal1'><i class=' bi bi-file-image'></i> Detay</button></td>
                                <td>" .  $visaFileLog->created_at . "</td>
                                <td>" .  $visaFileLog->user_name . "</td>
                            </tr>
                            ";
            }
            $sonuc .= "</tbody></table></div></div>";

            return $sonuc;
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_visa_archive_payment(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            /***** Alınan ödemeler*/
            $receivedPayments = DB::table('visa_received_payments')
                ->select([
                    'visa_received_payments.id AS id',
                    'visa_received_payments.name AS name',
                    'visa_received_payments.received_tl AS received_tl',
                    'visa_received_payments.received_euro AS received_euro',
                    'visa_received_payments.received_dolar AS received_dolar',
                    'visa_received_payments.received_pound AS received_pound',
                    'visa_received_payments.payment_total AS payment_total',
                    'visa_received_payments.payment_method AS payment_method',
                    'visa_received_payments.payment_date AS payment_date',
                    'visa_received_payments.confirm AS confirm',
                    'visa_received_payments.created_at AS created_at',
                    'users.name AS user_name',
                ])
                ->leftJoin('users', 'users.id', '=', 'visa_received_payments.user_id')
                ->where('visa_file_id', '=', $request->input('id'))
                ->get();

            $sonuc = "<div class='card card-primary mb-3'><div class='card-header bg-primary text-white'>Alınan Ödemeler</div><div class='card-body scroll'>
                    <table style='width:100%' class='table table-striped table-bordered table-sm table-light'>
                        <thead>
                            <th>ID</th>
                            <th>Başlıklar</th>
                            <th>Onay</th>
                            <th>İşlem Yapan</th>
                            <th>Toplam(TL)</th>
                            <th>Detaylar</th>
                            <th>Ödeme Şekli</th>
                            <th>Ödeme Tarihi</th>
                            <th>İşlem Tarihi</th>
                        </thead>
                        <tbody>";
            if ($receivedPayments->count() == 0) {
                $sonuc .= "<tr><td colspan='9'>Kayıt bulunamadı</td></tr>";
            }
            foreach ($receivedPayments as $receivedPayment) {
                $sonuc .= "<tr>
                                <td>" .  $receivedPayment->id . "</td>
                                <td>" .  $receivedPayment->name . "</td>
                                <td>";
                $sonuc .=  $receivedPayment->confirm == 1 ? 'Onaylı' : 'Onaysız';
                $sonuc .= "</td>
                                <td>" .  $receivedPayment->user_name . "</td>
                                <td>" .  $receivedPayment->payment_total . "</td><td>";
                $sonuc .=  $receivedPayment->received_tl != '' ? $receivedPayment->received_tl . 'TL ' : '';
                $sonuc .=  $receivedPayment->received_euro != '' ? $receivedPayment->received_euro . '£' : '';
                $sonuc .=  $receivedPayment->received_dolar != '' ? $receivedPayment->received_dolar . '$' : '';
                $sonuc .=  $receivedPayment->received_pound != '' ? $receivedPayment->received_pound . '€' : '';
                $sonuc .=  "</td><td>" .  $receivedPayment->payment_method . "</td>
                                <td>" .  $receivedPayment->payment_date . "</td>
                                <td>" .  $receivedPayment->created_at . "</td>
                            </tr>";
            }
            $sonuc .= "</tbody></table></div></div>";

            /**** Yapılan ödemeler**/
            $madePayments = DB::table('visa_made_payments')
                ->select([
                    'visa_made_payments.id AS id',
                    'visa_made_payments.name AS name',
                    'visa_made_payments.made_tl AS made_tl',
                    'visa_made_payments.made_euro AS made_euro',
                    'visa_made_payments.made_dolar AS made_dolar',
                    'visa_made_payments.made_pound AS made_pound',
                    'visa_made_payments.payment_total AS payment_total',
                    'visa_made_payments.payment_method AS payment_method',
                    'visa_made_payments.payment_date AS payment_date',
                    'visa_made_payments.created_at AS created_at',
                    'users.name AS user_name',
                ])
                ->leftJoin('users', 'users.id', '=', 'visa_made_payments.user_id')
                ->where('visa_file_id', '=', $request->input('id'))->get();

            $sonuc .= "<div class='card card-primary mb-3'><div class='card-header bg-primary text-white'>Yapılan Ödemeler</div><div class='card-body scroll'>
                    <table style='width:100%' class='table table-striped table-bordered table-sm table-light'>
                        <thead>
                            <th>ID</th>
                            <th>Başlıklar</th>
                            <th>İşlem Yapan</th>
                            <th>Toplam(TL)</th>
                            <th>Detaylar</th>
                            <th>Ödeme Şekli</th>
                            <th>Ödeme Tarihi</th>
                            <th>İşlem Tarihi</th>
                        </thead>
                        <tbody>";
            if ($madePayments->count() == 0) {
                $sonuc .= "<tr><td colspan='8'>Kayıt bulunamadı</td></tr>";
            }
            foreach ($madePayments as $madePayment) {
                $sonuc .= "
                            <tr>
                                <td>" .  $madePayment->id . "</td>
                                <td>" .  $madePayment->name . "</td>
                                <td>" .  $madePayment->user_name . "</td>
                                <td>" .  $madePayment->payment_total . "</td><td>";
                $sonuc .=  $madePayment->made_tl != '' ? $madePayment->made_tl . 'TL ' : '';
                $sonuc .=  $madePayment->made_euro != '' ? $madePayment->made_euro . '£' : '';
                $sonuc .=  $madePayment->made_dolar != '' ? $madePayment->made_dolar . '$' : '';
                $sonuc .=  $madePayment->made_pound != '' ? $madePayment->made_pound . '€' : '';
                $sonuc .=  "</td><td>" .  $madePayment->payment_method . "</td>
                                <td>" .  $madePayment->payment_date . "</td>
                                <td>" .  $madePayment->created_at . "</td>
                            </tr>";
            }
            $sonuc .= "</tbody></table></div></div>";

            $refundPayments = DB::table('visa_refund_payments')
                ->select([
                    'visa_refund_payments.id AS id',
                    'visa_refund_payments.name AS name',
                    'visa_refund_payments.refund_tl AS refund_tl',
                    'visa_refund_payments.refund_euro AS refund_euro',
                    'visa_refund_payments.refund_dolar AS refund_dolar',
                    'visa_refund_payments.refund_pound AS refund_pound',
                    'visa_refund_payments.payment_total AS payment_total',
                    'visa_refund_payments.payment_method AS payment_method',
                    'visa_refund_payments.payment_date AS payment_date',
                    'visa_refund_payments.confirm AS confirm',
                    'visa_refund_payments.created_at AS created_at',
                    'users.name AS user_name',
                ])
                ->leftJoin('users', 'users.id', '=', 'visa_refund_payments.user_id')
                ->where('visa_file_id', '=', $request->input('id'))->get();

            $sonuc .= "<div class='card card-primary mb-3'><div class='card-header bg-primary text-white'>İade Ödemeler</div><div class='card-body scroll'>
                    <table style='width:100%' class='table table-striped table-bordered table-sm table-light'>
                        <thead>
                            <th>ID</th>
                            <th>Başlıklar</th>
                            <th>Onay</th>
                            <th>İşlem Yapan</th>
                            <th>Toplam (TL)</th>
                            <th>Detaylar</th>
                            <th>Ödeme Şekli</th>
                            <th>Ödeme Tarihi</th>
                            <th>İşlem Tarihi</th>
                        </thead>
                        <tbody>";
            if ($refundPayments->count() == 0) {
                $sonuc .= "<tr><td colspan='9'>Kayıt bulunamadı</td></tr>";
            }
            foreach ($refundPayments as $refundPayment) {
                $sonuc .= "
                            <tr>
                                <td>" .  $refundPayment->id . "</td>
                                <td>" .  $refundPayment->name . "</td>
                                <td>";
                $sonuc .=  $refundPayment->confirm == 1 ? 'Onaylı' : 'Onaysız';
                $sonuc .= "     </td>
                                <td>" .  $refundPayment->user_name . "</td>
                                <td>" .  $refundPayment->payment_total . "</td><td>";
                $sonuc .=  $refundPayment->refund_tl != '' ? $refundPayment->refund_tl . 'TL ' : '';
                $sonuc .=  $refundPayment->refund_euro != '' ? $refundPayment->refund_euro . '£' : '';
                $sonuc .=  $refundPayment->refund_dolar != '' ? $refundPayment->refund_dolar . '$' : '';
                $sonuc .=  $refundPayment->refund_pound != '' ? $refundPayment->refund_pound . '€' : '';
                $sonuc .=  "</td><td>" .  $refundPayment->payment_method . "</td>
                                <td>" .  $refundPayment->payment_date . "</td>
                                <td>" .  $refundPayment->created_at . "</td>
                            </tr>";
            }
            $sonuc .= "</tbody></table></div></div>";

            return $sonuc;
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_visa_archive_invoice(Request $request)
    {
        if (is_numeric($request->input('id'))) {

            $invoices = DB::table('visa_invoices')->select([
                "visa_invoices.id AS id",
                "visa_invoices.payment AS payment",
                "visa_invoices.matrah AS matrah",
                "visa_invoices.date AS date",
                "visa_invoices.number AS number",
                "visa_invoices.created_at AS created_at",
                "users.name"
            ])
                ->Join("visa_files", "visa_files.id", "=", "visa_invoices.visa_file_id")
                ->leftJoin("users", "users.id", "=", "visa_invoices.user_id")
                ->where("visa_invoices.visa_file_id", "=", $request->input('id'))
                ->distinct()
                ->get();;

            $sonuc = "<div class='card card-primary mb-3'><div class='card-header bg-primary text-white'>Faturalar</div><div class='card-body scroll'>
                    <table style='width:100%' class='table table-striped table-bordered table-sm table-light'>
                        <thead>
                            <th>ID</th>
                            <th>Toplam Ödeme</th>
                            <th>İşlem Yapan</th>
                            <th>Toplam Matrah</th>
                            <th>Fatura Numarası</th>
                            <th>Fatura Tarihi</th>
                            <th>İşlem Tarihi</th>
                        </thead>
                        <tbody>";
            if ($invoices->count() == 0) {
                $sonuc .= "<tr><td colspan='7'>Kayıt bulunamadı</td></tr>";
            }
            foreach ($invoices as $invoice) {
                $sonuc .= "<tr>
                                <td>" .  $invoice->id . "</td>
                                <td>" .  $invoice->payment . "</td>
                                <td>" .  $invoice->name . "</td>
                                <td>" .  $invoice->matrah . "</td>
                                <td>" .  $invoice->number . "</td>
                                <td>" .  $invoice->date . "</td>
                                <td>" .  $invoice->created_at . "</td>
                            </tr>";
            }
            $sonuc .= "</tbody></table></div></div>";

            return $sonuc;
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }

    public function post_visa_archive_receipt(Request $request)
    {
        if (is_numeric($request->input('id'))) {
            echo 'Sistemde kaydı bulunamadı';
        } else {
            echo 'Hatalı istek yapıldı';
        }
    }
}
