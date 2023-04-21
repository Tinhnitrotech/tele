<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetParamUrlStaff;
use App\Http\Middleware\Language;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('register/ajax_detect_image_demo', 'User\DashBoardController@detectImageDemo')->name('detectImageDemo');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'],function () {

    /**
     * Start
     * Status : No Login
     */
    Route::get('login', 'LoginController@showFormLogin')->name('adminLogin');
    Route::post('login', 'LoginController@postFormLogin')->name('adminPostLogin');
    Route::get('forgot-password', 'ForgotPasswordController@showFormForgotPassword')->name('adminForgotPassword');
    Route::post('forgot-password', 'ForgotPasswordController@postForgotPassword')->name('adminPostForgotPassword');
    Route::get('reset-password', 'ResetPasswordController@showFormResetPassword')->name('adminResetPassword')->middleware('signed');
    Route::post('reset-password', 'ResetPasswordController@postResetPassword')->name('adminPostResetPassword');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('', 'DashBoardController@goToDashboard')->name('adminIndex');
        Route::get('/dashboard', 'DashBoardController@index')->name('adminDashboard');
        Route::get('/logout', 'DashBoardController@logout')->name('logout');
        Route::get('change-password', 'ChangePasswordController@index')->name('adminChangePassword');
        Route::put('change-password', 'ChangePasswordController@update')->name('adminUpdatePassword');
        Route::get('setting', 'DashBoardController@settingSystem')->name('settingSystem');
        Route::post('setting', 'DashBoardController@postSettingSystem')->name('postSettingSystem');

        /**
         * Place
         */
        Route::group(['prefix'=>'place'], function() {
            Route::get('/', 'PlaceController@getRefugeList')->name('adminPlaceList');
            Route::get('create', 'PlaceController@create')->name('adminCreatePlace');
            Route::post('create', 'PlaceController@store')->name('adminCreate');
            Route::get('edit/{id}', 'PlaceController@edit')->name('adminEditPlace');
            Route::put('edit/{id}', 'PlaceController@update')->name('adminEdit');
            Route::get('detail/{id}', 'PlaceController@show')->name('adminDetail');
            Route::delete('delete/{id}', 'PlaceController@destroy')->name('placeDelete');
            Route::post('status_full/{id}', 'PlaceController@changeFullStatus')->name('changeFullStatus');
            Route::post('active_status/{id}', 'PlaceController@changeActiveStatus')->name('changeActiveStatus');
            Route::get('csv/import', 'PlaceController@importCSVView')->name('importCSVViewPlace');
            Route::post('csv/export', 'PlaceController@importCSV')->name('importCSVPlace');
            Route::get('exportCSV', 'PlaceController@exportCSV')->name('exportCSVPlace');
        });

        /**
         * qrcode
         */
        Route::group(['prefix'=>'qrcode'], function() {
            Route::get('csv/import', 'QrCodeController@importCSVView')->name('importCSVView');
            Route::post('csv/import', 'QrCodeController@importCSV')->name('importCSVQrCode');
            Route::get('csv/export-sample', 'QrCodeController@exportCSV')->name('exportCSVSample');
            Route::get('zip/download-zip', 'QrCodeController@downloadZip')->name('downloadZipQrCode');
            Route::get('zip/cancel-zip', 'QrCodeController@cancelZip')->name('cancelZipQrCode');
        });


        /**
         * Material
         */
        Route::get('material', 'MaterialController@index')->name('adminMaterialList');
        Route::get('material/create', 'MaterialController@create')->name('adminCreateMaterial');
        Route::post('material/create', 'MaterialController@store')->name('adminAddMaterial');
        Route::get('material/edit/{id}', 'MaterialController@edit')->name('adminEditMaterial');
        Route::put('material/edit/{id}', 'MaterialController@update')->name('adminUpdateMaterial');
        Route::delete('material/delete/{id}', 'MaterialController@destroy')->name('adminDeleteMaterial');

        Route::get('material/csv/export', 'MaterialController@exportCSVMasterSupply')->name('adminExportCSVMasterSupply');
        Route::get('material/csv/import', 'MaterialController@importCSVView')->name('importCSVViewMaterial');
        Route::post('material/csv/import_csv', 'MaterialController@importCSV')->name('importCSVMasterMaterial');

        Route::group(['prefix'=>'admin-management'], function() {
            Route::get('/', 'AdminManagementController@index')->name('adminManagement');
            Route::get('/create', 'AdminManagementController@create')->name('adminManagementAdd');
            Route::post('/store', 'AdminManagementController@store')->name('adminManagementStore');
            Route::get('/edit/{id}', 'AdminManagementController@edit')->name('adminManagementEdit');
            Route::put('/update/{id}', 'AdminManagementController@update')->name('adminManagementUpdate');
            Route::get('/detail/{id}', 'AdminManagementController@show')->name('adminManagementShow');
            Route::delete('/delete/{id}', 'AdminManagementController@destroy')->name('adminManagementDelete');

            Route::get('/csv/export', 'AdminManagementController@exportCSV')->name('exportCSVAdminManagement');
            Route::get('/csv/import', 'AdminManagementController@importCSVView')->name('importCSVViewAdminManagement');
            Route::post('/csv/import_csv', 'AdminManagementController@importCSV')->name('importCSVAdminManagement');
        });

        Route::group(['prefix'=>'staff-management'], function() {
            Route::get('/', 'StaffManagementController@index')->name('staffManagement'); // 4-5-1
            Route::get('/create', 'StaffManagementController@create')->name('staffManagementAdd'); // 4-5-2
            Route::post('/store', 'StaffManagementController@store')->name('staffManagementStore');
            Route::get('/edit/{id}', 'StaffManagementController@edit')->name('staffManagementEdit'); //4-5-3
            Route::put('/update/{id}', 'StaffManagementController@update')->name('staffManagementUpdate');
            Route::get('/detail/{id}', 'StaffManagementController@show')->name('staffManagementShow'); //4-5-4
            Route::delete('/delete/{id}', 'StaffManagementController@destroy')->name('staffManagementDelete'); // 4-5-5

            Route::get('/csv/export', 'StaffManagementController@exportCSV')->name('exportCSVStaffManagement');
            Route::get('/csv/import', 'StaffManagementController@importCSVView')->name('importCSVViewStaffManagement');
            Route::post('/csv/import_csv', 'StaffManagementController@importCSV')->name('importCSVStaffManagement');

        });

        Route::group(['prefix' => 'evacuation'], function () {
            Route::get('/', 'EvacuationManagementController@index')->name('evacuationManagement');
            Route::get('/family-detail/{id}', 'EvacuationManagementController@detailByHousehold')->name('familyDetail');
            Route::get('csv/export', 'EvacuationManagementController@exportCSV')->name('evacuationExportCSVEvacuation');
        });

        /**
         * shortage-supplies
         */
        Route::get('shortage-supplies', 'MaterialController@getShortageSupplyList')->name('ShortageSupplyList');
        Route::get('shortage-supplies/csv/export', 'MaterialController@exportCSV')->name('ShortageSupplyCsvExport');

        /**
         * statistics
         */
        Route::get('statistics', 'StatisticsController@index')->name('statistics');
        Route::post('statistics-ajax', 'StatisticsController@ajaxStatus')->name('ajaxStatus');
        Route::post('ajax-chart', 'StatisticsController@ajaxGetChart')->name('jaxChart');

    });


});

Route::middleware([SetParamUrlStaff::class])->group(function () {

    Route::group(['prefix' => 'staff', 'as' => 'staff.', 'namespace' => 'Staff'],function () {
        /**
         * Start
         * Status : No Login
         */
        Route::get('login', 'LoginController@showFormLogin')->name('staffLogin');
        Route::post('login', 'LoginController@postFormLogin')->name('postStaffLogin');

        Route::get('forgot-password', 'PasswordController@showFormForgot')->name('staffForgotPassword');
        Route::post('forgot-password', 'PasswordController@postFormForgot')->name('postStaffForgotPassword');

        Route::get('reset-password', 'PasswordController@showFormReset')->name('staffResetPassword')->middleware('signed');
        Route::post('reset-password', 'PasswordController@postshowFormReset')->name('postStaffResetPassword');

        Route::get('register', 'RegisterController@showFormRegister')->name('staffRegister');
        Route::post('register', 'RegisterController@postFormRegister')->name('postStaffRegister');

        Route::post('add-family', 'RefugeController@createAddFamilyAndPerson')->name('postAddFamily'); // 3-3-2
        /**
         * End
         * Status : No Login
         */

        /**
         * Start
         * Status : Login
         */
        Route::middleware(['auth:staff'])->group(function () {
            Route::get('dashboard', 'DashBoardController@index')->name('staffDashboard'); // 3-1
            Route::get('logout', 'DashBoardController@logout')->name('logout');
            Route::get('change-password', 'ChangePasswordController@index')->name('staffChangePassword');
            Route::put('change-password', 'ChangePasswordController@update')->name('staffUpdatePassword');

            Route::get('supplies', 'SuppliesController@index')->name('suppliesIndex'); // 3-2
            Route::post('supplies', 'SuppliesController@storeAndUpdate')->name('postSupplies'); // 3-2

            Route::get('family', 'RefugeController@index')->name('familyIndex'); // 3-3-1
            Route::get('export-family', 'RefugeController@exportCSV')->name('familyExport'); // export csv family
            Route::get('add-family', 'RefugeController@addFamily')->name('addFamily'); // 3-3-2
            Route::any('register-confirm', 'RefugeController@registerConfirm')->name('confirmFamily');
            Route::get('family-detail/{id}', 'RefugeController@detail')->name('familyDetail'); // 3-3-3
            Route::get('edit-family/{id}', 'RefugeController@editFamily')->name('editFamily');
            Route::post('edit-family/{id}', 'RefugeController@editFamilyAndPerson')->name('postEditFamily');
            Route::post('family-checkout/{id}', 'RefugeController@checkout')->name('familyCheckout');
            Route::get('register-checkin', 'NumberPeopleCheckinController@index')->name('peopleCheckin');
            Route::post('post-register-checkin', 'NumberPeopleCheckinController@postPeopleCheckin')->name('postPeopleCheckin');

        });
        /**
         * End
         * Status : Login
         */
    });
    Route::middleware([Language::class])->group(function () {
        Route::namespace('User')->group(function () {
            /**
             * Status : No Login
             */
            Route::get('checkout', 'DashBoardController@checkOut')->name('userCheckout');
            Route::put('/leave/{family_id}','DashBoardController@leave')->name('userLeave');
            Route::post('/checkin','DashBoardController@checkInRemote')->name('userCheckin');
            Route::group(['prefix' => 'register', 'as' => 'user.'], function() {
                Route::get('member', 'DashBoardController@member')->name('member');
                Route::post('jax_search', 'DashBoardController@ajaxSearchFamily')->name('ajaxSearch');
                Route::post('jax_scan', 'DashBoardController@detectQrCode')->name('ajaxScan');
                Route::post('ajax_detect_image', 'DashBoardController@detectImage')->name('ajaxDetectImage');
//                Route::post('ajax_detect_image_demo', 'DashBoardController@detectImageDemo')->name('detectImageDemo');
                Route::get('/', 'DashBoardController@register')->name('register');
                Route::any('confirm', 'DashBoardController@registerConfirm')->name('confirm');
                Route::get('success', 'DashBoardController@registerSuccess')->name('success');
            });

        });

    });

});
Route::middleware([Language::class])->group(function () {
    Route::namespace('User')->group(function () {

        Route::get('detect', 'DashBoardController@annotateImage')->name('annotateImage');

        Route::get('list', 'DashBoardController@getListPlace')->name('getListPlace');
        Route::get('/dashboard', 'DashBoardController@index')->name('userDashboard');
        Route::get('/', 'DashBoardController@map')->name('userMap');
        Route::get('/map', 'DashBoardController@place')->name('userMapList');
        Route::get('/public-evacuees', 'PublicEvacuationManagementController@index')->name('publicEvacuationManagement');
    });
});

Route::get('language/{locate}', 'LanguageController@index')->name('setLanguage');

Route::get('/error', function () {
    return view('error');
})->name('placeIDError');

