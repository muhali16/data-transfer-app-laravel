<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(\route('files.index'));
});

Route::resource('/files', \App\Http\Controllers\FileController::class);
