<?php

use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminGoodController;
use App\Http\Controllers\Admin\AdminGoodInController;
use App\Http\Controllers\Admin\AdminGoodOutController;
use App\Http\Controllers\Admin\AdminLaptopController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminRepairController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerServiceController;
use App\Http\Controllers\General\GeneralChatController;
use App\Http\Controllers\General\GeneralFrequentlyAskedQuestionController;
use App\Http\Controllers\General\GeneralHomeController;
use App\Http\Controllers\General\GeneralLoginController;
use App\Http\Controllers\General\GeneralRegisterController;
use App\Http\Controllers\General\GeneralServiceController;
use App\Http\Controllers\Technician\TechnicianBrandController;
use App\Http\Controllers\Technician\TechnicianDashboardController;
use App\Http\Controllers\Technician\TechnicianLaptopController;
use App\Http\Controllers\Technician\TechnicianProfileController;
use App\Http\Controllers\Technician\TechnicianRepairController;
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

// General Home
Route::get('/', [GeneralHomeController::class, 'index'])->name('general.home');
Route::get('/layanan', [GeneralServiceController::class, 'index'])->name('general.service');
Route::get('/service/invoice/{receipt_code}', [GeneralServiceController::class, 'export'])->name('general.invoice.export');
Route::get('/live-chat', [GeneralChatController::class, 'index'])->name('general.live-chat');
Route::post('/live-chat/send', [GeneralChatController::class, 'store'])->name('general.live-chat.send');
Route::get('/live-chat/messages', [GeneralChatController::class, 'loadMessages'])->name('general.live-chat.messages');
Route::get('/faq', [GeneralFrequentlyAskedQuestionController::class, 'index'])->name('general.faq');

Route::middleware('guest')->group(function () {
    Route::get('/login', [GeneralLoginController::class, 'index'])->name('general.login');
    Route::post('/login', [GeneralLoginController::class, 'login'])->name('general.login.post');
});
Route::post('/keluar', [GeneralLoginController::class, 'logout'])->name('general.logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('admin.home');

    Route::get('/dashboard-admin/profil', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/dashboard-admin/profil', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/dashboard-admin/merk-perangkat', [AdminBrandController::class, 'index'])->name('admin.brand');
    Route::post('/dashboard-admin/merk-perangkat/tambah', [AdminBrandController::class, 'store'])->name('admin.brand.store');
    Route::put('/dashboard-admin/merk-perangkat/{brand}/ubah', [AdminBrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('/dashboard-admin/merk-perangkat/{brand}/hapus', [AdminBrandController::class, 'delete'])->name('admin.brand.delete');

    Route::get('/dashboard-admin/laptop', [AdminLaptopController::class, 'index'])->name('admin.laptop');
    Route::post('/dashboard-admin/laptop/tambah', [AdminLaptopController::class, 'store'])->name('admin.laptop.store');
    Route::put('/dashboard-admin/laptop/{laptop}/ubah', [AdminLaptopController::class, 'update'])->name('admin.laptop.update');
    Route::delete('/dashboard-admin/laptop/{laptop}/hapus', [AdminLaptopController::class, 'delete'])->name('admin.laptop.delete');

    Route::get('/dashboard-admin/layanan', [AdminServiceController::class, 'index'])->name('admin.service');
    Route::post('/dashboard-admin/layanan/tambah', [AdminServiceController::class, 'store'])->name('admin.service.store');
    Route::put('/dashboard-admin/layanan/{service}/ubah', [AdminServiceController::class, 'update'])->name('admin.service.update');
    Route::delete('/dashboard-admin/layanan/{service}/hapus', [AdminServiceController::class, 'delete'])->name('admin.service.delete');

    Route::get('/dashboard-admin/perbaikan', [AdminRepairController::class, 'index'])->name('admin.repair');
    Route::get('/dashboard-admin/perbaikan/export', [AdminRepairController::class, 'export'])->name('admin.repair.export');
    Route::post('/dashboard-admin/perbaikan/tambah', [AdminRepairController::class, 'store'])->name('admin.repair.store');
    Route::get('/dashboard-admin/perbaikan/{repair}', [AdminRepairController::class, 'show'])->name('admin.repair.show');
    Route::put('/dashboard-admin/perbaikan/{repair}', [AdminRepairController::class, 'update'])
        ->name('admin.repair.update');


    Route::get('/dashboard-admin/pengguna', [AdminUserController::class, 'index'])->name('admin.user');
    Route::post('/dashboard-admin/pengguna/tambah', [AdminUserController::class, 'store'])->name('admin.user.store');
    Route::put('/dashboard-admin/pengguna/{user}/ubah', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/dashboard-admin/pengguna/{user}/hapus', [AdminUserController::class, 'delete'])->name('admin.user.delete');

    Route::get('/dashboard-admin/inventarisasi', [AdminGoodController::class, 'index'])->name('admin.goods');
    Route::post('/dashboard-admin/inventarisasi/tambah', [AdminGoodController::class, 'store'])->name('admin.goods.store');
    Route::put('/dashboard-admin/inventarisasi/{good}/ubah', [AdminGoodController::class, 'update'])->name('admin.goods.update');
    Route::delete('/dashboard-admin/inventarisasi/{good}/hapus', [AdminGoodController::class, 'delete'])->name('admin.goods.delete');

    Route::get('/dashboard-admin/kategori-barang', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::post('/dashboard-admin/kategori-barang/tambah', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/dashboard-admin/kategori-barang/{category}/ubah', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/dashboard-admin/kategori-barang/{category}/hapus', [AdminCategoryController::class, 'delete'])->name('admin.categories.delete');

    Route::get('/dashboard-admin/barang-masuk', [AdminGoodInController::class, 'index'])->name('admin.goodins.index');
    Route::post('/dashboard-admin/barang-masuk/tambah', [AdminGoodInController::class, 'store'])->name('admin.goodins.store');
    Route::delete('/dashboard-admin/barang-masuk/{goodin}/hapus', [AdminGoodInController::class, 'destroy'])->name('admin.goodins.destroy');
    Route::get('/good-in/export/pdf', [AdminGoodInController::class, 'exportPdf'])->name('admin.goodins.export.pdf');

    Route::get('/dashboard-admin/barang-keluar', [AdminGoodOutController::class, 'index'])->name('admin.goodouts.index');
    Route::post('/dashboard-admin/barang-keluar/tambah', [AdminGoodOutController::class, 'store'])->name('admin.goodouts.store');
    Route::delete('/dashboard-admin/barang-keluar/{goodout}/hapus', [AdminGoodOutController::class, 'destroy'])->name('admin.goodouts.destroy');
    Route::get('/good-out/export/pdf', [AdminGoodOutController::class, 'exportPdf'])->name('admin.goodouts.export.pdf');

    // Admin Chat Routes
    Route::get('/dashboard-admin/chat', [AdminChatController::class, 'index'])->name('admin.chat');
    Route::get('/dashboard-admin/chat/session/{sessionId}', [AdminChatController::class, 'getSession'])->name('admin.chat.session');
    Route::get('/dashboard-admin/chat/unread-count', [AdminChatController::class, 'getUnreadCount'])->name('admin.chat.unread-count');
    Route::post('/dashboard-admin/chat/send', [AdminChatController::class, 'store'])->name('admin.chat.send');
    Route::delete('/dashboard-admin/chat/clear', [AdminChatController::class, 'clear'])->name('admin.chat.clear');
});

Route::middleware(['auth', 'role:technician'])->group(function () {
    Route::get('/dashboard-teknisi', [TechnicianDashboardController::class, 'index'])->name('technician.home');

    Route::get('/dashboard-teknisi/profil', [TechnicianProfileController::class, 'index'])->name('technician.profile');
    Route::put('/dashboard-teknisi/profil', [TechnicianProfileController::class, 'update'])->name('technician.profile.update');

    Route::get('/dashboard-teknisi/laptop', [TechnicianLaptopController::class, 'index'])->name('technician.laptop');
    Route::post('/dashboard-teknisi/laptop/tambah', [TechnicianLaptopController::class, 'store'])->name('technician.laptop.store');
    Route::put('/dashboard-teknisi/laptop/{laptop}/ubah', [TechnicianLaptopController::class, 'update'])->name('technician.laptop.update');
    Route::delete('/dashboard-teknisi/laptop/{laptop}/hapus', [TechnicianLaptopController::class, 'delete'])->name('technician.laptop.delete');

    Route::get('/dashboard-teknisi/merk-perangkat', [TechnicianBrandController::class, 'index'])->name('technician.brand');
    Route::post('/dashboard-teknisi/merk-perangkat/tambah', [TechnicianBrandController::class, 'store'])->name('technician.brand.store');
    Route::put('/dashboard-teknisi/merk-perangkat/{brand}/ubah', [TechnicianBrandController::class, 'update'])->name('technician.brand.update');
    Route::delete('/dashboard-teknisi/merk-perangkat/{brand}/hapus', [TechnicianBrandController::class, 'delete'])->name('technician.brand.delete');

    Route::get('/dashboard-teknisi/perbaikan', [TechnicianRepairController::class, 'index'])->name('technician.repair');
    Route::get('/dashboard-teknisi/perbaikan/export', [TechnicianRepairController::class, 'export'])->name('technician.repair.export');
    Route::get('/dashboard-teknisi/perbaikan/{repair}', [TechnicianRepairController::class, 'show'])->name('technician.repair.show');

    Route::put('/dashboard-teknisi/perbaikan/{repair}', [TechnicianRepairController::class, 'update'])
        ->name('technician.repair.update');
});
