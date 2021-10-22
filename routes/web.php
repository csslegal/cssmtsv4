<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\LoginController as GeneralLoginController;
use App\Http\Controllers\Management\IndexController as ManagementIndexController;
use App\Http\Controllers\Management\NoticeController as ManagementNoticeController;
use App\Http\Controllers\Management\ProfilController as ManagementProfilController;
use App\Http\Controllers\Management\LanguageController as ManagementLanguageController;
use App\Http\Controllers\Management\AjaxController as ManagementAjaxController;
use App\Http\Controllers\Management\ApplicationOfficeController as ManagementApplicationOfficeController;
use App\Http\Controllers\Management\AppointmentOfficeController as ManagementAppointmentOfficeController;
use App\Http\Controllers\Management\UsersAccessController as ManagementUsersAccessController;
use App\Http\Controllers\Management\UsersController as ManagementUsersController;
use App\Http\Controllers\Management\UsersTypeController as ManagementUsersTypeController;
use App\Http\Controllers\Management\VisaController as ManagementVisaController;
use App\Http\Controllers\Management\VisaEmailsDocumentListController as ManagementVisaEmailsDocumentListController;
use App\Http\Controllers\Management\VisaSubTypesController as ManagementVisaSubTypesController;
use App\Http\Controllers\Management\VisaTypesController as ManagementVisaTypesController;
use App\Http\Controllers\Management\VisaEmailsInformationController as ManagementVisaEmailsInformationController;
use App\Http\Controllers\Management\VisaFileGradesController as ManagementVisaFileGradesController;
use App\Http\Controllers\Management\VisaFileGradesUsersTypeController as ManagementVisaFileGradesUsersTypeController;
use App\Http\Controllers\Management\VisaValidityController as ManagementVisaValidityController;
use App\Http\Controllers\Management\UrlController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\AjaxController as UserAjaxController;
use App\Http\Controllers\Customer\AjaxController as CustomerAjaxController;
use App\Http\Controllers\Customer\IndexController as CustomerIndexController;
use App\Http\Controllers\Customer\Visa\IndexController as VisaIndexController;
use App\Http\Controllers\Customer\Visa\InformationEmailController as VisaInformationEmailController;
use App\Http\Controllers\Customer\Visa\Grades\FileOpenController as VisaFileOpenController;
use App\Http\Controllers\Customer\Visa\Grades\ReceivedPaymentsController as VisaReceivedPaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\ReceivedPaymentsConfirmController as VisaReceivedPaymentsConfirmController;
use App\Http\Controllers\Customer\Visa\Grades\DocumentListEmailSendController as VisaDocumentListEmailSendController;
use App\Http\Controllers\Customer\Visa\Grades\DocumentListCompletedController as VisaDocumentListCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\TranslatorAuthController as VisaTranslatorAuthController;
use App\Http\Controllers\Customer\Visa\Grades\TranslationsCompletedController as VisaTranslationsCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\ExpertAuthController as VisaExpertAuthController;
use App\Http\Controllers\Customer\Visa\Grades\AppointmentCompletedController as VisaAppointmentCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\MadePaymentsController as VisaMadePaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\DactylogramController as VisaDactylogramController;

use App\Http\Controllers\Customer\Visa\Grades\AppointmentPutOffController as VisaAppointmentPutOffController;
use App\Http\Controllers\Customer\Visa\Grades\ReReceivedPaymentsController as VisaReReceivedPaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\ReReceivedPaymentsConfirmController as VisaReReceivedPaymentsConfirmController;

use App\Http\Controllers\Customer\Visa\Grades\InvoicesSaveController as VisaInvoicesSaveController;
use App\Http\Controllers\Customer\Visa\Grades\ApplicationResultController as VisaApplicationResultController;
use App\Http\Controllers\Customer\Visa\Grades\FileDeliveryController as VisaFileDeliveryController;
use App\Http\Controllers\Customer\Visa\Grades\RefusalTranslationController as VisaRefusalTranslationController;

/**Genel yönlendirmeler*/
Route::get('/', [GeneralLoginController::class, "get_index"]);

Route::redirect('yonlendirme', '/');
Route::resource('giris', GeneralLoginController::class);

/**Oturum yönlendirmeler*/
Route::middleware(['sessionCheck'])->group(function () {

    Route::get('/index', [GeneralLoginController::class, "get_index"]);
    Route::get('/cikis', [GeneralLoginController::class, "get_cikis"]);

    /**Musteri yönlendirmeler*/
    Route::group(['prefix' => 'musteri'], function () {

        /**Vize işlemleri*/
        Route::group(['prefix' => '{id}/vize'], function () {
            Route::get('/', [VisaIndexController::class, 'index']);
            Route::get('asama', [CustomerAjaxController::class, 'get_grades']);
            Route::resource('bilgi-emaili', VisaInformationEmailController::class);

            /**Dosya aşama işlemleri */
            Route::resource('dosya-ac', VisaFileOpenController::class);

            Route::group(['prefix' => '{visa_file_id}', 'middleware' => 'gradesCheck'], function () {

                Route::get('alinan-odeme-tamamla', [VisaReceivedPaymentsController::class, 'tamamla']);
                Route::get('yapilan-odeme-tamamla', [VisaMadePaymentsController::class, 'tamamla']);
                Route::get('fatura-kayit-tamamla', [VisaInvoicesSaveController::class, 'tamamla']);
                Route::get('yeniden-alinan-odeme-tamamla', [VisaReReceivedPaymentsController::class, 'tamamla']);

                Route::resource('alinan-odeme', VisaReceivedPaymentsController::class);
                Route::resource('alinan-odeme-onay', VisaReceivedPaymentsConfirmController::class);
                Route::resource('evrak-listesi', VisaDocumentListEmailSendController::class);
                Route::resource('evrak-hazirlama', VisaDocumentListCompletedController::class);
                Route::resource('tercuman-yetkilendir', VisaTranslatorAuthController::class);
                Route::resource('tercume-tamamlama', VisaTranslationsCompletedController::class);
                Route::resource('uzman-yetkilendir', VisaExpertAuthController::class);
                Route::resource('form-bilgileri', VisaAppointmentCompletedController::class);
                Route::resource('yapilan-odeme', VisaMadePaymentsController::class);
                Route::resource('parmak-izi', VisaDactylogramController::class);

                Route::resource('randevu-erteleme', VisaAppointmentPutoffController::class);
                Route::resource('yeniden-alinan-odeme', VisaReReceivedPaymentsController::class);
                Route::resource('yeniden-alinan-odeme-onay', VisaReReceivedPaymentsConfirmController::class);

                Route::resource('fatura-kayit', VisaInvoicesSaveController::class);
                Route::resource('basvuru-sonuc', VisaApplicationResultController::class);
                Route::resource('red-tercume', VisaRefusalTranslationController::class);
                Route::resource('teslimat-bilgisi', VisaFileDeliveryController::class);
            });
        });

        /**Musteri ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('name-kontrol', [CustomerAjaxController::class, 'post_name_kontrol']);
            Route::post('telefon-kontrol', [CustomerAjaxController::class, 'post_telefon_kontrol']);
            Route::post('email-kontrol', [CustomerAjaxController::class, 'post_email_kontrol']);
            Route::post('not-goster', [CustomerAjaxController::class, 'post_not_goster']);
            Route::post('email-goster', [CustomerAjaxController::class, 'post_email_goster']);
            Route::post('not-sil', [CustomerAjaxController::class, 'post_not_sil']);
            Route::post('alt-vize-tipi', [CustomerAjaxController::class, 'post_visa_sub_type']);
            Route::post('vize-dosya-log', [CustomerAjaxController::class, 'post_visa_file_log_content']);
        });

        Route::get('sorgula', [CustomerIndexController::class, 'get_sorgula']);
        Route::post('sorgula', [CustomerIndexController::class, 'post_sorgula']);
        Route::get('ekle', [CustomerIndexController::class, 'get_ekle']);
        Route::post('ekle', [CustomerIndexController::class, 'post_ekle']);
        Route::post('destroy', [CustomerIndexController::class, 'destroy']);
        Route::get('{id}', [CustomerIndexController::class, 'get_index']);
        Route::post('{id}/not-ekle', [CustomerIndexController::class, 'post_not_ekle']);
        Route::get('{id}/duzenle', [CustomerIndexController::class, 'get_kayit_duzenle']);
        Route::post('{id}/duzenle', [CustomerIndexController::class, 'post_kayit_duzenle']);
        Route::get('{id}/duzenle-istek', [CustomerIndexController::class, 'get_kayit_duzenle_istek']);
    });

    /**Kullanıcılar yönlendirmeler*/
    Route::group(['prefix' => 'kullanici'], function () {
        Route::get('/', [UserIndexController::class, 'get_index']);
        Route::get('profil', [UserIndexController::class, 'get_profil']);
        Route::post('profil', [UserIndexController::class, 'post_profil']);
        Route::get('duyuru', [UserIndexController::class, 'get_duyuru']);
        Route::get('mTBGI/{id}/onay', [UserIndexController::class, 'get_TBGI_onay']);
        Route::get('mTBGI/{id}/geri-al', [UserIndexController::class, 'get_TBGI_gerial']);

        /*** Kullanıcılar ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('duyuru', [UserAjaxController::class, 'post_duyuru_icerik_cek']);
            Route::get('duyuru-sayisi', [UserAjaxController::class, 'get_active_notice_count']);
        });
    });

    /**Yonetim yönlendirmeler*/
    Route::group(
        ['prefix' => 'yonetim', 'middleware' => 'managementCheck'],
        function () {

            Route::get('/', [ManagementIndexController::class, 'get_index']);
            Route::get('mTBGI/{id}/onay', [ManagementIndexController::class, 'get_TBGI_onay']);
            Route::get('mTBGI/{id}/geri-al', [ManagementIndexController::class, 'get_TBGI_gerial']);

            Route::resource('duyuru', ManagementNoticeController::class);
            Route::resource('profil', ManagementProfilController::class);
            Route::resource('users', ManagementUsersController::class);
            Route::resource('users-type', ManagementUsersTypeController::class);
            Route::resource('users-access', ManagementUsersAccessController::class);
            Route::resource('application-office', ManagementApplicationOfficeController::class);
            Route::resource('appointment-office', ManagementAppointmentOfficeController::class);
            Route::resource('language', ManagementLanguageController::class);

            /*** Yonetim ajax işlemleri*/
            Route::group(['prefix' => 'ajax'], function () {
                Route::post('duyuru', [ManagementAjaxController::class, 'post_duyuru_cek']);
                Route::post('bilgi-emaili', [ManagementAjaxController::class, 'post_bilgi_emaili_cek']);
                Route::post('evrak-emaili', [ManagementAjaxController::class, 'post_evrak_emaili_cek']);
                Route::post('sirala', [ManagementAjaxController::class, 'post_sorting']);
                Route::post('dosya-asama-erisim', [ManagementAjaxController::class, 'post_visa_file_grades_users_type']);
            });

            /**Yonetim vize işlemleri*/
            Route::group(['prefix' => 'vize'], function () {

                Route::get('/', [ManagementVisaController::class, 'get_index']);
                Route::get('danisman', [ManagementVisaController::class, 'get_danisman']);
                Route::get('uzman', [ManagementVisaController::class, 'get_uzman']);
                Route::get('muhasebe', [ManagementVisaController::class, 'get_muhasebe']);
                Route::get('tercuman', [ManagementVisaController::class, 'get_tercuman']);
                Route::get('koordinator', [ManagementVisaController::class, 'get_koordinator']);
                Route::get('ofis-sorumlusu', [ManagementVisaController::class, 'get_ofis_sorumlusu']);

                Route::resource('vize-tipi', ManagementVisaTypesController::class);
                Route::resource('vize-suresi', ManagementVisaValidityController::class);
                Route::resource('alt-vize-tipi', ManagementVisaSubTypesController::class);
                Route::resource('bilgi-emaili', ManagementVisaEmailsInformationController::class);
                Route::resource('evrak-emaili', ManagementVisaEmailsDocumentListController::class);
                Route::resource('dosya-asama', ManagementVisaFileGradesController::class);
                Route::resource('dosya-asama-erisim', ManagementVisaFileGradesUsersTypeController::class);
            });

            /*****Url tespit İşlemleri */
            Route::resource('url', UrlController::class);
            Route::post('/url/ajax', [UrlController::class, 'get_ajax']);
            Route::get('/url/{id}/home', [UrlController::class, 'get_home_links']);
            Route::get('/url/{id}/subpage/{subId}', [UrlController::class, 'get_subpage']);
            Route::get('/url/{id}/subpage/{subId}/home', [UrlController::class, 'get_subpage_links']);
        }
    );
});
