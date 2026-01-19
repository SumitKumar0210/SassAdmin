<?php

use Illuminate\Http\Request;
use App\Http\Controllers\backend\admin\PermissionController;
use App\Http\Controllers\backend\audit\AuditReportController;
use App\Http\Controllers\backend\audit\FoodBanquetAuditController;
use App\Http\Controllers\backend\audit\GuestFolioAuditController;
use App\Http\Controllers\backend\audit\RevenueAuditController;
use App\Http\Controllers\backend\audit\RoomAuditController;
use App\Http\Controllers\backend\auth\HomeController;
use App\Http\Controllers\backend\invoice\InvoiceController;
use App\Http\Controllers\backend\kot\DashboardKotController;
use App\Http\Controllers\backend\kot\KotController;
use App\Http\Controllers\backend\kot\ViewKotController;
use App\Http\Controllers\backend\kot\KotBillController;
use App\Http\Controllers\backend\auth\LoginController;
use App\Http\Controllers\backend\banquet\BanquetDashboardController;
use App\Http\Controllers\backend\banquet\BookingController;
use App\Http\Controllers\backend\banquet\HallController;
use App\Http\Controllers\backend\kitchen\KitchenController;
use App\Http\Controllers\backend\kot\GeneratedBillController;
use App\Http\Controllers\backend\kot\QrMenuController;
use App\Http\Controllers\backend\report\ComprehensiveBookingReportController;
use App\Http\Controllers\backend\report\ComprehensiveCorporateRevenueController;
use App\Http\Controllers\backend\report\EventTypeController;
use App\Http\Controllers\backend\report\GuesthistoryController;
use App\Http\Controllers\backend\report\GuestHistoryReportController;
use App\Http\Controllers\backend\report\HallRevenueComparisonController;
use App\Http\Controllers\backend\report\HallUtilizationReportController;
use App\Http\Controllers\backend\report\KotReportController;
use App\Http\Controllers\backend\report\MergeBillController;
use App\Http\Controllers\backend\report\MonthlyRevenueBreakdownController;
use App\Http\Controllers\backend\report\OutstandingPaymentsReportController;
use App\Http\Controllers\backend\report\ReservationReportController;
use App\Http\Controllers\backend\report\BulkBookingSaleController;
use App\Http\Controllers\backend\report\ItemwiseSalesController;
use App\Http\Controllers\backend\report\KotItemController;
use App\Http\Controllers\backend\report\KotListReportController;
use App\Http\Controllers\backend\report\PaymentSummaryController;
use App\Http\Controllers\backend\report\ReservationCheckoutController;
use App\Http\Controllers\backend\report\ReservationCancelController;
use App\Http\Controllers\backend\report\RestaurantSalesReportController;
use App\Http\Controllers\backend\report\RoomRevenueController;
use App\Http\Controllers\backend\report\RoomStatusController;
use App\Http\Controllers\backend\report\SingleBookingSaleController;
use App\Http\Controllers\backend\report\StayController;
use App\Http\Controllers\backend\reservation\CheckoutController;
use App\Http\Controllers\backend\reservation\RoomController;
use App\Http\Controllers\backend\settings\RoomnumberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\reservation\AvailabilityController;
use App\Http\Controllers\backend\reservation\ReservationController;
use App\Http\Controllers\backend\reservation\ReservationActionController;
use App\Http\Controllers\backend\reservation\ReservationLayoutController;
use App\Http\Controllers\backend\restaurant\RestaurantCategoryController;
use App\Http\Controllers\backend\restaurant\RestaurantItemAttributeController;
use App\Http\Controllers\backend\restaurant\RestaurantItemController;
use App\Http\Controllers\backend\restaurant\RestaurantLabelController;
use App\Http\Controllers\backend\restaurant\RestaurantRawMaterialController;
use App\Http\Controllers\backend\restaurant\RestaurantTableController;
use App\Http\Controllers\backend\settings\AccessoriesController;
use App\Http\Controllers\backend\settings\AuditController;
use App\Http\Controllers\backend\settings\GeneralSettingController;
use App\Http\Controllers\backend\settings\BedtypeController;
use App\Http\Controllers\backend\settings\CloserReasonController;
use App\Http\Controllers\backend\settings\CompanyController;
use App\Http\Controllers\backend\settings\DepartmentController;
use App\Http\Controllers\backend\settings\EventController;
use App\Http\Controllers\backend\settings\FacilitiesController;
use App\Http\Controllers\backend\settings\FeatureController;
use App\Http\Controllers\backend\settings\PaymentController;
use App\Http\Controllers\backend\settings\ProfileController;
use App\Http\Controllers\backend\settings\RoomtypeController;
use App\Http\Controllers\backend\settings\RoomviewController;
use App\Http\Controllers\backend\settings\SettingController;
use App\Http\Controllers\backend\settings\TariffController;
use App\Http\Controllers\backend\settings\TaxCategoryController;
use App\Http\Controllers\frontend\UserMenuController;
use App\Http\Controllers\backend\settings\TaxslabController;
use App\Http\Controllers\backend\settings\UserController;
use App\Http\Controllers\backend\settings\UsertypeController;
use App\Http\Controllers\backend\settings\VendorController;
use App\Http\Controllers\backend\settings\WaiterController;
use App\Http\Controllers\backend\store\PurchaseController;
use App\Http\Controllers\backend\store\ReportController;
use App\Http\Controllers\backend\store\StockController;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/subdomain/404', function (Request $request) {
    return view('errors.subdomain-404', ['host' => $request->route('host')]);
})->name('subDomain404');
Route::group(['middleware' => ['tenant'],], function () {
    Route::get('/clear-all-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear'); // If applicable
    });

    Route::get('/item-menu', [UserMenuController::class, 'getItemMenuList'])->name('menu-item-list.getItemMenuList');
    Route::post('/item-cart', [UserMenuController::class, 'getItemVariation'])->name('menu-item-cart.getItemVariation');
    Route::post('/item-cart-detail', [UserMenuController::class, 'getItemCartDetail'])->name('menu-item-cart-detail.getItemCartDetail');
    Route::post('/item-cart-place-order', [UserMenuController::class, 'placeOrder'])->name('item-cart-place-order.placeOrder');

    // Route::get('/forgot-password', function () { return view('backend/auth/forgot-password'); });
    Route::get('/dashboard', function () {
        return view('backend/pages/dashboard');
    });
    Route::get('/reservation-availability', [AvailabilityController::class, 'index'])->name('index');
    // Route::get('/availability', function () { return view('backend/modules/reservation/availability'); });
    // Route::get('/availability', function () { return view('backend/modules/reservation/availability'); });
    Route::get('/room-view', function () {
        return view('backend/modules/settings/room_view');
    });
    Route::get('/room-facilities', function () {
        return view('backend/modules/settings/room_facilities');
    });
    Route::get('/bedtype', function () {
        return view('backend/modules/settings/bedtype');
    });

    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::get('/forgot-password', [LoginController::class, 'forget'])->name('forget');
    Route::post('logged_in', [LoginController::class, 'authenticate'])->name('backend.login');
    Route::get('/admin-forgetPassword', [LoginController::class, 'forgetpass'])->name('backend.forgetpass');
    Route::get('/invoice', function () {
        return view('backend/modules/invoice/reservation/res_payment_invoice');
    });

    Route::get('/clear-cache', [HomeController::class, 'clearCache'])->name('cacheClr');
    Route::post('send-otp', [LoginController::class, 'sendOtp'])->name('backend.sendOtp');
    Route::post('send-magic-link', [LoginController::class, 'magiclink'])->name('backend.magiclink');
    Route::post('/admin-otpVerify', [LoginController::class, 'verifyotp'])->name('backend.verify_otp');
    Route::post('/admin-passwordChange', [LoginController::class, 'updatepass'])->name('backend.update_pass');
    Route::get('/m-l/{token}', [LoginController::class, 'magicLinkVerify']);
    Route::get('/tokenInvalid', [LoginController::class, 'tokenError'])->name('backend.token_error');

    Route::group(['middleware' => ['auth'],], function () {

        // Route::get('/profile', function () { return view('backend/pages/profile'); });
        // Route::get('/setting', function () { return view('backend/pages/setting'); });
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting.index');
        Route::post('/setting-store', [SettingController::class, 'store'])->name('setting.store');
        Route::post('/setting-add-sound', [SettingController::class, 'addSound'])->name('setting.addSound');
        Route::post('/setting-store-einvoice', [SettingController::class, 'storeEInvoice'])->name('setting.storeEInvoice');
        Route::post('/setting-store-time-configuration', [SettingController::class, 'storeTimeConfiguration'])->name('setting.storeTimeConfiguration');
        Route::post('/setting-sound-reset-mute', [SettingController::class, 'soundUpdateResetMute'])->name('setting.soundUpdateResetMute');
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.index');

        Route::prefix('invoice')->group(function () {
            Route::get('/print-payment-invoice/{id}', [InvoiceController::class, 'paymentInvoice']);
            Route::get('/send-payment-invoice/{id}', [InvoiceController::class, 'send_paymentInvoice']);
            Route::get('/rp-invoice/{id}', [InvoiceController::class, 'paymentInvoice']);
            Route::post('/invoice-status', [InvoiceController::class, 'invoice_status'])->name('invoice.invoice_status');
            Route::get('/invoice-final', [InvoiceController::class, 'final_restr_invoice'])->name('invoice.final_restr_invoice');
            Route::post('/invoice-data', [InvoiceController::class, 'getfinalInvoiceData'])->name('invoice.getfinalInvoiceData');
        });

        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('backend.dashboard');
        Route::get('/dashboard-chart', [HomeController::class, 'dashboardChart'])->name('backend.dashboardChart');
        Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.reservation');
        Route::get('/reservation2', [ReservationController::class, 'index2'])->name('reservation.reservation2');
        Route::post('/reservationAdd', [ReservationController::class, 'reservationdata'])->name('backend.reservationdata');
        Route::post('/reservationCount', [ReservationController::class, 'reservationCountView'])->name('reservation.reservationCountView');
        Route::post('/addreservation', [ReservationController::class, 'add_reservation'])->name('reservation.add_reservation');
        Route::post('/addnewrooms', [ReservationController::class, 'edit_add_reservation'])->name('reservation.edit_add_reservation');
        Route::post('/addclosure', [ReservationController::class, 'add_roomClosure'])->name('backend.add_roomClosure');
        Route::post('/reservationDetail', [ReservationController::class, 'getReservationDetails'])->name('backend.getReservationDetails');
        Route::post('/reservation_Detail', [ReservationController::class, 'getReservation_Details'])->name('backend.getReservation_Details');
        Route::post('/reservationRoomsData', [ReservationController::class, 'getRservationRoomDatas'])->name('reservation.getRservationRoomDatas');
        Route::post('/reservationDatas', [ReservationController::class, 'getRservationData'])->name('reservation.getRservationDatas');
        Route::post('/reservationRoomsDetail', [ReservationController::class, 'getRservationRoomDetails'])->name('backend.getRservationRoomDetails');
        Route::post('/reservationRoomsDetailUpdate', [ReservationController::class, 'reservationRoomNumUpdate'])->name('reservation.reservationRoomNumUpdate');
        Route::get('/RservationandRoomDetails', [ReservationController::class, 'getRservationandRoomDetails'])->name('reservation.getRservationandRoomDetails');
        Route::post('/Rservationpaymentadd', [ReservationController::class, 'reservationPayment'])->name('reservation.reservationPayment');
        Route::post('/roomguestData', [ReservationController::class, 'submitroomguestData'])->name('reservation.submitroomguestData');
        Route::post('/roomguestNote', [ReservationController::class, 'roomguestnoteData'])->name('reservation.roomguestnoteData');
        Route::get('/logDetails', [ReservationController::class, 'getActivityLogDetails'])->name('reservation.getActivityLogDetails');
        Route::post('/checkin', [ReservationController::class, 'roomcheckIn'])->name('reservation.roomcheckIn');
        Route::post('/checkout', [ReservationController::class, 'roomcheckOut'])->name('reservation.roomcheckOut');
        Route::get('/reservation-occupancy-chart', [ReservationController::class, 'occupancyChart'])->name('reservation.occupancyChart');
        Route::post('/reservation-cancel', [ReservationController::class, 'cancelReservation'])->name('reservation.cancelReservation');
        Route::post('/reservation-get-payment', [ReservationController::class, 'getPaymentDetail'])->name('reservation.getPaymentDetail');

        Route::get('/reservation-new', [ReservationController::class, 'reservationLayout'])->name('reservation.reservationLayout');

        Route::get('/checkout-bill/{id}', [CheckoutController::class, 'checkoutReservationPreview'])->name('checkout.checkoutReservationPreview');
        Route::get('/preview-invoice/{id}', [CheckoutController::class, 'previewInvoice'])->name('checkout.previewInvoice');
        Route::get('/checkedout/{id}', [CheckoutController::class, 'checkedoutPreview'])->name('checkout.checkedoutPreview');

        Route::get('/roomcategoryview', [RoomController::class, 'roomCategory'])->name('room.roomCategory');
        Route::post('/roomcategoryadd', [RoomController::class, 'add_room_category'])->name('add_room_category');
        Route::get('/roomcategorydetail', [RoomController::class, 'getRoomCategoryData'])->name('getRoomCategoryData');
        Route::get('/roomtypename', [RoomController::class, 'roomTypeName'])->name('room.roomTypeName');
        Route::post('/roomtypenameAdd', [RoomController::class, 'add_roomTypeName'])->name('room.add_roomTypeName');
        Route::get('/roomtypenamedetails', [RoomController::class, 'get_roomTypeNameData'])->name('room.get_roomTypeNameData');
        Route::get('/roomtypename-details', [RoomController::class, 'get_roomTypeNameDetails'])->name('room.get_roomTypeNameDetails');
        Route::post('/roomTypenameupdate', [RoomController::class, 'roomTypeName_update'])->name('room.roomTypeName_update');
        Route::get('/roomcategory-details', [RoomController::class, 'get_roomCategoryDetails'])->name('room.get_roomCategoryDetails');
        Route::post('/roomcatupdate', [RoomController::class, 'roomCategory_update'])->name('room.roomCategory_update');
        Route::post('/roomcatstatus', [RoomController::class, 'roomCategory_status'])->name('room.roomCategory_status');
        Route::post('/roomtypenamestatus', [RoomController::class, 'roomtype_name_status'])->name('room.roomtype_name_status');
        Route::post('/roomcategorydelete', [RoomController::class, 'roomCategory_delete'])->name('room.roomCategory_delete');
        Route::post('/roomtypenamedelete', [RoomController::class, 'roomtypename_delete'])->name('room.roomtypename_delete');
        Route::get('/roomclosure', [RoomController::class, 'getRoomclosuredata'])->name('room.getRoomclosuredata');
        Route::get('/room-coocupancy-chart', [RoomController::class, 'roomOccupancy'])->name('room.roomOccupancy-chart');

        Route::get('/roomnum', [RoomnumberController::class, 'index'])->name('room.roomNumber');
        Route::post('/roomnumadd', [RoomnumberController::class, 'add_roomNumber'])->name('room.add_roomNumber');
        Route::get('/roomnumdata', [RoomnumberController::class, 'get_roomNumberData'])->name('room.get_roomNumberData');
        Route::get('/roomnumberdetails', [RoomnumberController::class, 'get_roomNumberDetails'])->name('room.get_roomNumberDetails');
        Route::post('/roomnumberstatus', [RoomnumberController::class, 'roomNumber_status'])->name('room.roomNumber_status');
        Route::post('/roomnumberupdate', [RoomnumberController::class, 'roomNumber_update'])->name('room.roomNumber_update');
        Route::post('/roomnumberdelete', [RoomnumberController::class, 'roomNumber_delete'])->name('room.roomNumber_delete');
        Route::post('/roomsupdate', [RoomnumberController::class, 'roomstatusupdate'])->name('room.roomstatusupdate');
        Route::post('/category-roomnumber', [RoomnumberController::class, 'getCategoryRoomNumber'])->name('category-roomnumber.getCategoryRoomNumber');

        Route::resource('roomview', RoomviewController::class);
        Route::post('/room-view-switch', [RoomviewController::class, 'roomViewSwitch'])->name('room.roomViewSwitch');
        Route::post('/get_roomviewdetails', [RoomviewController::class, 'get_roomViewDetails'])->name('room.get_roomViewDetails');
        Route::post('/rooomview_update', [RoomviewController::class, 'rooomView_update'])->name('room.rooomView_update');
        Route::post('/rooomview_delete', [RoomviewController::class, 'rooomView_delete'])->name('room.rooomView_delete');

        Route::post('/viewbedtype', [BedtypeController::class, 'index'])->name('bedtype.index');
        Route::post('/bedinputdata', [BedtypeController::class, 'store'])->name('bedtype.store');
        Route::post('/bedtypeswitch', [BedtypeController::class, 'bedTypeSwitch'])->name('bedtype.bedTypeSwitch');
        Route::post('/bedtypedetail', [BedtypeController::class, 'get_bedtypeDetails'])->name('bedtype.get_bedtypeDetails');
        Route::post('/bedtypeupdate', [BedtypeController::class, 'bedType_update'])->name('bedtype.bedType_update');
        Route::post('/bedtypedelete', [BedtypeController::class, 'bedType_delete'])->name('bedtype.bedType_delete');

        Route::post('/viewfacilities', [FacilitiesController::class, 'index'])->name('facilities.index');
        Route::post('/facilitiesdata', [FacilitiesController::class, 'store'])->name('facilities.store');
        Route::post('/facilitiesswitch', [FacilitiesController::class, 'facilities_switch'])->name('facilities.facilities_switch');
        Route::post('/acilitiesdetails', [FacilitiesController::class, 'get_facilitiesdetails'])->name('facilities.get_facilitiesdetails');
        Route::post('/facilitiesupdate', [FacilitiesController::class, 'facilities_update'])->name('facilities.facilities_update');
        Route::post('/facilitiesdelete', [FacilitiesController::class, 'facilities_delete'])->name('facilities.facilities_delete');

        Route::resource('roomtype', RoomtypeController::class);
        Route::post('/roomtypedatasubmit', [RoomtypeController::class, 'dataimagesUpload'])->name('roomtype.dataimagesUpload');
        Route::post('/roomtypedditdata', [RoomtypeController::class, 'dataimagesEditUpload'])->name('roomtype.dataimagesEditUpload');
        Route::get('/roomtype', [RoomtypeController::class, 'index'])->name('roomtype.index');
        Route::get('/roomtypedetails', [RoomtypeController::class, 'getDetails'])->name('roomtype.getdetails');
        Route::post('/roomtypedelete', [RoomtypeController::class, 'delete_roomtype'])->name('roomtype.delete_roomtype');
        Route::post('/roomtypeimgdelete', [RoomtypeController::class, 'delete_roomtypeImage'])->name('roomtype.delete_roomtypeImage');
        Route::post('/roomtypeupdate', [RoomtypeController::class, 'update_edit'])->name('roomtype.update_edit');
        Route::post('/checkroomtype', [RoomtypeController::class, 'checkRoomType'])->name('roomtype.checkRoomType');
        Route::post('/availableRoomCategory', [RoomtypeController::class, 'availableRoomCategory'])->name('roomtype.availableRoomCategory');

        Route::get('/roomtypedata', [RoomController::class, 'getRoomTypeData'])->name('room.getRoomTypeData');
        Route::get('/getOccupancy', [RoomController::class, 'getOccupancyData'])->name('room.getOccupancyData');
        Route::get('/roomtypedataedit', [RoomController::class, 'getRoomTypeEditData'])->name('room.getRoomTypeEditData');
        Route::get('/getOccupancyedit', [RoomController::class, 'getOccupancyEditData'])->name('room.getOccupancyEditData');
        Route::get('/roomcategory', [RoomController::class, 'getRoomCategory'])->name('room.getRoomCategory');
        Route::post('/roombalance', [RoomController::class, 'roomBalanceFetch'])->name('room.roomBalanceFetch');
        Route::post('/manageroomc', [RoomController::class, 'manageroomclose'])->name('room.manageroomclose');
        Route::get('/resvnroomhistory', [RoomController::class, 'reservationRoomHistory'])->name('reservation.reservationRoomHistory');
        Route::post('/resroomdata', [RoomController::class, 'getAllRoomData'])->name('room.getAllRoomData');

        Route::post('/reservationupdate', [ReservationController::class, 'editReservationUpdate'])->name('reservation.editReservationUpdate');
        Route::post('/updateroomguest', [ReservationController::class, 'updateroomguestData'])->name('reservation.updateroomguestData');
        Route::post('/resconfirm', [ReservationController::class, 'res_confirm_status'])->name('reservation.res_confirm_status');
        Route::post('/guestcheckout', [ReservationController::class, 'guestCheckout'])->name('reservation.guestCheckout');
        Route::post('/getreservationdata', [ReservationController::class, 'getDetailsWithPhone'])->name('reservation.getDetailsWithPhone');
        Route::post('/getresdetailswithphone', [ReservationController::class, 'addDataUsingPhone'])->name('reservation.addDataUsingPhone');
        Route::get('/resvnhistory', [ReservationController::class, 'reservationHistory'])->name('reservation.reservationHistory');
        Route::post('/resdata', [ReservationController::class, 'getAllData'])->name('reservation.getAllData');
        Route::post('/updatediscount', [ReservationController::class, 'updateDiscountEdit'])->name('reservation.updateDiscountEdit');

        Route::post('/reservation-layout', [ReservationLayoutController::class, 'reservationViewLayout'])->name('reservation-layout.reservationViewLayout');

        Route::get('/userpermission', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/getdata', [PermissionController::class, 'getAllData'])->name('permission.getAllData');
        Route::post('/usersmanage', [PermissionController::class, 'update_users'])->name('permission.update_users');
        Route::post('/newuseradd', [PermissionController::class, 'addNewUser'])->name('permission.addNewUser');
        Route::post('/userdelete', [PermissionController::class, 'deleteUser'])->name('permission.deleteUser');

        Route::prefix('reservation')->group(function () {
            Route::get('/create-reservation', [ReservationActionController::class, 'index'])->name('create-reservation.index');
            Route::get('/edit-reservation/{id}', [ReservationActionController::class, 'editReservation'])->name('edit-reservation.editReservation');
            Route::get('/print-payment-receipt/{id}', [ReservationActionController::class, 'printPaymentReceipt']);
            Route::get('/print-payment-receipt-all/{id}', [ReservationActionController::class, 'printPaymentReceiptAll']);
            Route::post('/reservation-guest-exit', [ReservationActionController::class, 'reservationExitGuest'])->name('reservation-guest-exit.reservationExitGuest');
            Route::post('/reservation-tariff-update', [ReservationActionController::class, 'reservationTariffUpdate'])->name('reservation-tariff-update.reservationTariffUpdate');

            Route::get('/merge-bill-report', [MergeBillController::class, 'index'])->name('mergeBill.index');
            Route::get('/mergeBillReservation', [MergeBillController::class, 'mergeBillReservation'])->name('report.mergeBillReservation');
            Route::get('/merge-bill-print/{id}', [MergeBillController::class, 'mergeBillPrint']);
        });

        Route::prefix('invoice')->group(function () {
            Route::get('/print-payment-invoice/{id}', [InvoiceController::class, 'paymentInvoice']);
            Route::get('/send-payment-invoice/{id}', [InvoiceController::class, 'send_paymentInvoice']);
            Route::get('/rp-invoice/{id}', [InvoiceController::class, 'paymentInvoice']);
            Route::post('/invoice-status', [InvoiceController::class, 'invoice_status'])->name('invoice.invoice_status');
            Route::get('/invoice-final-details', [InvoiceController::class, 'final_restr_invoice'])->name('invoice.final_restr_invoice');
            Route::post('/invoice-final-data', [InvoiceController::class, 'getfinalInvoiceData'])->name('invoice.getfinalInvoiceData');
            Route::get('/invoice-final-view/{id}', [InvoiceController::class, 'final_invoice_view'])->name('invoice.final_invoice_view');
            Route::post('/invoice-final-cancel', [InvoiceController::class, 'final_invoice_cancel'])->name('invoice.cancelFinalInvoice');

            Route::post('/generate-invoice', [InvoiceController::class, 'generateInvoice'])->name('invoice.generateInvoice');
        });

        Route::prefix('restaurant')->group(function () {
            Route::get('/restaurant-item-label', [RestaurantLabelController::class, 'index'])->name('restaurant-item-label.index');
            Route::get('/restaurant-item-label-detail', [RestaurantLabelController::class, 'getDetails'])->name('restaurant-item-label.getdetails');
            Route::post('/restaurant-item-label-add', [RestaurantLabelController::class, 'store'])->name('restaurant-item-label-add.store');
            Route::post('/restaurant-item-label-get', [RestaurantLabelController::class, 'getLabel'])->name('restaurant-item-label-get.getLabel');
            Route::post('/restaurant-item-label-switch', [RestaurantLabelController::class, 'switchStatus'])->name('restaurant-item-label.switchStatus');
            Route::post('/restaurant-item-label-delete', [RestaurantLabelController::class, 'delete'])->name('restaurant-item-label.delete');
            Route::post('/restaurant-item-label-update', [RestaurantLabelController::class, 'update'])->name('restaurant-item-label.update');

            Route::get('/restaurant-item-category', [RestaurantCategoryController::class, 'index'])->name('restaurant-item-category.index');
            Route::get('/restaurant-item-category-detail', [RestaurantCategoryController::class, 'getDetails'])->name('restaurant-item-category.getdetails');
            Route::post('/restaurant-item-category-add', [RestaurantCategoryController::class, 'store'])->name('restaurant-item-category-add.store');
            Route::post('/restaurant-item-category-get', [RestaurantCategoryController::class, 'getCategory'])->name('restaurant-item-category-get.getCategory');
            Route::post('/restaurant-item-category-get-all', [RestaurantCategoryController::class, 'getCategoryAll'])->name('restaurant-item-category-get.getCategoryAll');
            Route::post('/restaurant-item-category-switch', [RestaurantCategoryController::class, 'switchStatus'])->name('restaurant-item-category.switchStatus');
            Route::post('/restaurant-item-category-delete', [RestaurantCategoryController::class, 'delete'])->name('restaurant-item-category.delete');
            Route::post('/restaurant-item-category-update', [RestaurantCategoryController::class, 'update'])->name('restaurant-item-category.update');

            Route::get('/restaurant-item-attribute', [RestaurantItemAttributeController::class, 'index'])->name('restaurant-item-attribute.index');
            Route::get('/restaurant-item-attribute-detail', [RestaurantItemAttributeController::class, 'getDetails'])->name('restaurant-item-attribute.getdetails');
            Route::post('/restaurant-item-attribute-add', [RestaurantItemAttributeController::class, 'store'])->name('restaurant-item-attribute-add.store');
            Route::post('/restaurant-item-attribute-get', [RestaurantItemAttributeController::class, 'getAttribute'])->name('restaurant-item-attribute-get.getAttribute');
            Route::post('/restaurant-item-attribute-get-all', [RestaurantItemAttributeController::class, 'getAttributeAll'])->name('restaurant-item-attribute-get.getAttributeAll');
            Route::post('/restaurant-item-attribute-switch', [RestaurantItemAttributeController::class, 'switchStatus'])->name('restaurant-item-attribute.switchStatus');
            Route::post('/restaurant-item-attribute-delete', [RestaurantItemAttributeController::class, 'delete'])->name('restaurant-item-attribute.delete');
            Route::post('/restaurant-item-attribute-update', [RestaurantItemAttributeController::class, 'update'])->name('restaurant-item-attribute.update');
            Route::post('/restaurant-item-attribute-variant-get', [RestaurantItemAttributeController::class, 'itemVariantGetAll'])->name('restaurant-item-attribute.itemVariantGetAll');

            Route::get('/restaurant-table', [RestaurantTableController::class, 'index'])->name('restaurant-table.index');
            Route::get('/restaurant-table-detail', [RestaurantTableController::class, 'getDetails'])->name('restaurant-table.getdetails');
            Route::post('/restaurant-table-add', [RestaurantTableController::class, 'store'])->name('restaurant-table-add.store');
            Route::post('/restaurant-table-get', [RestaurantTableController::class, 'getTable'])->name('restaurant-table-get.getTable');
            Route::post('/restaurant-table-switch', [RestaurantTableController::class, 'switchStatus'])->name('restaurant-table.switchStatus');
            Route::post('/restaurant-table-delete', [RestaurantTableController::class, 'delete'])->name('restaurant-table.delete');
            Route::post('/restaurant-table-update', [RestaurantTableController::class, 'update'])->name('restaurant-table.update');

            Route::get('/restaurant-raw-material', [RestaurantRawMaterialController::class, 'index'])->name('restaurant-raw-material.index');
            Route::get('/restaurant-raw-material-detail', [RestaurantRawMaterialController::class, 'getDetails'])->name('restaurant-raw-material.getdetails');
            Route::post('/restaurant-raw-material-add', [RestaurantRawMaterialController::class, 'store'])->name('restaurant-raw-material-add.store');
            Route::post('/restaurant-raw-material-get', [RestaurantRawMaterialController::class, 'getRawMaterial'])->name('restaurant-raw-material-get.getRawMaterial');
            Route::post('/restaurant-raw-material-switch', [RestaurantRawMaterialController::class, 'switchStatus'])->name('restaurant-raw-material.switchStatus');
            Route::post('/restaurant-raw-material-delete', [RestaurantRawMaterialController::class, 'delete'])->name('restaurant-raw-material.delete');
            Route::post('/restaurant-raw-material-update', [RestaurantRawMaterialController::class, 'update'])->name('restaurant-raw-material.update');

            Route::get('/restaurant-menu', [RestaurantItemController::class, 'index'])->name('restaurant-item.index');
            Route::get('/restaurant-menu-detail', [RestaurantItemController::class, 'getDetails'])->name('restaurant-menu-detail.getDetails');
            Route::post('/restaurant-menu-add', [RestaurantItemController::class, 'store'])->name('restaurant-menu-add.store');
            Route::post('/restaurant-menu-get', [RestaurantItemController::class, 'getMenu'])->name('restaurant-menu-get.getMenu');
            Route::post('/restaurant-menu-switch', [RestaurantItemController::class, 'switchStatus'])->name('restaurant-menu.switchStatus');
            Route::post('/restaurant-menu-delete', [RestaurantItemController::class, 'delete'])->name('restaurant-menu.delete');
            Route::post('/restaurant-menu-update', [RestaurantItemController::class, 'update'])->name('restaurant-menu.update');

            Route::get('/restaurant-breakfast-chart', [RestaurantTableController::class, 'breakfastChart'])->name('restaurant-breakfast-chart.index');
        });

        Route::prefix('kot')->group(function () {
            Route::get('/dashboard', [DashboardKotController::class, 'index'])->name('dashboard-kot.index');
            Route::post('/dashboard-occupancy', [DashboardKotController::class, 'occupancyStatus'])->name('dashboard-occupancy.occupancyStatus');

            Route::get('/generate-kot/{id}', [KotController::class, 'index'])->name('generate-kot.index');
            Route::post('/create-kot', [KotController::class, 'store'])->name('create-kot.store');
            Route::get('/get-coupon-kot', [KotController::class, 'checkCoupon'])->name('get-coupon-kot.checkCoupon');
            Route::post('/record-reservation-payment', [KotController::class, 'recordPayment'])->name('record-reservation-payment.recordPayment');
            Route::post('/convert-room-detail', [KotController::class, 'convertTableRoom'])->name('convert-room-detail.convertTableRoom');
            Route::post('/available-room-kot', [KotController::class, 'getRoomDetail'])->name('available-room-kot.getRoomDetail');
            Route::post('/collect-payment-kot', [KotController::class, 'collectPayment'])->name('collect-payment-kot.collectPayment');

            Route::get('/view-kot', [ViewKotController::class, 'index'])->name('view-kot.index');
            Route::get('/get-all-kot-detail', [ViewKotController::class, 'allDetail'])->name('get-all-kot-detail.allDetail');
            Route::post('/get-kot-detail', [ViewKotController::class, 'getKotDetail'])->name('get-kot-detail.getKotDetail');
            Route::get('/running-kot', [ViewKotController::class, 'runningKot'])->name('kot.runningKot');
            Route::post('/running-kot-data', [ViewKotController::class, 'runningKotData'])->name('kot.runningKotData');
            Route::post('/get-kot-detail-qr', [ViewKotController::class, 'getQrKotDetail'])->name('get-qr-kot-detail.getQrKotDetail');
            Route::post('/update-kot', [ViewKotController::class, 'update'])->name('update-kot.update');
            Route::get('/print-kot-invoice/{id}', [ViewKotController::class, 'printKotInvoice']);
            Route::post('/cancel-kot-detail', [ViewKotController::class, 'cancelKot'])->name('cancel-kot-detail.cancelKot');
            Route::get('/view-kot-print/{id}', [ViewKotController::class, 'getKotPrint'])->name('view-kot-print.getKotPrint');

            Route::get('/view-kot-sale', [ViewKotController::class, 'getKotSaleReport'])->name('view-kot-sale.getKotSaleReport');

            Route::get('/qr-menu-orders', [QrMenuController::class, 'index'])->name('qr-menu-orders.index');
            Route::post('/qr-menu-orders-detail', [QrMenuController::class, 'getKotQrDetailUpdate'])->name('qr-menu-orders-detail.getKotQrDetailUpdate');

            Route::get('/kot-generate-bill', [KotBillController::class, 'index'])->name('kot-generate-bill.index');
            Route::post('/kot-generate-bill-list', [KotBillController::class, 'getBill'])->name('kot-generate-bill-list.getBill');
            Route::get('/kot-generate-bill-show/{id}', [KotBillController::class, 'showKotForBill'])->name('kot-generate-bill-show.showKotForBill');
            Route::get('/invoice-kot-preview/{id}', [KotBillController::class, 'previewKotInvoice'])->name('invoice-kot-preview.previewKotInvoice');
            Route::post('/generate-kot-invoice', [KotBillController::class, 'generateInvoiceKot'])->name('invoice-kot.generateInvoiceKot');

            Route::get('/kot-generated-bill', [GeneratedBillController::class, 'index'])->name('kot-generated-bill.index');
            Route::post('/kot-generated-bill-list', [GeneratedBillController::class, 'getBillPaid'])->name('kot-generated-bill-list.getBillPaid');
            Route::post('/kot-generated-bill-cancel', [GeneratedBillController::class, 'cancelGeneratedBill'])->name('kot-generated-bill-cancel.cancelGeneratedBill');
            Route::get('/kot-generated-bill-invoice/{id}', [GeneratedBillController::class, 'invoiceGeneratedBill'])->name('kot-generated-bill-invoice.invoiceGeneratedBill');
        });

        Route::prefix('tax')->group(function () {
            Route::get('/tax-slab', [TaxslabController::class, 'index'])->name('taxslab.index');
            Route::post('/taxslab-data', [TaxslabController::class, 'getData'])->name('taxslab.getData');
            Route::post('/taxslab-adddata', [TaxslabController::class, 'store'])->name('taxslab.store');
            Route::post('/taxslab-details', [TaxslabController::class, 'getDetails'])->name('taxslab.getDetails');
            Route::post('/taxslab-details-switch', [TaxslabController::class, 'switchStatus'])->name('taxslab-details.switchStatus');
            Route::post('/taxslab-update', [TaxslabController::class, 'update'])->name('taxslab.update');
            Route::post('/taxslab-delete', [TaxslabController::class, 'delete'])->name('taxslab.delete');
            Route::post('/taxslab-default-switch', [TaxslabController::class, 'switchDefaultTax'])->name('taxslab-default.switchDefaultTax');

            Route::get('/tax-category', [TaxCategoryController::class, 'index'])->name('tax-category.index');
            Route::get('/tax-category-detail', [TaxCategoryController::class, 'getDetails'])->name('tax-category-detail.getDetails');
            Route::post('/tax-category-add', [TaxCategoryController::class, 'store'])->name('tax-category-add.store');
            Route::post('/tax-category-get', [TaxCategoryController::class, 'getTaxCategory'])->name('tax-category-get.getTaxCategory');
            Route::post('/tax-category-switch', [TaxCategoryController::class, 'switchStatus'])->name('tax-category.switchStatus');
            Route::post('/tax-category-delete', [TaxCategoryController::class, 'delete'])->name('tax-category.delete');
            Route::post('/tax-category-update', [TaxCategoryController::class, 'update'])->name('tax-category.update');
        });

        Route::prefix('setting')->group(function () {
            Route::get('/payment-method', [PaymentController::class, 'index'])->name('payment-method.index');
            Route::get('/payment-method-detail', [PaymentController::class, 'getDetails'])->name('payment-method-detail.getDetails');
            Route::post('/payment-method-add', [PaymentController::class, 'store'])->name('payment-method-add.store');
            Route::post('/payment-method-get', [PaymentController::class, 'getPaymentMethod'])->name('payment-method-get.getPaymentMethod');
            Route::post('/payment-method-switch', [PaymentController::class, 'switchStatus'])->name('payment-method.switchStatus');
            Route::post('/payment-method-delete', [PaymentController::class, 'delete'])->name('payment-method.delete');
            Route::post('/payment-method-update', [PaymentController::class, 'update'])->name('payment-method.update');
            Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
            Route::post('/company-view', [CompanyController::class, 'view'])->name('company.view');
            Route::post('/company-add', [CompanyController::class, 'add'])->name('company.add');
            Route::post('/company-switch', [CompanyController::class, 'switchStatus'])->name('company.switchStatus');
            Route::post('/company-detail', [CompanyController::class, 'getDetails'])->name('company.getDetails');
            Route::post('/company-update', [CompanyController::class, 'update'])->name('company.update');
            Route::post('/company-verify-gst', [CompanyController::class, 'verifyGst'])->name('company.verifyGst');
            Route::post('/get-company-list-gst', [CompanyController::class, 'companyList'])->name('company.companyList');

            Route::get('/waiter', [WaiterController::class, 'index'])->name('waiter.index');
            Route::post('/waiter-view', [WaiterController::class, 'view'])->name('waiter.view');
            Route::post('/waiter-add', [WaiterController::class, 'add'])->name('waiter.add');
            Route::post('/waiter-switch', [WaiterController::class, 'switchStatus'])->name('waiter.switchStatus');
            Route::post('/waiter-detail', [WaiterController::class, 'getDetails'])->name('waiter.getDetails');
            Route::post('/waiter-update', [WaiterController::class, 'update'])->name('waiter.update');

            Route::get('/vendor', [VendorController::class, 'index'])->name('vendor.index');
            Route::post('/vendor-view', [VendorController::class, 'view'])->name('vendor.view');
            Route::post('/vendor-add', [VendorController::class, 'add'])->name('vendor.add');
            Route::post('/vendor-switch', [VendorController::class, 'switchStatus'])->name('vendor.switchStatus');
            Route::post('/vendor-detail', [VendorController::class, 'getDetails'])->name('vendor.getDetails');
            Route::post('/vendor-update', [VendorController::class, 'update'])->name('vendor.update');

            Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
            Route::post('/department-view', [DepartmentController::class, 'view'])->name('department.view');
            Route::post('/department-add', [DepartmentController::class, 'add'])->name('department.add');
            Route::post('/department-switch', [DepartmentController::class, 'switchStatus'])->name('department.switchStatus');
            Route::post('/department-detail', [DepartmentController::class, 'getDetails'])->name('department.getDetails');
            Route::post('/department-update', [DepartmentController::class, 'update'])->name('department.update');

            Route::get('/tariff', [TariffController::class, 'index'])->name('tariff.index');
            Route::post('/tariff-view', [TariffController::class, 'view'])->name('tariff.view');
            Route::post('/tariff-add', [TariffController::class, 'add'])->name('tariff.add');
            Route::post('/tariff-switch', [TariffController::class, 'switchStatus'])->name('tariff.switchStatus');
            Route::post('/tariff-detail', [TariffController::class, 'getDetails'])->name('tariff.getDetails');
            Route::post('/tariff-update', [TariffController::class, 'update'])->name('tariff.update');

            Route::get('/general-setting', [GeneralSettingController::class, 'index'])->name('general-setting.index');
            Route::post('/general-setting-invoice-update', [GeneralSettingController::class, 'updateInvoice'])->name('general-setting-invoice.updateInvoice');
            Route::post('/general-setting-invoice-reset', [GeneralSettingController::class, 'resetInvoiceNumber'])->name('general-setting-invoice-reset.resetInvoiceNumber');

            Route::get('/reason-closer', [CloserReasonController::class, 'index'])->name('reason-closer.index');
            Route::post('/reason-closer-view', [CloserReasonController::class, 'view'])->name('reason-closer.view');
            Route::post('/reason-closer-store', [CloserReasonController::class, 'store'])->name('reason-closer.store');
            Route::post('/reason-closer-switch', [CloserReasonController::class, 'switch'])->name('reason-closer.switch');
            Route::post('/reason-closer-get-data', [CloserReasonController::class, 'getData'])->name('reason-closer.getData');
            Route::post('/reason-closer-update', [CloserReasonController::class, 'update'])->name('reason-closer.update');

            Route::get('/audit-setting', [AuditController::class, 'index'])->name('audit-setting.index');
            Route::post('/audit-setting-update', [AuditController::class, 'update'])->name('audit-setting-update');

            Route::get('/event', [EventController::class, 'index'])->name('event.index');
            Route::post('/event-view', [EventController::class, 'view'])->name('event.view');
            Route::post('/event-store', [EventController::class, 'store'])->name('event.store');
            Route::post('/event-data', [EventController::class, 'getData'])->name('event.getData');
            Route::post('/event-update', [EventController::class, 'update'])->name('event.update');
            Route::post('/event-switch', [EventController::class, 'switch'])->name('event.switch');

            Route::get('/feature', [FeatureController::class, 'index'])->name('feature.index');
            Route::post('/feature-view', [FeatureController::class, 'view'])->name('feature.view');
            Route::post('/feature-store', [FeatureController::class, 'store'])->name('feature.store');
            Route::post('/feature-switch', [FeatureController::class, 'switch'])->name('feature.switch');
            Route::post('/feature-data', [FeatureController::class, 'getData'])->name('feature.getData');
            Route::post('/feature-update', [FeatureController::class, 'update'])->name('feature.update');

            Route::get('/accessories', [AccessoriesController::class, 'index'])->name('accessories.index');
            Route::post('/accessories-view', [AccessoriesController::class, 'view'])->name('accessories.view');
            Route::post('/accessories-store', [AccessoriesController::class, 'store'])->name('accessories.store');
            Route::post('/accessories-switch', [AccessoriesController::class, 'switch'])->name('accessories.switch');
            Route::post('/accessories-data', [AccessoriesController::class, 'getData'])->name('accessories.getData');
            Route::post('/accessories-update', [AccessoriesController::class, 'update'])->name('accessories.update');

            Route::get('/usertype', [UsertypeController::class, 'index'])->name('usertype.index');
            Route::post('/usertype-view', [UsertypeController::class, 'view'])->name('usertype.view');
            Route::get('/usertype-create', [UsertypeController::class, 'create'])->name('usertype.create');
            Route::post('/usertype-add', [UsertypeController::class, 'store'])->name('usertype.store');
            Route::post('/usertype-update', [UsertypeController::class, 'update'])->name('usertype.update');
            Route::get('/usertype-edit/{id}', [UsertypeController::class, 'edit'])->name('usertype-edit.edit');
            Route::post('/usertype-switch', [UsertypeController::class, 'switch'])->name('usertype.switch');
            Route::post('/usertype-get-permission', [UsertypeController::class, 'getPermissionUser'])->name('usertype.getPermissionUser');

            Route::get('/user', [UserController::class, 'index'])->name('user.index');
            Route::post('/user-view', [UserController::class, 'view'])->name('user.view');
            Route::get('/user-create', [UserController::class, 'create'])->name('user.create');
            Route::post('/user-add', [UserController::class, 'store'])->name('user.store');
            Route::post('/user-switch', [UserController::class, 'switch'])->name('user.switch');
            Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
            Route::get('/user-edit/{id}', [UserController::class, 'edit'])->name('user-edit.edit');
        });

        Route::prefix('report')->group(function () {
            // Route::get('/roomReport',[RoomReportController::class,'index'])->name('roomReport.index');
            // Route::get('/roomReportView',[RoomReportController::class,'roomReportView'])->name('report.roomReportView');
            Route::get('/guestHistoryReport', [GuestHistoryReportController::class, 'index'])->name('guestHistory.index');
            Route::get('/guestHistoryReportView', [GuestHistoryReportController::class, 'guestHistoryReportView'])->name('report.guestHistoryReportView');

            Route::get('/reservationReportView', [ReservationReportController::class, 'index'])->name('reservationReport.index');
            Route::get('/reservationReportPrint/{id}', [ReservationReportController::class, 'printReservation']);
            Route::get('/reservationReport', [ReservationReportController::class, 'reservationReportView'])->name('report.reservationReportView');
            Route::post('/reservation-cancel-checkout', [ReservationReportController::class, 'reservationCancelCheckout'])->name('report.reservationCancelCheckout');
            // Route::post('/reservation-update-checkin-checkout',[ReservationReportController::class,'reservationUpdateCheckinCheckout'])->name('report.reservationUpdateCheckinCheckout');
            Route::post('/reservation-update-checkin-checkout-update', [ReservationReportController::class, 'reservationUpdateCheckinCheckoutTime'])->name('report.reservationUpdateCheckinCheckoutTime');
            Route::post('/reservation-get-checkin-checkout', [ReservationReportController::class, 'reservationGetDetail'])->name('report.reservationGetDetail');

            Route::get('/reservation-checkout', [ReservationCheckoutController::class, 'index'])->name('reservation-checkout.index');
            Route::get('/reservation-checkout-detail', [ReservationCheckoutController::class, 'reservationCheckoutReportView'])->name('reservation-checkout-detail.reservationCheckoutReportView');

            Route::get('/reservationCancelView', [ReservationCancelController::class, 'index'])->name('reservationCancel.index');
            Route::get('/reservationCancel', [ReservationCancelController::class, 'reservationCancelView'])->name('report.reservationCancelReportView');
            Route::post('/reservation-update-checkin-checkout', [ReservationCancelController::class, 'reservationUpdateTime'])->name('report.reservationUpdateTime');

            Route::get('/kotReport', [KotReportController::class, 'index'])->name('kotReport.index');
            Route::get('/kotReportView', [KotReportController::class, 'kotReportView'])->name('report.kotReportView');
            Route::get('/hall-utilization-report', [HallUtilizationReportController::class, 'index'])->name('hallUtilization.index');
            Route::get('/hall-utilization-view', [HallUtilizationReportController::class, 'hallReportView'])->name('hallUtilization.hallReportView');
            Route::get('/hall-revenue-comparison', [HallRevenueComparisonController::class, 'index'])->name('hallRevenue.index');
            Route::get('/hall-revenue-comparison-view', [HallRevenueComparisonController::class, 'hallRevenueView'])->name('hallRevenue.hallRevenueView');
            Route::get('/comprehensive-booking-report', [ComprehensiveBookingReportController::class, 'index'])->name('comprehensiveBooking.index');
            Route::get('/comprehensive-booking-view', [ComprehensiveBookingReportController::class, 'comprehensiveBookingView'])->name('comprehensiveBooking.comprehensiveBookingView');
            Route::get('/event-type-analysis', [EventTypeController::class, 'index'])->name('eventType.index');
            Route::get('/event-type-analysis-view', [EventTypeController::class, 'eventTypeView'])->name('eventType.eventTypeView');
            Route::get('/monthly-revenue-breakdown', [MonthlyRevenueBreakdownController::class, 'index'])->name('monthlyRevenue.index');
            Route::get('/monthly-revenue-breakdown-view', [MonthlyRevenueBreakdownController::class, 'monthlyRevenueView'])->name('monthlyRevenue.monthlyRevenueView');
            Route::get('/outstanding-payments-report', [OutstandingPaymentsReportController::class, 'index'])->name('outstandingPayments.index');
            Route::get('/outstanding-payments-report-view', [OutstandingPaymentsReportController::class, 'outstandingPaymentsView'])->name('outstandingPayments.outstandingPaymentsView');
            Route::get('/comprehensive-corporate-report', [ComprehensiveCorporateRevenueController::class, 'index'])->name('comprehensiveCorporate.index');
            Route::get('/comprehensive-corporate-view', [ComprehensiveCorporateRevenueController::class, 'comprehensiveCorporateView'])->name('comprehensiveCorporate.comprehensiveCorporateView');

            Route::get('/guest-history', [GuesthistoryController::class, 'index'])->name('guestHistory.index');
            Route::get('/guest-history-data', [GuesthistoryController::class, 'guestHistoryData'])->name('guestHistory.data');
            Route::get('/guest-history-details/{id}', [GuesthistoryController::class, 'guestHistoryDetails'])->name('guestHistory.details');
            Route::post('/guest-history-details-data', [GuesthistoryController::class, 'guestHistoryListDetails'])->name('guestHistory.historyDetails');
            Route::post('/guest-history-reservation-details', [GuesthistoryController::class, 'getReservationDetails'])->name('guestHistory.getReservationDetails');
            Route::post('/guest-restaurant-details-data', [GuesthistoryController::class, 'guestRestaurantListDetails'])->name('guestHistory.restaurantDetails');
            Route::post('/guest-restaurant-details', [GuesthistoryController::class, 'guestRestaurantDetails'])->name('guestHistory.getRestaurantDetails');
            Route::post('/guest-history-get-details', [GuesthistoryController::class, 'guestHistoryGetDetails'])->name('guestHistory.getDetails');
            Route::post('/guest-history-update-details', [GuesthistoryController::class, 'guestHistoryUpdateDetails'])->name('guestHistory.updateDetails');
            Route::get('/guest-reservation-print/{id}', [GuesthistoryController::class, 'reservationPrintBill'])->name('guest-reservation-print.reservationPrintBill');

            // new report
            Route::get('stay-report', [StayController::class, 'index'])->name('stayReport.index');
            // Route::get('stay-report-view',[StayController::class, 'stayReportView'])->name('stayReport.stayReportView');


            Route::get('/stay-report/data', [StayController::class, 'stayReportView'])->name('stayReport.stayReportView');

            Route::get('/stay-report/export', [StayController::class, 'export'])->name('stayReport.export');

            Route::get('room-revenue-report', [RoomRevenueController::class, 'index'])->name('roomRevenueReport.index');
            Route::get('room-revenue-report-view', [RoomRevenueController::class, 'roomRevenueReportView'])->name('roomRevenueReport.roomRevenueReportView');
            Route::get('single-booking-sale-report', [SingleBookingSaleController::class, 'index'])->name('singleBookingSaleReport.index');
            Route::get('single-booking-sale-report-view', [SingleBookingSaleController::class, 'singleBookingSaleReportView'])->name('singleBookingSaleReport.singleBookingSaleReportView');
            Route::get('bulk-booking-sale', [BulkBookingSaleController::class, 'index'])->name('bulkBookingSale.index');
            Route::get('bulk-booking-sale-view', [BulkBookingSaleController::class, 'bulkBookingSaleView'])->name('bulkBookingSale.bulkBookingSaleView');
            Route::get('room-status', [RoomStatusController::class, 'index'])->name('roomStatus.index');
            Route::get('room-status-view', [RoomStatusController::class, 'roomStatusView'])->name('roomStatus.roomStatusView');
            Route::post('room-status-update', [RoomStatusController::class, 'roomStatusUpdate'])->name('roomStatus.roomStatusUpdate');
            Route::get('kot-list-report', [KotListReportController::class, 'index'])->name('kotListReport.index');
            Route::get('kot-list-report-view', [KotListReportController::class, 'kotListReportView'])->name('kotListReport.kotListReportView');
            Route::get('restaurant-sales-report', [RestaurantSalesReportController::class, 'index'])->name('restaurantSaleReport.index');
            Route::get('restaurant-sales-report-view', [RestaurantSalesReportController::class, 'restaurantSaleReportView'])->name('restaurantSaleReport.restaurantSaleReportView');
            Route::get('kot-item-report', [KotItemController::class, 'index'])->name('kotItemReport.index');
            Route::get('kot-item-report-view', [KotItemController::class, 'kotItemReportView'])->name('kotItemReport.kotItemReportView');
            Route::get('item-wise-sale', [ItemwiseSalesController::class, 'index'])->name('itemWiseSale.index');
            Route::get('item-wise-sale-view', [ItemwiseSalesController::class, 'itemWiseSaleView'])->name('itemWiseSale.itemWiseSaleView');
            Route::get('payment-summary-report', [PaymentSummaryController::class, 'index'])->name('paymentSummary.index');
            Route::get('payment-summary-report-view', [PaymentSummaryController::class, 'paymentSummaryView'])->name('paymentSummary.paymentSummaryView');
        });

        Route::prefix('nightaudit')->group(function () {
            Route::get('/dashboard', [AuditReportController::class, 'index'])->name('auditReport.index');
            Route::post('/update-progress', [AuditReportController::class, 'updateProgress'])->name('auditReport.updateProgress');
            Route::post('/update-audit-time', [AuditReportController::class, 'auditTime'])->name('auditReport.auditTime');
            Route::get('/dashboard-print', [AuditReportController::class, 'print']);

            Route::get('/guest-folio', [GuestFolioAuditController::class, 'index'])->name('guest-folio.index');
            Route::get('/guest-folio-cancel-reservation', [GuestFolioAuditController::class, 'cancelReservation'])->name('guest-folio-cancel-reservation.cancelReservation');
            Route::get('/guest-folio-print', [GuestFolioAuditController::class, 'print']);
            Route::post('/reservation-payment-record', [GuestFolioAuditController::class, 'recordReservationPayment'])->name('auditReport.recordReservationPayment');

            Route::get('/revenue-audit', [RevenueAuditController::class, 'index'])->name('revenue-audit.index');
            Route::get('/revenue-audit-print', [RevenueAuditController::class, 'print']);

            Route::get('/room-audit', [RoomAuditController::class, 'index'])->name('room-audit.index');
            Route::get('/room-audit-print', [RoomAuditController::class, 'print']);

            Route::get('/kot-audit', [FoodBanquetAuditController::class, 'index'])->name('kot-audit.index');
            Route::get('/kot-audit-print', [FoodBanquetAuditController::class, 'print']);
        });

        Route::prefix('store')->group(function () {
            Route::get('/purchase-order', [PurchaseController::class, 'purchaseOrder'])->name('store.purchaseOrder');
            Route::get('/purchase-list', [PurchaseController::class, 'purchaseList'])->name('store.purchaseList');
            Route::post('/purchase-items-list', [PurchaseController::class, 'purchaseItemVeiw'])->name('store.purchaseItemVeiw');
            Route::post('/purchase-items-detail', [PurchaseController::class, 'getPurchaseItem'])->name('store.getPurchaseItem');
            Route::post('/purchase-items-update', [PurchaseController::class, 'purchaseQtyUpdate'])->name('store.purchaseQtyUpdate');
            Route::post('/purchase-order-list', [PurchaseController::class, 'purchaseOrderVeiw'])->name('store.purchaseOrderVeiw');
            Route::get('/purchase-add-page', [PurchaseController::class, 'purchaseAdd']);
            Route::get('/purchase-goods-entry/{id}', [PurchaseController::class, 'goodsEntryPage']);
            Route::post('/purchase-add', [PurchaseController::class, 'purchaseAddSubmit'])->name('store.purchaseAddSubmit');
            Route::post('/purchase-item-received-quantity-update', [PurchaseController::class, 'receivedQuantityUpdate'])->name('store.receivedQuantityUpdate');
            Route::get('/purchase-print/{id}', [PurchaseController::class, 'printPurchase']);

            Route::get('/stock-order', [StockController::class, 'stockOrder'])->name('store.stockOrder');
            Route::post('/stock-order-view', [StockController::class, 'stockOrderVeiw'])->name('store.stockOrderVeiw');
            Route::get('/stock-add-page', [StockController::class, 'stockAdd']);
            Route::post('/stock-add', [StockController::class, 'stockAddSubmit'])->name('store.stockAddSubmit');
            Route::get('/stock-request', [StockController::class, 'stockRequest'])->name('store.stockRequest');
            Route::post('/stock-request-view', [StockController::class, 'stockRequestView'])->name('store.stockRequestView');
            Route::get('/stock-current', [StockController::class, 'stockCurrent'])->name('store.stockCurrent');
            Route::post('/stock-current-view', [StockController::class, 'stockCurrentView'])->name('store.stockCurrentView');
            Route::get('/stock-request-in-page/{id}', [StockController::class, 'stockRequestInPage']);
            Route::post('/stock-request-qty-update', [StockController::class, 'stockReceivedQuantityUpdate'])->name('store.stockReceivedQuantityUpdate');

            Route::get('/transfer-report', [ReportController::class, 'transferReport'])->name('store.transferReport');
            Route::post('/transfer-report-view', [ReportController::class, 'transferReportVeiw'])->name('store.transferReportVeiw');
            Route::get('/deficiency-report', [ReportController::class, 'deficiencyReport'])->name('store.deficiencyReport');
            Route::post('/deficiency-report-view', [ReportController::class, 'deficiencyReportVeiw'])->name('store.deficiencyReportVeiw');
            Route::get('/waste-dispose-report', [ReportController::class, 'wasteDisposeReport'])->name('store.wasteDisposeReport');
            Route::post('/waste-dispose-report-view', [ReportController::class, 'wasteDisposeReportView'])->name('store.wasteDisposeReportView');
            Route::post('/waste-dispose-item', [ReportController::class, 'wasteDisposeItem'])->name('store.wasteDisposeItem');
        });

        Route::prefix('kitchen')->group(function () {
            Route::get('/dashboard', [KitchenController::class, 'dashboard'])->name('kitchen.dashboard');
            Route::post('/room-kot-data', [KitchenController::class, 'getRoomKotData'])->name('kitchen.getRoomKotData');
            Route::post('/table-kot-data', [KitchenController::class, 'getTableKotData'])->name('kitchen.getTableKotData');
            Route::get('/kot-monitor', [KitchenController::class, 'KotMonitor'])->name('kitchen.kot-monitor');
            Route::post('/kot-monitor-data', [KitchenController::class, 'KotMonitorData'])->name('kitchen.kot-monitor-data');
            Route::post('/kot-delivered', [KitchenController::class, 'markKotDelivered'])->name('kitchen.markKotDelivered');
            Route::get('/in-stock', [KitchenController::class, 'inStock'])->name('kitchen.inStock');
            Route::post('/in-stock-view', [KitchenController::class, 'inStockView'])->name('kitchen.inStockView');
            Route::get('/consumtion-report', [KitchenController::class, 'consumtionReport'])->name('kitchen.consumtionReport');
            Route::post('/consumtion-report-view', [KitchenController::class, 'consumptionReportView'])->name('kitchen.consumptionReportView');
            Route::get('/transfer-request', [KitchenController::class, 'transferRequest'])->name('kitchen.transferRequest');
            Route::post('/transfer-request-add', [KitchenController::class, 'transferRequestSubmit'])->name('kitchen.transferRequestSubmit');
            Route::get('/pending-request', [KitchenController::class, 'pendingRequest'])->name('kitchen.pendingRequest');
            Route::post('/pending-request-view', [KitchenController::class, 'pendingRequestVeiw'])->name('kitchen.pendingRequestVeiw');
            Route::get('/return-request/{id}', [KitchenController::class, 'returnRequest']);
            Route::post('/return-request-add', [KitchenController::class, 'returnRequestSubmit'])->name('kitchen.returnRequestSubmit');
            Route::get('/return-request-list', [KitchenController::class, 'returnRequestList'])->name('kitchen.returnRequestList');
            Route::post('/return-request-data', [KitchenController::class, 'returnRequestVeiw'])->name('kitchen.returnRequestVeiw');
        });

        Route::prefix('banquet')->group(function () {
            Route::get('/dashboard', [BanquetDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('/dashboard-data', [BanquetDashboardController::class, 'getDashboardData'])->name('dashboard.getDashboardData');
            Route::post('/dashboard-calender-date-info', [BanquetDashboardController::class, 'calenderDateInfo'])->name('dashboard.calender-date-info');

            Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
            Route::post('/booking-view', [BookingController::class, 'view'])->name('booking.view');
            Route::get('/create-booking', [BookingController::class, 'newBooking'])->name('create-booking.newBooking');
            Route::get('/edit-booking/{id}', [BookingController::class, 'editBooking'])->name('edit-booking.editBooking');
            Route::post('/fetch-booking', [BookingController::class, 'dataCollect'])->name('booking.dataCollect');
            Route::post('/add-booking', [BookingController::class, 'store'])->name('booking.store');
            Route::get('/booking-invoice/{id}', [BookingController::class, 'invoice']);
            Route::post('/update-booking', [BookingController::class, 'update'])->name('booking.update');
            Route::post('/get-booking', [BookingController::class, 'getBooking'])->name('booking.getBooking');
            Route::post('/booking-cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
            Route::post('/booking-payment-add', [BookingController::class, 'addPayment'])->name('booking.addPayment');
            Route::post('/booking-draft-convert', [BookingController::class, 'draftToBooking'])->name('booking.draftToBooking');

            Route::get('/hall', [HallController::class, 'index'])->name('hall.index');
            Route::post('/hall-add', [HallController::class, 'store'])->name('hall.store');
            Route::post('/hall-view', [HallController::class, 'view'])->name('hall.view');
            Route::post('/hall-switch', [HallController::class, 'switch'])->name('hall.switch');
            Route::post('/hall-get-data', [HallController::class, 'getData'])->name('hall.getData');
            Route::post('/hall-update', [HallController::class, 'update'])->name('hall.update');
            Route::post('/hall-update-status', [HallController::class, 'updateStatus'])->name('hall.update-status');

            Route::get('/client', function () {
                return view('backend/modules/banquet/client');
            });
            Route::get('/reports', function () {
                return view('backend/modules/banquet/reports');
            });
        });
    });
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});
