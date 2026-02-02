<?php

use plugin\swagger\app\controller\IndexController;
use Webman\Route;


Route::get('/app/swagger', [IndexController::class, 'index']);
Route::get('/app/swagger/openapi.json', [IndexController::class, 'openapi']);
Route::any('/app/swagger/login', [IndexController::class, 'login']);