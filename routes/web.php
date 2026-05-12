<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/catalog', 'catalog')->name('catalog');
Route::view('/contacts', 'contacts')->name('contacts');
