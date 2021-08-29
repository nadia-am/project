<?php

Route::middleware(['auth','verified'])->prefix('admin')->group( function (){
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::get('/twofactor', [ProfileController::class, 'manageTwoFactor'])->name('profile.2fa');
    Route::post('/twofactor', [ProfileController::class, 'manageTwoFactorPost'])->name('manage.profile.2fa');
    Route::get('/twofactor/phone', [ProfileController::class, 'getPhoneVerify'])->name('phone.verify');
    Route::post('/twofactor/phone', [ProfileController::class, 'postPhoneVerify'])->name('post.phone.verify');
});
