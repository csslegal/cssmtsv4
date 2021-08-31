<?php

use App\Http\Controllers\Genel\GirisController;
use App\Http\Controllers\Yonetim\DuyuruController;
use App\Http\Controllers\Yonetim\ProfilController;
use App\Http\Controllers\Yonetim\YonetimController;
use App\Http\Controllers\Yonetim\YonetimApplicationOfficeController;
use App\Http\Controllers\Yonetim\YonetimAppointmentOfficeController;
use App\Http\Controllers\Yonetim\YonetimUsersAccessController;
use App\Http\Controllers\Yonetim\YonetimUsersController;
use App\Http\Controllers\Yonetim\YonetimUsersTypeController;
use App\Http\Controllers\Yonetim\YonetimVizeController;
use App\Http\Controllers\Yonetim\YonetimAjaxController;
use App\Http\Controllers\Kullanici\KullaniciController;
use App\Http\Controllers\Kullanici\KullaniciAjaxController;
use App\Http\Controllers\Musteri\CustomersAjaxController;
use App\Http\Controllers\Musteri\CustomersController;
use App\Http\Controllers\Visa\VizeController;
use App\Http\Controllers\Yonetim\YonetimLanguageController;
use App\Http\Controllers\Yonetim\YonetimVisaEmailsDocumentListController;
use App\Http\Controllers\Yonetim\YonetimVisaSubTypesController;
use App\Http\Controllers\Yonetim\YonetimVisaTypesController;
use App\Http\Controllers\Yonetim\YonetimVisaEmailsInformationController;
use Illuminate\Support\Facades\Route;

/**Genel yönlendirmeler*/
Route::get('/', [GirisController::class, "get_index"]);
Route::redirect('yonlendirme', config('app.url'));
Route::resource('giris', GirisController::class);

/**Oturum yönlendirmeler*/
Route::middleware(['SessionCheck'])->group(function () {

    Route::get('/index', [GirisController::class, "get_index"]);
    Route::get('/cikis', [GirisController::class, "get_cikis"]);

    /**Musteriler yönlendirmeler*/
    Route::group(['prefix' => 'musteri'], function () {

        Route::get('sorgula', [CustomersController::class, 'get_sorgula']);
        Route::post('sorgula', [CustomersController::class, 'post_sorgula']);
        Route::get('ekle', [CustomersController::class, 'get_ekle']);
        Route::post('ekle', [CustomersController::class, 'post_ekle']);
        Route::post('destroy', [CustomersController::class, 'destroy']);
        Route::get('{id}', [CustomersController::class, 'get_index']);
        Route::post('{id}/not-ekle', [CustomersController::class, 'post_not_ekle']);
        Route::get('{id}/duzenle', [CustomersController::class, 'get_kayit_duzenle']);
        Route::post('{id}/duzenle', [CustomersController::class, 'post_kayit_duzenle']);
        Route::get('{id}/duzenle-istek', [CustomersController::class, 'get_kayit_duzenle_istek']);

        /**Vize işlemleri*/
        Route::group(['prefix' => '{id}/vize'], function () {
            Route::get('/', [VizeController::class, 'index']);
            Route::get('/dosya-ac', [VizeController::class, 'get_dosya_ac']);
            Route::post('/bilgi-emaili-gonder', [VizeController::class, 'post_bilgi_emaili_gonder']);
        });

        /**Musteriler ajax işlemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('name-kontrol', [CustomersAjaxController::class, 'post_name_kontrol']);
            Route::post('telefon-kontrol', [CustomersAjaxController::class, 'post_telefon_kontrol']);
            Route::post('email-kontrol', [CustomersAjaxController::class, 'post_email_kontrol']);
            Route::post('not-goster', [CustomersAjaxController::class, 'post_not_goster']);
            Route::post('email-goster', [CustomersAjaxController::class, 'post_email_goster']);
            Route::post('not-sil', [CustomersAjaxController::class, 'post_not_sil']);
            Route::post('alt-vize-tipi', [CustomersAjaxController::class, 'post_visa_sub_type']);
        });
    });

    /**Kullanıcılar yönlendirmeler*/
    Route::group(['prefix' => 'kullanici'], function () {
        Route::get('/', [KullaniciController::class, 'get_index']);
        Route::get('profil', [KullaniciController::class, 'get_profil']);
        Route::post('profil', [KullaniciController::class, 'post_profil']);
        Route::get('duyuru', [KullaniciController::class, 'get_duyuru']);

        /**
         * Kullanıcılar ajax işlemleri
         */
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('duyuru', [KullaniciAjaxController::class, 'post_duyuru_icerik_cek']);
            Route::get('duyuru-sayisi', [KullaniciAjaxController::class, 'get_aktif_duyuru_sayisi']);
        });
    });

    /**Yonetim yönlendirmeler*/
    Route::group(
        [
            'prefix' => 'yonetim',
            'middleware' => 'YonetimCheck'
        ],
        function () {

            Route::get('/', [YonetimController::class, 'get_index']);
            Route::get('mTBGI/{id}/onay', [YonetimController::class, 'get_TBGI_onay']);
            Route::get('mTBGI/{id}/geri-al', [YonetimController::class, 'get_TBGI_gerial']);

            Route::resource('duyuru', DuyuruController::class);
            Route::resource('profil', ProfilController::class);
            Route::resource('users', YonetimUsersController::class);
            Route::resource('users-type', YonetimUsersTypeController::class);
            Route::resource('users-access', YonetimUsersAccessController::class);
            Route::resource('application-office', YonetimApplicationOfficeController::class);
            Route::resource('appointment-office', YonetimAppointmentOfficeController::class);
            Route::resource('language', YonetimLanguageController::class);

            /*** Yonetim ajax işlemleri*/
            Route::group(['prefix' => 'ajax'], function () {
                Route::post('duyuru', [YonetimAjaxController::class, 'post_duyuru_cek']);
                Route::post('bilgi-emaili', [YonetimAjaxController::class, 'post_bilgi_emaili_cek']);
                Route::post('evrak-emaili', [YonetimAjaxController::class, 'post_evrak_emaili_cek']);
            });

            /**Yonetim vize işlemleri*/
            Route::group(['prefix' => 'vize'], function () {

                Route::get('/', [YonetimVizeController::class, 'get_index']);
                Route::get('danisman', [YonetimVizeController::class, 'get_danisman']);
                Route::get('uzman', [YonetimVizeController::class, 'get_uzman']);
                Route::get('muhasebe', [YonetimVizeController::class, 'get_muhasebe']);
                Route::get('tercuman', [YonetimVizeController::class, 'get_tercuman']);
                Route::get('koordinator', [YonetimVizeController::class, 'get_koordinator']);
                Route::get('ofis-sorumlusu', [YonetimVizeController::class, 'get_ofis_sorumlusu']);

                Route::resource('vize-tipi', YonetimVisaTypesController::class);
                Route::resource('alt-vize-tipi', YonetimVisaSubTypesController::class);
                Route::resource('bilgi-emaili', YonetimVisaEmailsInformationController::class);
                Route::resource('evrak-emaili', YonetimVisaEmailsDocumentListController::class);
            });
        }
    );
});
