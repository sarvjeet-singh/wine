<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController as FrontendAdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VendorWineController;
use App\Http\Controllers\WineryController;
use App\Http\Controllers\WineryCartController;
use App\Http\Controllers\WineryCheckoutController;
use App\Http\Controllers\WineReviewController;
use App\Http\Controllers\WineryOrderController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorStripeDetailController;
// use App\Http\Controllers\MigrationController;
use illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\WineController as AdminWineController;
use App\Http\Controllers\Admin\CommonController as AdminCommonController;
use App\Http\Controllers\Admin\WineCatalogueController as AdminWineCatalogueController;
use App\Http\Controllers\Admin\UserEmailController as AdminUserEmailController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Artisan;
// Artisan::call('storage:link');

// use App\Http\Middleware\CheckVendorAuthorization;
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

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    // Retrieve the user by ID
    $user = App\Models\User::findOrFail($id);

    // Check if the hash matches the user's email verification hash
    if (hash_equals($hash, sha1($user->getEmailForVerification()))) {
        // Fulfill the email verification (mark the email as verified)
        $user->markEmailAsVerified();

        // Redirect to home or any other page after successful verification
        return redirect('/login')->with('success', 'Email verified successfully.');
    }

    // If verification fails, return an error or redirect back
    return redirect('/login')->withErrors(['error' => 'Invalid verification link.']);
})->middleware('signed')->name('verification.verify');

Route::post('/validate-captcha', [RegisterController::class, 'validateCaptcha'])->name('validate-captcha');
Route::get('/refresh-captcha', [RegisterController::class, 'refreshCaptcha'])->name('refresh-captcha');
Route::post('email/resend', [LoginController::class, 'resend'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend');
Route::post('/check-email', [LoginController::class, 'checkEmail'])->name('check.email');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/register', [RegisterController::class, 'showRegistrationForm'])->name('register-form');
Route::post('/registertion', [RegisterController::class, 'register'])->name('registertion');
// Define the error route if needed
Route::get('/some-error-route', function () {
    return 'Error: Vendor not found.';
})->name('some.error.route');


// ================= FRONT END ============== //
Route::get('/', [FrontEndController::class, 'home'])->name('home');
Route::get('/login/{token}', [LoginController::class, 'loginWithToken'])->name('login-with-token');
Route::post('/customlogin', [LoginController::class, 'process_login'])->name('custom_login');
Route::post('/login-ajax', [LoginController::class, 'loginAjax'])->name('login.ajax');
Route::get('check-login', function () {
    if (!auth()->check()) {
        // If not logged in, flash an error message and redirect to login
        session()->flash('error', 'You must be logged in to submit a business.');
        return redirect()->route('login');
    }

    // If logged in, redirect to the original action (e.g., the form to promote a business)
    return redirect()->route('become-vendor');
})->name('check-login');
// Route::get('/accommodations', [FrontEndController::class, 'getAccommodations'])->name('accommodations');
Route::post('/get-accommodations', [FrontEndController::class, 'getAccommodationsList'])->name('get.accommodation');
Route::post('/accommodation/inquiry', [FrontEndController::class, 'AccommodationsInquiry'])->name('accommodation.inquiry')->middleware('auth');
Route::post('/excursion/inquiry', [FrontEndController::class, 'excursionstore'])->name('excursion.inquiry')->middleware('auth');
Route::post('/winery/inquiry', [FrontEndController::class, 'winerystore'])->name('winery.inquiry')->middleware('auth');
Route::get('/accommodation/{vendorslug?}', [FrontEndController::class, 'getAccommodationDetails'])->name('accommodation-details');
Route::get('/winery/{vendorslug?}', [FrontEndController::class, 'getWineryDetails'])->name('winery-details');
Route::get('/excursions/{vendorslug?}', [FrontEndController::class, 'getExcursionDetails'])->name('excursion-details');

Route::post('/check-availability/{vendorid?}', [FrontEndController::class, 'CheckAvailability'])->name('check.availability');

// checkout process

Route::get('/get-hours/{vendor_id?}', [FrontEndController::class, 'businessHours'])->name('checkout.info');

Route::post('/check-process', [FrontEndController::class, 'CheckProcess'])->name('checkout.process');
Route::get('/checkout/info/{token}', [FrontEndController::class, 'Checkoutinfo'])->name('checkout.info');

// Route::get('/wineries', [FrontEndController::class, 'wineries'])->name('wineries-listing');
Route::post('/get-wineries', [FrontEndController::class, 'getWineriesList'])->name('get.wineries');
// Route::get('/licensed', [FrontEndController::class, 'licensed'])->name('licensed');
Route::post('/get-licensed', [FrontEndController::class, 'getlicensedList'])->name('get.licensed');
// Route::get('/non-licensed', [FrontEndController::class, 'nonLicensed'])->name('non-licensed');
Route::post('/get-non-licensed', [FrontEndController::class, 'getnonlicensedList'])->name('get.non-licensed');
// Route::get('/excursion', [FrontEndController::class, 'excursions'])->name('excursion-listing');

Route::post('/get-excursions', [FrontEndController::class, 'getExcursionsList'])->name('get.excursions');
Route::get('/manage_dates', [FrontEndController::class, 'manage_sub_regionsPost'])->name('manage.dates');
Route::get('/booking', function () {
    return view('FrontEnd.booking-form');
})->name('booking-form');

Route::get('/contact-us', function () {
    return view('FrontEnd.contact-us');
})->name('contact-us');
Route::post('/contact-us-submit', [FrontEndController::class, 'sendMails'])->name('contact.send');
Route::get('/about-us', function () {
    return view('FrontEnd.about-us');
})->name('about-us');
Route::get('/guest-rewards', function () {
    return view('FrontEnd.guest-rewards');
})->name('guest-rewards');

//  QR Code
Route::get('vendor-QCode-show/{slug}', [FrontEndController::class, 'showQCode'])->name('vendorQCode.show');
Route::get('vendor-QCode-generate/{slug}', [FrontEndController::class, 'generateQCode'])->name('vendorQCode.generate');

// ================= USER DASHBOARD ============== //
Auth::routes();
Route::get('/user-dashboard', [UserDashboardController::class, 'userDashboard'])->name('user-dashboard');
Route::get('/user-review-submit', [UserDashboardController::class, 'userReviews'])->name('user-review-submit');
Route::post('/user-reviews-submit', [UserDashboardController::class, 'userReviewsSubmit'])->name('user-reviews-submit');
Route::get('/manage-review', [UserDashboardController::class, 'userReviewsManage'])->name('manage-review');
Route::get('/guest-registry', [UserDashboardController::class, 'userGuestRegistry'])->name('user-guest-registry');
Route::post('/user-update-address', [UserDashboardController::class, 'userAddressUpdate'])->name('user.update.address');
Route::post('/user-update-goverment-proof', [UserDashboardController::class, 'userGovermentUpdate'])->name('user.goverment.update');
Route::get('/user-settings', [UserDashboardController::class, 'userSettings'])->name('user-settings');
Route::post('/user-settings-update', [UserDashboardController::class, 'userSettingsAccountUpdate'])->name('user-settings-account-update');
Route::post('/user-settings-emergency-update', [UserDashboardController::class, 'userSettingsEmergencyUpdate'])->name('user-settings-emergency-update');
Route::post('/user-settings-refferral-update', [UserDashboardController::class, 'userSettingsRefferralUpdate'])->name('user.settings.refferral.update');
Route::post('/user-settings-social-update', [UserDashboardController::class, 'userSettingsSocialUpdate'])->name('user-settings-social-update');
Route::post('/user-settings-update-password', [UserDashboardController::class, 'userSettingsUpdatePassword'])->name('user-settings-update-password');
Route::get('/vendor_list', [UserDashboardController::class, 'vendor_list'])->name('vendor_list');
Route::get('/vendor-suggest', [UserDashboardController::class, 'vendorsuggest'])->name('vendorsuggest');
Route::post('/vendor-suggest', [UserDashboardController::class, 'StoreVendorSuggest'])->name('vendor_suggest');
Route::get('/become-vendor', [UserDashboardController::class, 'becomevendor'])->name('become-vendor');
Route::get('/referral', function () {
    return view('UserDashboard.user-referral');
})->name('user-referral');
Route::get('/faq', [UserDashboardController::class, 'userFaqs'])->name('user-faq');
// Route::get('user/orders', [UserDashboardController::class, 'orders'])->name('user.orders');
Route::get('/user/transactions', [UserDashboardController::class, 'orders'])->name('user-transactions');
Route::get('user/transactions/{id}', [UserDashboardController::class, 'orderDetail'])->name('user.orderDetail');
Route::get('/user/inquiries', [UserDashboardController::class, 'inquiries'])->name('user-inquiries');
Route::get('user/inquiries/{id}', [UserDashboardController::class, 'inquiryDetail'])->name('user.inquiryDetail');

Route::post('orders/authorize-payment', [OrderController::class, 'authorizePayment'])->name('orders.authorize-payment');
Route::post('orders/send-inquiry', [OrderController::class, 'sendInquiry'])->name('orders.send-inquiry');



// ================= VENDOR ============== //
Route::group(['middleware' => ['auth', 'check.vendorid']], function () {
    Route::get('/vendor-change-password/{vendorid}', [VendorController::class, 'changePassword'])->name('vendor-change-password');
    Route::post('/vendor-password-update/{vendorid}', [VendorController::class, 'passwordUpdate'])->name('vendor-password-update');
    Route::post('/vendor-skip-password/{vendorid}', [VendorController::class, 'skipPassword'])->name('vendor-skip-password');
    Route::get('/vendor-dashboard/{vendorid}', [VendorController::class, 'getVendorDetails'])->name('vendor-dashboard');
    Route::get('/vendor-contact-detail/{vendorid?}', function () {
        return view('VendorDashboard.vendor-contact-detail');
    })->name('vendor-contact-detail');
    Route::get('/vendor-curated-experience/{vendorid?}', [VendorController::class, 'getCuratedExperience'])->name('vendor-curated-experience');
    Route::post('/update-curated-experience/{vendorid?}', [VendorController::class, 'updateCuratedExperience'])->name('update.CuratedExperience');
    Route::get('/vendor-pricing/{vendorid?}', [VendorController::class, 'getVendorPricing'])->name('vendor-pricing');
    Route::post('/vendor-pricing-update/{vendorid}', [VendorController::class, 'updateVendorPricing'])->name('vendor-pricing-update');
    Route::get('/vendor-booking-utility/{vendorid?}', [VendorController::class, 'getBookingUtility'])->name('vendor-booking-utility');
    Route::post('/vendor-settings-booking-utility/{vendorid?}', [VendorController::class, 'updateVendorBookingUtility'])->name('vendor-settings-booking-utility');
    Route::post('/vendor-policy-update/{vendorid}', [VendorController::class, 'updateVendorPolicy'])->name('vendor-settings-policy');
    Route::get('/vendor-settings/{vendorid?}', [VendorController::class, 'getVendorSettings'])->name('vendor-settings');
    Route::get('/vendor-amenities/{vendorid?}', [VendorController::class, 'getVendorAmenities'])->name('vendor-amenities');
    Route::post('/vendor-settings-property-details/{vendorid?}', [VendorController::class, 'VendorSettingsPropertyDetails'])->name('vendor-settings-property-details');
    Route::post('/vendor-settings-booking/{vendorid?}', [VendorController::class, 'VendorSettingsBooking'])->name('vendor-settings-booking');
    Route::post('/vendor-social-media-update/{vendorid}', [VendorController::class, 'updateVendorSocialMedia'])->name('vendor-social-media-update');
    Route::post('/vendor-questionnaire-update/{vendorid}', [VendorController::class, 'updateQuestionnaireMedia'])->name('vendor-questionnaire-update');

    Route::get('/vendor-media-gallary/{vendorid?}', [VendorController::class, 'getVendorMediaGallery'])->name('vendor-media-gallary');
    Route::post('/vendor-media-delete/{vendorid?}', [VendorController::class, 'deleteVendorMedia'])->name('vendor-media-delete');
    Route::post('/vendor-logo-delete/{vendorid?}', [VendorController::class, 'deleteVendorLogo'])->name('vendor-logo-delete');

    Route::post('/vendor/upload-media/{vendorid?}', [VendorController::class, 'uploadMedia'])->name('vendor.upload_media');
    Route::post('/vendor/upload-logo/{vendorid?}', [VendorController::class, 'uploadVendorLogo'])->name('vendor.upload_vendor_logo');
    Route::post('/vendor/amenities/{vendorid?}', [VendorController::class, 'VendorAmenitiesSave'])->name('vendor.amenities.save');


    Route::get('/reviews-testimonial/{vendorid?}', [VendorController::class, 'getReviewsTestimonial'])->name('reviews-testimonial');

    Route::get('/inventory-management/{vendorid?}', [VendorController::class, 'inventoryManagement'])->name('inventory-management');
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::post('/manage_sub_regionsPost', [VendorController::class, 'manage_sub_regionsPost'])->name('manage_sub_regionsPost');
    Route::get('/manage-booking-utility-ajax/{vendorid?}', [VendorController::class, 'manageBookingUtilityAjax'])->name('manage.booking.utility.ajax');
    Route::post('/booking-utility-save/{vendorid?}', [VendorController::class, 'booking_utilitySave'])->name('booking_utility.save');
    Route::get('/getManageDates/{vendorid?}', [VendorController::class, 'getManageDates'])->name('get.Manage.Dates');
    Route::post('/ManageDatesDelete/{vendorid?}', [VendorController::class, 'ManageDatesDelete'])->name('dates.delete');
    Route::post('/publish_dates_update/{vendorid?}', [VendorController::class, 'publishDatesUpdate'])->name('publish_dates.update');
    Route::post('/addbookingdate/{vendorid?}', [VendorController::class, 'addbookingdate'])->name('addbookingdate.form');

    // Rooms
    Route::get('/vendor-manage-rooms/{vendorid?}', [VendorController::class, 'manageVendorRooms'])->name('manage.rooms');
    Route::post('/vendor-manage-rooms-save/{vendorid?}', [VendorController::class, 'manageVendorRoomsSave'])->name('manage.rooms.save');
    Route::delete('/vendor/rooms/{vendorid?}', [VendorController::class, 'deleteRoom'])->name('vendor.rooms.delete');

    Route::get('/vendor/transactions/{vendorid?}', [VendorController::class, 'orders'])->name('vendor-transactions');
    Route::get('vendor/transactions/{id}/{vendorid?}', [VendorController::class, 'orderDetail'])->name('vendor.orderDetail');
    Route::get('/vendor/inquiries/{vendorid?}', [VendorController::class, 'inquiries'])->name('vendor-inquiries');
    Route::get('/vendor/inquiries/{id}/{vendorid?}', [VendorController::class, 'inquiryDetail'])->name('vendor.inquiryDetail');
    Route::put('/inquiries/{id}/approve/{vendorid?}', [VendorController::class, 'inquiryApprove'])->name('inquiry.approve');
    Route::put('/inquiries/{id}/reject/{vendorid?}', [VendorController::class, 'inquiryReject'])->name('inquiry.reject');
    Route::get('/business-hours/{vendorid?}', [VendorSettingController::class, 'getBusinessHours'])->name('business-hours.index');
    Route::put('/business-hours/{vendorid?}', [VendorSettingController::class, 'updateBusinessHours'])->name('business-hours.update');

    Route::get('vendor-wines/{vendorid?}', [VendorWineController::class, 'index'])->name('vendor-wines.index');
    Route::get('vendor-wines/add/{vendorid?}', [VendorWineController::class, 'add'])->name('vendor-wines.add');
    Route::post('vendor-wines/store/{vendorid?}', [VendorWineController::class, 'store'])->name('vendor-wines.store');
    Route::get('vendor-wines/edit/{id}/{vendorid?}', [VendorWineController::class, 'edit'])->name('vendor-wines.edit');
    Route::put('vendor-wines/update/{id}/{vendorid?}', [VendorWineController::class, 'update'])->name('vendor-wines.update');
    Route::post('/vendor-wines/delete/{id}/{vendorid?}', [VendorWineController::class, 'delete'])->name('vendor-wines.destroy');
    Route::put('vendor-metadata/update/{vendorid?}', [VendorController::class, 'updateMetadata'])->name('vendor.metadata.update');
    Route::put('vendor/user-details-update/{vendorid?}', [VendorController::class, 'userDetailsUpdate'])->name('user.details.update');
    Route::get('vendor-faqs/{vendorid?}', [VendorController::class, 'vendorFaqs'])->name('vendor-faqs');
    Route::get('vendor/social-media/{vendorid?}', [VendorController::class, 'vendorSocialMedia'])->name('vendor-social-media');

    // Subscription Routes
    Route::get('/subscription/list/{vendorid?}', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscribe/{vendorid?}', [SubscriptionController::class, 'createCheckoutSession']);
    Route::get('/subscription/success/{vendorid?}', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/cancel/{vendorid?}', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/create-payment-intent/{vendorid?}', [SubscriptionController::class, 'createPaymentIntent'])->name('subscription.createPaymentIntent');
    Route::post('/subscription/update-status/{vendorid?}', [SubscriptionController::class, 'updateStatus'])->name('subscription.updateStatus');
    // Cancel subscription route
    Route::post('/subscription/cancel-subscription/{vendorid?}', [SubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel');
    Route::get('/subscription/get-subscription/{vendorid?}', [SubscriptionController::class, 'showSubscriptionDetail'])->name('subscription.detail');
    Route::get('/vendor/stripe-details/{vendorid?}', [VendorStripeDetailController::class, 'show'])->name('stripe.details.show');
    Route::post('/vendor/update-stripe-details/{vendorid?}', [VendorStripeDetailController::class, 'update'])->name('stripe.details.update');

    // Route::post('/subscribe', [SubscriptionController::class, 'createSubscription'])->name('create.subscription');
    // Route::post('/unsubscribe/{subscriptionId}', [SubscriptionController::class, 'cancelSubscription'])->name('cancel.subscription');
    // Route::post('/change-subscription', [SubscriptionController::class, 'changeSubscription'])->name('change.subscription'); // New route
    // Route::post('/winery-subscription', [SubscriptionController::class, 'winerySubscription'])->name('winery.subscription'); // New route
    // Route::get('/subscription/manage', [SubscriptionController::class, 'manage'])->name('subscription.manage');
    // Route::post('/subscription/change', [SubscriptionController::class, 'changeSubscription'])->name('subscription.change');
    // Route::post('/subscription/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel');


    // Winery Shop Routes
    Route::get('winery-shop/{vendorid?}', [WineryController::class, 'index'])->name('winery-shop.index');
    Route::get('winery-shop/products/{shopid}/{vendorid?}', [WineryController::class, 'products'])->name('winery-shop.products');
    Route::get('winery-shop/product-detail/{wineid}/{shopid}/{vendorid?}', [WineryController::class, 'detail'])->name('winery-shop.detail');
    Route::get('winery-shop/cart/{shopid}/{vendorid?}', [WineryCartController::class, 'index'])->name('cart.index');
    Route::post('winery-shop/cart/add/{shopid}/{vendorid?}', [WineryCartController::class, 'add'])->name('cart.add');
    Route::delete('winery-shop/cart/remove/{productId}/{shopid}/{vendorid?}', [WineryCartController::class, 'remove'])->name('cart.remove');
    Route::patch('winery-shop/cart/update/{productId}/{shopid}/{vendorid?}', [WineryCartController::class, 'update'])->name('cart.update');
    Route::get('winery-shop/checkout/{shopid}/{vendorid?}', [WineryCheckoutController::class, 'index'])->name('winery.checkout');
    Route::post('winery-shop/checkout/{shopid}/{vendorid?}', [WineryCheckoutController::class, 'checkout'])->name('winery.checkout-post');
    Route::post('winery-shop/reviews/store/{vendorid?}', [WineReviewController::class, 'store'])->name('winery.reviews.store');
    Route::get('winery-orders/shop/{vendorid?}', [WineryOrderController::class, 'shopOrders'])->name('winery.shop.orders');
    Route::get('winery-orders/shop/detail/{orderid}/{vendorid?}', [WineryOrderController::class, 'shopOrderDetail'])->name('winery.shop.order.detail');
    Route::post('winery-orders/shop/update-status/{orderid}/{vendorid?}', [WineryOrderController::class, 'shopOrderUpdateStatus'])->name('winery.shop.order.update-status');
    Route::get('winery-orders/vendor/{vendorid?}', [WineryOrderController::class, 'vendorOrders'])->name('winery.vendor.orders');
    Route::get('winery-orders/vendor/detail/{orderid}/{vendorid?}', [WineryOrderController::class, 'vendorOrderDetail'])->name('winery.vendor.order.detail');
    Route::post('/create-payment-intent/{vendorid?}', [PaymentController::class, 'createPaymentIntent'])->name('create-payment-intent');
    Route::post('/confirm-payment/{vendorid?}', [PaymentController::class, 'confirmPayment'])->name('confirm-payment');
    Route::post('/winery-shop/store-winery-shop-transaction-details/{vendorid?}', [WineryCheckoutController::class, 'storeTransactionDetails'])->name('store-winery-shop-transaction-details');
});
// ================= ADMIN ============== //

Route::get('/vendor-entity', [FrontendAdminController::class, 'vendorEntity']);
Route::get('/create-accommodation', [FrontendAdminController::class, 'createAccommodation'])->name('create-accommodation');
Route::post('/save-accommodation', [FrontendAdminController::class, 'saveAccommodation'])->name('save.accommodation');
Route::get('/create-excursion', [FrontendAdminController::class, 'creatExcursion'])->name('create-excursion');
Route::post('/save-excursion', [FrontendAdminController::class, 'saveExcursion'])->name('save.excursion');
Route::get('/create-winery', [FrontendAdminController::class, 'creatWinery'])->name('create-winery');
Route::post('/save-winery', [FrontendAdminController::class, 'saveWinery'])->name('save.winery');
Route::get('/create-licensed-vendor', [FrontendAdminController::class, 'createLicensedVendor'])->name('create-licensedvendor');
Route::post('/save-licensed-vendor', [FrontendAdminController::class, 'LicensedVendor'])->name('save.licensedvendor');
Route::get('/create-non-licensed-vendor', [FrontendAdminController::class, 'createNonLicensedVendor'])->name('create-nonlicensedvendor');
Route::post('/save-non-licensed-vendor', [FrontendAdminController::class, 'nonLicensedVendor'])->name('save.nonLicensedVendor');


Route::get('/filter/search', [FrontendController::class, 'filterSearch'])->name('filter.search');
// Route::get('/vender-type/{type?}', [FrontendController::class, 'vendorType'])->name('vendor.type');
Route::post('/vender-type/list/{type?}', [FrontendController::class, 'getVendorTypeList'])->name('vendor.type.list');

Route::get('/accommodations', [FrontendController::class, 'vendorType'])->name('accommodations');
Route::get('/excursion', [FrontendController::class, 'vendorType'])->name('excursion-listing');
Route::get('/wineries', [FrontendController::class, 'vendorType'])->name('wineries-listing');
Route::get('/licensed', [FrontendController::class, 'vendorType'])->name('licensed');
Route::get('/non-licensed', [FrontendController::class, 'vendorType'])->name('non-licensed');


Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/filter/search', [AdminVendorController::class, 'filterSearch'])->name('admin.vendors.search');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/vendors/show/{id}', [AdminVendorController::class, 'show'])->name('admin.vendors.show');
    Route::get('/admin/wine-catalogues', [AdminWineCatalogueController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/vendors/account-status/{id}', [AdminVendorController::class, 'accountStatus'])->name('admin.vendor.account.status');
    Route::put('admin/vendors/update-account-status/{id}', [AdminVendorController::class, 'updateAccountStatus'])->name('admin.vendor.update.account.status');
    Route::get('/admin/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');
    Route::get('/admin/vendors/create/{type?}', [AdminVendorController::class, 'create'])->name('admin.vendors.create');
    Route::post('/admin/vendors/store', [AdminVendorController::class, 'store'])->name('admin.vendors.store');
    Route::get('/admin/vendors/edit/{id}', [AdminVendorController::class, 'edit'])->name('admin.vendors.edit');
    Route::put('/admin/vendors/update/{id}', [AdminVendorController::class, 'update'])->name('admin.vendors.update');
    Route::delete('/admin/vendors/destroy/{id}', [AdminVendorController::class, 'destroy'])->name('admin.vendors.destroy');
    Route::get('/get-user-by-email', [AdminVendorController::class, 'getUserByEmail']);
    Route::get('/get-email-suggestions', [AdminVendorController::class, 'getEmailSuggestions']);

    // FAQs Route
    Route::get('/admin/faqs/data', [AdminFaqController::class, 'getData'])->name('admin.faqs.data');
    Route::post('/admin/faqs/check-duplicate', [AdminFaqController::class, 'checkDuplicate'])->name('admin.faqs.check-duplicate');
    Route::post('/admin/faqs/{id}/toggle-status', [AdminFaqController::class, 'toggleStatus'])->name('admin.faqs.toggle-status');
    Route::get('/admin/faqs/create-section', [AdminFaqController::class, 'createSection'])->name('admin.faqs.create-section');
    Route::get('/admin/faqs/edit-section/{id}', [AdminFaqController::class, 'editSection'])->name('admin.faqs.edit-section');
    Route::post('/admin/faqs/store-section', [AdminFaqController::class, 'storeSection'])->name('admin.faqs.store-section');
    Route::post('/admin/faqs/update-section', [AdminFaqController::class, 'updateSection'])->name('admin.faqs.update-section');
    Route::get('/admin/faqs/create-question/{section_id}', [AdminFaqController::class, 'createQuestion'])->name('admin.faqs.create-question');
    Route::post('/admin/faqs/store-question/{section_id}', [AdminFaqController::class, 'storeQuestion'])->name('admin.faqs.store-question');
    Route::post('/admin/faqs/update-question/{section_id}', [AdminFaqController::class, 'updateQuestion'])->name('admin.faqs.update-question');
    Route::delete('/admin/faqs/questions/{id}', [AdminFaqController::class, 'destroyQuestion'])->name('admin.faqs.delete-question');
    Route::resource('/admin/faqs', AdminFaqController::class)->names('admin.faqs');

    // Common Routes
    // Route::prefix('admin/{entity}')->group(function () {
    //     Route::get('/', function ($entity) {
    //         $customFields = getCustomFields($entity); // Define custom fields for each entity
    //         $controller = new AdminCommonController($entity, $customFields);
    //         return $controller->index();
    //     })->name('admin.entity.index');

    //     Route::get('/create', function ($entity) {
    //         $customFields = getCustomFields($entity);
    //         $controller = new AdminCommonController($entity, $customFields);
    //         return $controller->create();
    //     })->name('admin.entity.create');

    //     Route::post('/', function (Request $request, $entity) {
    //         $customFields = getCustomFields($entity);
    //         $controller = new AdminCommonController($entity, $customFields);
    //         return $controller->store($request);
    //     })->name('admin.entity.store');

    //     Route::get('/{id}/edit', function ($entity, $id) {
    //         $customFields = getCustomFields($entity);
    //         $controller = new AdminCommonController($entity, $customFields);
    //         return $controller->edit($id);
    //     })->name('admin.entity.edit');

    //     Route::put('/{id}', function (Request $request, $entity, $id) {
    //         $customFields = getCustomFields($entity);
    //         $controller = new AdminCommonController($entity, $customFields);
    //         return $controller->update($request, $id);
    //     })->name('admin.entity.update');
    // });
    Route::get('/admin/get-users/{id}', [AdminUserEmailController::class, 'getUsers'])->name('admin.get-users');
    Route::post('/admin/update-user-email', [AdminUserEmailController::class, 'updateUserEmail'])->name('admin.update-user-email');
    Route::resource('/admin/users', AdminUserController::class)->names('admin.users');
    Route::get('/admin/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews');
    Route::get('/admin/reviews/view/{id}', [AdminReviewController::class, 'show'])->name('admin.reviews.show');
    Route::post('admin/reviews/{id}/approve', [AdminReviewController::class, 'approveReview'])->name('admin.reviews.approve');
    Route::post('admin/reviews/{id}/decline', [AdminReviewController::class, 'declineReview'])->name('admin.reviews.decline');
});

Route::get('/get-subregions/{regionId}', [RegionController::class, 'getSubRegions']);
Route::get('/get-subcategories/{categoryId}', [CategoryController::class, 'getSubcategories'])->name('getSubcategories');
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handleWebhook']);


// Route::get('/migration-vendor', [MigrationController::class, 'migrateVendorData']);
