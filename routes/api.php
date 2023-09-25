<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([
        'prefix' => 'v1',
        'as' => 'api.'
], function () {
    Route::get(
            uri: '/conta',
            action: App\Http\Controllers\Api\V1\Account\ShowController::class)
            ->name(
                name:'conta.busca'
            );

    Route::post(
        uri: '/conta',
        action: App\Http\Controllers\Api\V1\Account\CreateController::class
    )->name(
        name: 'conta.criar'
    );

    Route::post(
        uri: '/transacao',
        action: App\Http\Controllers\Api\V1\Transaction\CreateController::class
    )->name(
        name: 'transacao.criar'
    );
});
