<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// إرسال تعليق جديد
Route::post('/comments', [HomeController::class, 'storeComment'])->name('comments.store');

// مسارات إضافية لإدارة التعليقات (اختيارية)
Route::get('/admin/comments', [HomeController::class, 'adminComments'])->name('admin.comments');
Route::post('/admin/comments/{comment}/approve', [HomeController::class, 'approveComment'])->name('admin.comments.approve');
Route::delete('/admin/comments/{comment}', [HomeController::class, 'deleteComment'])->name('admin.comments.delete');