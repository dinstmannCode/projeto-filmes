<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Movies\Http\Controllers\MovieController;

Route::get('/', [MovieController::class, 'index']);
