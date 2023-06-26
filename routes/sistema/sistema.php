<?php

Route::get('/', function () {
    return redirect(route('backend.index'));
})->name('sistema.index');
