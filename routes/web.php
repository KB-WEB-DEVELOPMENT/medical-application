<?php

use Illuminate\Foundation\Application;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use Auth\Application\Http\Controllers\LoginController;
use Claim\Submission\Application\Http\Controllers\SubmissionClaimController;
use Claim\Billing\Application\Http\Controllers\BillingController;

use Claim\Submission\Domain\Models\Claim;
use Claim\Billing\Domain\Models\Payment;

/*

Note: Default Laravel 12 route. Not needed in the project.

Route::get('/', function () {
    return view('welcome');
});

*/

Route::controller(LoginController::class)->group(function () {
    Route::get('/login','login');
    Route::post('/dashboard','dashboard')->middleware('auth');
    Route::post('/logout','logout')->middleware('auth');
});

Route::controller(SubmissionClaimController::class)->group([
        'prefix' => '/employee',
        ], function () {
            Route::get('/dashboard/claims','index')->middleware('auth')->can('viewAny',Claim::class);
            Route::get('/claim/create','create')->middleware('auth')->can('create',Claim::class);
            Route::post('/claim/store','store')->middleware('auth')->can('store',Claim::class);
            Route::get('/claim/edit/{claim_id}','edit')->where('claim_id','[0-9]+')->middleware('auth')->can('edit',Claim::class);
            Route::post('/claim/update','update')->middleware('auth')->can('update',Claim::class);
            Route::get('/claim/delete/{claim_id}','delete')->where('claim_id','[0-9]+')->middleware('auth')->can('delete',Claim::class);
            Route::get('/claim/filter/provider/{npi_number}','byProvider')->whereNumber('npi_number')->middleware('auth')->can('viewAny',Claim::class);
            Route::get('/claim/filter/claim_status/{type}','byStatus')->whereIn('type',
                ['PENDING_REVIEW','REVIEWER_APPROVED','CORRECTION_NEEDED','BILLER_CORRECTION_NEEDED',
                'BILLER_APPROVED'])->middleware('auth')->can('viewAny',Claim::class);            
            Route::get('/claim/filter/dates/{from?}/{to?}','between')->middleware('auth')->can('viewAny',Claim::class);
            Route::get('/claim/filter/patient/{ssn}','byPatient')->middleware('auth')->can('viewAny',Claim::class);
});

Route::controller(BillingController::class)->group([
        'prefix' => '/admin',
        ], function () {
            Route::get('/dashboard/payments','index')->middleware('viewAny',Payment::class);
            Route::get('/payments/amount_billed/{claim_id}/{payment_type_id}','amountBilled')->where('claim_id','[0-9]+')->whereIn('payment_type_id',[1,2])->middleware('viewAny',Payment::class);
            Route::get('/payments/filter/amount_range_payment_type/{minAmount?}/{maxAmount?}/{payment_type_id?}','byAmountRangeAndOrPaymentType')->where('minAmount','[0-9]+')->where('maxAmount','[0-9]+')->whereIn('payment_type_id',[1,2])->middleware('viewAny',Payment::class);
            Route::get('/payments/filter/dates/{from?}/{to?}','byDateInterval')->middleware('viewAny',Payment::class);
});