<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\General\LoginController as GeneralLoginController;
use App\Http\Controllers\Management\IndexController as ManagementIndexController;
use App\Http\Controllers\Management\ProfilController as ManagementProfilController;
use App\Http\Controllers\Management\LoggingController as ManagementLoggingController;
use App\Http\Controllers\Management\CustomersController as ManagementCustomersController;
use App\Http\Controllers\Management\CustomerNotesController as ManagementCustomerNotesController;
use App\Http\Controllers\Management\AjaxController as ManagementAjaxController;
use App\Http\Controllers\Management\ApplicationOfficeController as ManagementApplicationOfficeController;
use App\Http\Controllers\Management\AppointmentOfficeController as ManagementAppointmentOfficeController;
use App\Http\Controllers\Management\UsersAccessController as ManagementUsersAccessController;
use App\Http\Controllers\Management\UsersController as ManagementUsersController;
use App\Http\Controllers\Management\UsersTypeController as ManagementUsersTypeController;

use App\Http\Controllers\Management\WebController as ManagementWebController;
use App\Http\Controllers\Management\WebGroupsController as ManagementWebGroupsController;
use App\Http\Controllers\Management\WebPanelsController as ManagementWebPanelsController;
use App\Http\Controllers\Management\WebPanelAuthController as ManagementWebPanelAuthController;

use App\Http\Controllers\Management\VisaController as ManagementVisaController;
use App\Http\Controllers\Management\VisaTypesController as ManagementVisaTypesController;
use App\Http\Controllers\Management\VisaFileGradesController as ManagementVisaFileGradesController;
use App\Http\Controllers\Management\VisaFileGradesUsersTypeController as ManagementVisaFileGradesUsersTypeController;
use App\Http\Controllers\Management\VisaValidityController as ManagementVisaValidityController;
use App\Http\Controllers\Management\UrlController;

use App\Http\Controllers\Web\IndexController as WebIndexController;

use App\Http\Controllers\User\UserCalendarController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\AjaxController as UserAjaxController;

use App\Http\Controllers\Customer\IndexController as CustomerIndexController;
use App\Http\Controllers\Customer\SearchController as CustomerSearchController;
use App\Http\Controllers\Customer\NoteController as CustomerNoteController;
use App\Http\Controllers\Customer\LogsController as CustomerLogsController;
use App\Http\Controllers\Customer\AjaxController as CustomerAjaxController;
use App\Http\Controllers\Customer\Visa\IndexController as VisaIndexController;

use App\Http\Controllers\Customer\Visa\GradesUpdateController as VisaGradesUpdateController;
use App\Http\Controllers\Customer\Visa\StatusUpdateController as VisaStatusUpdateController;

use App\Http\Controllers\Customer\Visa\Grades\FileOpenController as VisaFileOpenController;
use App\Http\Controllers\Customer\Visa\Grades\FileOpenConfirmController as VisaFileOpenConfirmController;
use App\Http\Controllers\Customer\Visa\Grades\DocumentWaitController as VisaDocumentWaitController;
use App\Http\Controllers\Customer\Visa\Grades\ControlWaitController as VisaControlWaitController;
use App\Http\Controllers\Customer\Visa\Grades\TranslationsWaitController as VisaTranslationsWaitController;
use App\Http\Controllers\Customer\Visa\Grades\ApplicationWaitController as VisaApplicationWaitController;
use App\Http\Controllers\Customer\Visa\Grades\AppointmentController as VisaAppointmentController;

use App\Http\Controllers\Customer\Visa\Grades\AppointmentPutOffController as VisaAppointmentPutOffController;
use App\Http\Controllers\Customer\Visa\Grades\ApplicationResultController as VisaApplicationResultController;
use App\Http\Controllers\Customer\Visa\Grades\FileDeliveryController as VisaFileDeliveryController;
use App\Http\Controllers\Customer\Visa\Grades\FinishArchiveController as VisaFinishArchiveController;

use App\Http\Controllers\Customer\Visa\ArchivesController as VisaArchivesController;
use App\Http\Controllers\Customer\Visa\ArchiveTransportController as VisaArchiveTransportController;
use App\Http\Controllers\Customer\Visa\Grades\ApplicationPaidWaitController;
use App\Http\Controllers\Management\AjaxVisaGraphicController;

/**Genel yönlendirmeler*/
Route::get('/', [GeneralLoginController::class, "get_index"]);

Route::redirect('yonlendirme', '/');
Route::resource('giris', GeneralLoginController::class);

/**Oturum yönlendirmeler*/
Route::middleware(['sessionCheck'])->group(function () {

    Route::get('/index', [GeneralLoginController::class, "get_index"]);
    Route::get('/cikis', [GeneralLoginController::class, "get_cikis"]);
    Route::post('/theme', [GeneralLoginController::class, "post_theme"]);

    /**Musteri yönlendirmeler*/
    //Route::resource('musteri', CustomerIndexController::class);

    Route::group(['prefix' => 'musteri'], function () {

        Route::get('/', [CustomerIndexController::class, 'index']);
        Route::post('/', [CustomerIndexController::class, 'store']);
        Route::get('create', [CustomerIndexController::class, 'create']);

        Route::get('sorgula', [CustomerSearchController::class, 'index']);
        Route::post('sorgula', [CustomerSearchController::class, 'store']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/', [CustomerIndexController::class, 'show']);
            Route::put('/', [CustomerIndexController::class, 'update']);
            Route::get('edit', [CustomerIndexController::class, 'edit']);
            Route::delete('/', [CustomerIndexController::class, 'destroy']);

            Route::resource('notes', CustomerNoteController::class);
            Route::resource('logs', CustomerLogsController::class);

            /**Vize işlemleri*/
            Route::group(['prefix' => 'vize'], function () {

                Route::get('/', [VisaIndexController::class, 'index']);
                Route::get('asama', [CustomerAjaxController::class, 'get_grades']);
                Route::resource('arsiv', VisaArchivesController::class);

                /**Dosya aşama işlemleri */
                Route::resource('dosya-acma', VisaFileOpenController::class);

                Route::group(['prefix' => '{visa_file_id}', 'middleware' => 'gradesCheck'], function () {

                    /***Dosya aşamalarından bağımsız bölümler */
                    Route::resource('asama-guncelle', VisaGradesUpdateController::class);
                    Route::resource('durum-guncelle', VisaStatusUpdateController::class);
                    Route::resource('arsive-tasima', VisaArchiveTransportController::class);

                    /***Dosya aşamaları başlangıç */
                    Route::resource('dosya-acma-onayi', VisaFileOpenConfirmController::class); //
                    Route::resource('evrak-bekleyen', VisaDocumentWaitController::class); //
                    Route::resource('kontrol-bekleyen', VisaControlWaitController::class); //
                    Route::resource('tercume-bekleyen', VisaTranslationsWaitController::class);
                    Route::resource('basvuru-bekleyen', VisaApplicationWaitController::class);
                    Route::resource('basvuru-odemesi', ApplicationPaidWaitController::class);
                    Route::resource('randevu', VisaAppointmentController::class);
                    Route::resource('sonuc-bekleyen', VisaApplicationResultController::class);
                    Route::resource('teslimat', VisaFileDeliveryController::class);
                    Route::resource('sonuclanmis-arsiv', VisaFinishArchiveController::class);
                    /***Dosya aşamaları son */
                });
            });
        });

        /**Musteri ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('name-kontrol', [CustomerAjaxController::class, 'post_name_kontrol']);
            Route::post('phone-kontrol', [CustomerAjaxController::class, 'post_telefon_kontrol']);
            Route::post('email-kontrol', [CustomerAjaxController::class, 'post_email_kontrol']);
            Route::post('not-goster', [CustomerAjaxController::class, 'post_not_goster']);
            Route::post('visa-log-goster', [CustomerAjaxController::class, 'post_visa_log_goster']);
            Route::post('not-sil', [CustomerAjaxController::class, 'post_not_sil']);
            Route::post('vize-dosya-log', [CustomerAjaxController::class, 'post_visa_file_log_content']);

            Route::group(['prefix' => 'vize'], function () {
                Route::post('arsiv-log', [CustomerAjaxController::class, 'post_visa_archive_log']);
            });
        });
    });

    /**Kullanıcılar yönlendirmeler*/
    Route::group(['prefix' => 'kullanici'], function () {
        Route::get('/', [UserIndexController::class, 'get_index']);
        Route::get('profil', [UserIndexController::class, 'get_profil']);
        Route::post('profil', [UserIndexController::class, 'post_profil']);

        /**web yönlendirmeleri */
        Route::prefix('web')->group(function () {
            Route::resource('/', WebIndexController::class);
        });

        /*** Kullanıcılar ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('calendar-event', [UserCalendarController::class, 'index']);
        });
    });

    /**Yonetim yönlendirmeler*/
    Route::group(['prefix' => 'yonetim', 'middleware' => 'managementCheck'], function () {

        Route::get('/', [ManagementIndexController::class, 'get_index']);

        Route::resource('profil', ManagementProfilController::class);
        Route::resource('users', ManagementUsersController::class);
        Route::resource('users-type', ManagementUsersTypeController::class);
        Route::resource('users-access', ManagementUsersAccessController::class);
        Route::resource('application-office', ManagementApplicationOfficeController::class);
        Route::resource('appointment-office', ManagementAppointmentOfficeController::class);
        Route::resource('customers', ManagementCustomersController::class);
        Route::resource('customer-notes', ManagementCustomerNotesController::class);
        Route::resource('logging', ManagementLoggingController::class);

        /**Yonetim ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('sirala', [ManagementAjaxController::class, 'post_sorting']);
            Route::post('dosya-asama-erisim', [ManagementAjaxController::class, 'post_visa_file_grades_users_type']);
            Route::post('panel-list', [ManagementAjaxController::class, 'post_panel_list']);

            Route::get('customers', [ManagementAjaxController::class, 'get_customers_list']);
            Route::get('visa-logs', [ManagementAjaxController::class, 'get_visa_logs_list']);
            Route::get('visa-grades-count', [ManagementAjaxController::class, 'get_visa_grades_count']);


            Route::get('quota-day', [AjaxVisaGraphicController::class, 'quota_day']);
            Route::get('quota-week', [AjaxVisaGraphicController::class, 'quota_week']);
            Route::get('quota-mount', [AjaxVisaGraphicController::class, 'quota_mount']);
            Route::get('quota-year', [AjaxVisaGraphicController::class, 'quota_year']);

            Route::get('grades-count', [AjaxVisaGraphicController::class, 'grades_count']);
            Route::get('application-office-count', [AjaxVisaGraphicController::class, 'application_office_count']);
            Route::get('visa-types-analist', [AjaxVisaGraphicController::class, 'visa_types_analist']);
            Route::get('advisor-analist', [AjaxVisaGraphicController::class, 'advisor_analist']);
            Route::get('expert-analist', [AjaxVisaGraphicController::class, 'expert_analist']);
            Route::get('translator-analist', [AjaxVisaGraphicController::class, 'translator_analist']);
            Route::get('open-made-analist', [AjaxVisaGraphicController::class, 'open_made_analist']);
        });

        /**Yonetim vize işlemleri*/
        Route::group(['prefix' => 'vize'], function () {

            Route::get('/', [ManagementVisaController::class, 'get_index']);
            Route::get('danisman', [ManagementVisaController::class, 'get_danisman']);
            Route::get('uzman', [ManagementVisaController::class, 'get_uzman']);
            Route::get('muhasebe', [ManagementVisaController::class, 'get_muhasebe']);
            Route::get('tercuman', [ManagementVisaController::class, 'get_tercuman']);

            Route::resource('vize-tipi', ManagementVisaTypesController::class);
            Route::resource('vize-suresi', ManagementVisaValidityController::class);
            Route::resource('dosya-asama', ManagementVisaFileGradesController::class);
            Route::resource('dosya-asama-erisim', ManagementVisaFileGradesUsersTypeController::class);
        });

        /**Yonetim web işlemleri*/
        Route::group(['prefix' => 'web'], function () {
            Route::get('/', [ManagementWebController::class, 'get_index']);
            Route::get('engineer', [ManagementWebController::class, 'get_engineer']);
            Route::get('editor', [ManagementWebController::class, 'get_editor']);
            Route::get('writer', [ManagementWebController::class, 'get_writer']);
            Route::get('graphic', [ManagementWebController::class, 'get_graphic']);
            Route::get('paneller', [ManagementWebController::class, 'get_paneller']);

            /**Url tespit İşlemleri */
            Route::post('/url/ajax-ozet', [UrlController::class, 'get_ajax_ozet']);
            Route::post('/url/ajax-detay', [UrlController::class, 'get_ajax_detay']);
            Route::get('/url/detay', [UrlController::class, 'get_detay']);
            Route::get('/url/{id}/home', [UrlController::class, 'get_home_links']);
            Route::get('/url/{id}/subpage/{subId}', [UrlController::class, 'get_subpage']);
            Route::get('/url/{id}/subpage/{subId}/home', [UrlController::class, 'get_subpage_links']);

            Route::resource('groups', ManagementWebGroupsController::class);
            Route::resource('panels', ManagementWebPanelsController::class);
            Route::resource('panel-auth', ManagementWebPanelAuthController::class);
            Route::resource('url', UrlController::class);
        });
    });
});
