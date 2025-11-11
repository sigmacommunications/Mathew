<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\JokeController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\VideoUploadController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ReelsUploadController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\user\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


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



Route::get('/', [FrontendController::class, 'Index'])->name('home');

Route::get('about-us', [FrontendController::class, 'AboutUs'])->name('about-us');

Route::post('getintouch', [FrontendController::class, 'GetInTouch'])->name('getintouch');

Route::get('blog', [FrontendController::class, 'Blog'])->name('blog');

Route::get('contact', [FrontendController::class, 'Contact'])->name('contact-us');

Route::get('privacy-policy', [FrontendController::class, 'PrivacyPolicy'])->name('privacypolicy');

Route::get('terms-and-conditions', [FrontendController::class, 'TermsAndConditions'])->name('termandcondition');

Route::get('event', [FrontendController::class, 'Event'])->name('event');

Route::post('event', [FrontendController::class, 'EventRegistration'])->name('event.registration');

Route::get('studymaterial', [FrontendController::class, 'StudyMaterial'])->name('studymaterial');

Route::get('studymaterial/view/{id}', [FrontendController::class, 'StudyMaterialView'])->name('studymaterial.view');


// Route::get('/', [\App\Http\Controllers\ProfileController::class, 'welcome'])->name('welcome');
// Route::get('/about-us', [\App\Http\Controllers\ProfileController::class, 'about_us'])->name('about-us');
Route::get('/services', [\App\Http\Controllers\ProfileController::class, 'services'])->name('services');
Route::get('/video-series', [\App\Http\Controllers\ProfileController::class, 'video_series'])->name('video-series');
Route::post('/videos/{videoId}/increment-view', [ProfileController::class, 'incrementViews'])->name('videos.incrementViews');
Route::get('/video-reels', [\App\Http\Controllers\ProfileController::class, 'video_reels'])->name('video-reels');
Route::get('/transcript-summaries', [\App\Http\Controllers\ProfileController::class, 'transcripts'])->name('transcripts');
Route::get('/all/transcript', [\App\Http\Controllers\ProfileController::class, 'AllTranscript'])->name('all.transcript');
Route::get('/transcripts-inner', [\App\Http\Controllers\ProfileController::class, 'transcripts_inner'])->name('transcripts-inner');
Route::get('/blogs', [\App\Http\Controllers\ProfileController::class, 'blogs'])->name('blogs');
// Route::get('/contact-us', [\App\Http\Controllers\ProfileController::class, 'contact_us'])->name('contact-us');
Route::post('/contact/store', [\App\Http\Controllers\ProfileController::class, 'ContactStore'])->name('store.contacts');
Route::get('/inner/blogs/{id}', [\App\Http\Controllers\ProfileController::class, 'InnerBlogs'])->name('inner.blogs');
Route::get('/render-pdf/{id}', [\App\Http\Controllers\ProfileController::class, 'renders'])->name('renderPDF');
Route::get('/pay/{id}', [\App\Http\Controllers\ProfileController::class, 'payNow'])->name('pay.now');
Route::get('/product-buy-payment', [\App\Http\Controllers\ProfileController::class, 'ProductBuyPayment'])->name('product.buy.payment');
Route::post('/order-post', [\App\Http\Controllers\user\SubscriptionController::class, 'orderPost'])->name('order-post');
Route::get('/product/buy/now/{id}', [\App\Http\Controllers\ProfileController::class, 'productBuyNow'])->name('product.buy.now');
// Email subscription
Route::post('/news/letter', [\App\Http\Controllers\ProfileController::class, 'NewsLetter'])->name('news.letter');
Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/reply', [\App\Http\Controllers\CommentController::class, 'reply'])->name('comments.reply');

Route::group(['prefix' => 'admin/filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('package', PackageController::class);
    Route::resource('jokes', JokeController::class);
    Route::resource('files', FileUploadController::class);
    Route::resource('videos', VideoUploadController::class);
    Route::resource('reels', ReelsUploadController::class);
    Route::resource('events', EventController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('blogs', BlogsController::class);
    Route::resource('categories', CategoryController::class);

    Route::post('/file/category/update', [FileUploadController::class, 'FileCatUpdate'])->name('file.category.update');
    Route::get('/file/category/delete/{id}', [FileUploadController::class, 'FileCatDelete'])->name('file.category.upload.delete');


    Route::post('/jokes/csv/upload', [JokeController::class, 'uploadCSV'])->name('jokes.csv.upload');
    Route::get('/change_password', [\App\Http\Controllers\Admin\DashboardController::class, 'change_password'])->name('change_password');
    Route::post('change-password', [\App\Http\Controllers\Admin\DashboardController::class, 'changPasswordStore'])->name('change.password');
    // user route
    Route::resource('users', UsersController::class);

    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/profile/{id}', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin-profile-update');
    Route::delete('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('admin.profile.destroy');
    Route::get('/mark-notification/{notification}', [\App\Http\Controllers\Admin\DashboardController::class, 'markAsRead'])->name('admin.mark.as.read');

    // Comments
    Route::get('/comments', [\App\Http\Controllers\CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/delete/{id}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/approve-comment/{id}', [\App\Http\Controllers\CommentController::class, 'approveComment'])->name('comments.approve');
    Route::post('/cancel-comment/{id}', [\App\Http\Controllers\CommentController::class, 'cancelComment'])->name('comments.cancel');

    Route::get('/general-settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/general-settings', [\App\Http\Controllers\Admin\SettingController::class, 'Update'])->name('settings.update');

    // Route::post('/product/buy', [\App\Http\Controllers\user\SubscriptionController::class, 'buyNow'])->name('user.buy.now');
});
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'role:user']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('user.dashboard');

    Route::get('/pdf-preview/{path}', [DashboardController::class, 'PDFShow'])->name('pdf.preview');

    Route::get('/profile', [\App\Http\Controllers\user\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile/{id}', [\App\Http\Controllers\user\ProfileController::class, 'update'])->name('user-profile-update');
    Route::delete('/profile', [\App\Http\Controllers\user\ProfileController::class, 'destroy'])->name('user.profile.destroy');

    Route::get('user/change_password', [\App\Http\Controllers\user\DashboardController::class, 'change_password'])->name('user.change_password');
    Route::post('user/change-password', [\App\Http\Controllers\user\DashboardController::class, 'changPasswordStore'])->name('user.change.password');
    Route::get('jokes/list', [\App\Http\Controllers\user\DashboardController::class, 'user_joke'])->name('user.jokes');
    Route::get('user/jokes/{id}', [\App\Http\Controllers\user\DashboardController::class, 'show'])->name('user.jokes.details');
    Route::get('mark-joke-as-read/{id}', [\App\Http\Controllers\user\DashboardController::class, 'markAsRead'])->name('mark-joke-as-read');

    Route::get('/purchase-package/create', [\App\Http\Controllers\user\DashboardController::class, 'purchasePackageCreate'])->name('user.purchase.package.create');
    Route::post('/purchase-package', [\App\Http\Controllers\user\DashboardController::class, 'purchasePackage'])->name('user.purchase.package');

    Route::post('/stripe', [\App\Http\Controllers\user\SubscriptionController::class, 'stripePost'])->name('stripe.post');
    Route::get('/convert', [\App\Http\Controllers\user\CurrencyController::class, 'convertCurrencyForUser']);
    Route::get('/mark-notification/{notification}', [\App\Http\Controllers\user\DashboardController::class, 'markAsRead'])->name('user.mark.as.read');

    Route::get('/transcript', [\App\Http\Controllers\user\DashboardController::class, 'Transcript'])->name('user.transcript');
    Route::get('/all/transcript', [\App\Http\Controllers\user\DashboardController::class, 'AllTranscript'])->name('user.all.transcript');


    Route::get('/video', [\App\Http\Controllers\user\DashboardController::class, 'Video'])->name('user.video');
    Route::get('/product/check-purchase/{id}', [\App\Http\Controllers\user\DashboardController::class, 'productBuy'])->name('checkPurchaseStatus');
    Route::get('/file/{fileId}', [\App\Http\Controllers\user\DashboardController::class, 'viewFile'])->name('viewFile');
    Route::post('/product/buy', [\App\Http\Controllers\user\SubscriptionController::class, 'buyNow'])->name('user.buy.now');

    Route::get('/paypal/success', [\App\Http\Controllers\user\SubscriptionController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel', [\App\Http\Controllers\user\SubscriptionController::class, 'paypalCancel'])->name('paypal.cancel');



    Route::post('/pay', [\App\Http\Controllers\user\PaymentController::class, 'pay'])->name('paypal.payment');
    Route::get('success', [\App\Http\Controllers\user\PaymentController::class, 'success']);
    Route::get('error', [\App\Http\Controllers\user\PaymentController::class, 'error']);
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/dashboard-redirect', function () {
    $user = auth()->user();

    \Log::info("User roles: ", $user->roles->pluck('name')->toArray());

    if ($user->hasRole('admin') && !$user->hasRole('user')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }

    return redirect('/');
})->middleware(['auth'])->name('dashboard.redirect');


require __DIR__ . '/auth.php';
