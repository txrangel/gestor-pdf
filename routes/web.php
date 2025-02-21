<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

require __DIR__.'/auth.php';
