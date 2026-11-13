<?php

use ProcessMaker\Package\DemoDos\Http\Controllers\DemoDosController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/demo-dos', [DemoDosController::class, 'index'])->name('package.skeleton.index');
    Route::get('demo-dos', [DemoDosController::class, 'index'])->name('package.skeleton.tab.index');
});
