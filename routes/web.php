<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API is running. Please use /api/login for authentication.']);
});

Route::get('/home', function () {
    return redirect('/api/admin');
});
