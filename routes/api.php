<?php

use ProcessMaker\Package\DemoDos\Http\Controllers\DemoDosController;

Route::group(['middleware' => ['auth:api', 'bindings']], function () {
    Route::get('admin/demo-dos/fetch', [DemoDosController::class, 'fetch'])
        ->name('package.skeleton.fetch');
    Route::apiResource('admin/demo-dos', DemoDosController::class);
});
