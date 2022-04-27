<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// Tags...
Route::get('/tags', TagController::class);
