<?php

use App\Helpers\DuitkuTransaction;
use App\Http\Middleware\CustomerAuthentication;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Register;
use App\Livewire\Pages\Auth\Profile;
use App\Livewire\Pages\Order\ListOrders;
use App\Livewire\Pages\Order\ViewOrder;
use App\Livewire\Pages\Service\ViewService;
use App\Livewire\Pages\ServiceCategory\ListServiceCategories;
use App\Livewire\Pages\Transaction\Checkout;
use App\Livewire\Pages\Transaction\ListTransactions;
use App\Livewire\Pages\Transaction\Thankyou;
use App\Livewire\Pages\Transaction\ViewTransaction;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/universal-login', function () {
    return redirect()->route('frontpage.auth.login');
})
    ->name('login');

Route::group(['as' => 'frontpage.'], function () {

    Route::withoutMiddleware([CustomerAuthentication::class])
        ->group(function () {
            Route::get('/', Home::class)->name('home');

            Route::group(['as' => 'auth.', 'prefix' => '/auth'], function () {
                Route::get('/login',    Login::class)->name('login');
                Route::get('/register', Register::class)->name('register');

                Route::post('/logout', function () {
                    Auth::logout();
                    return redirect()->route('frontpage.auth.login');
                })
                    ->name('logout');
            });

            Route::group(['as' => 'duitku.', 'prefix' => 'duitku'], function () {
                Route::get('/callback', fn () => (new DuitkuTransaction())->callback())->name('callback');
            });

            Route::group(['as' => 'service-category.', 'prefix' => 'service-category'], function () {
                Route::get('/{code}', ListServiceCategories::class)->name('list');
            });

            Route::group(['as' => 'service.', 'prefix' => 'service'], function () {
                Route::get('/{code}', ViewService::class)->name('view');
            });
        });


    Route::middleware([CustomerAuthentication::class])
        ->group(function () {
            Route::group(['as' => 'transaction.', 'prefix' => 'transaction'], function () {
                Route::get('/',                 ListTransactions::class)->name('list');
                Route::get('/{invoice_number}', ViewTransaction::class)->name('view');
            });

            Route::group(['as' => 'order.', 'prefix' => 'order'], function () {
                Route::get('/',                 ListOrders::class)->name('list');
                Route::get('/{order_number}', ViewOrder::class)->name('view');
            });

            Route::get('/profile', Profile::class)->name('profile');
            Route::get('/checkout', Checkout::class)->name('checkout');
            Route::get('/thankyou', Thankyou::class)->name('thankyou');
        });


    Route::get('/order-report/download/{order}', function (Order $order) {
        $pdf = Pdf::loadView('pdf.report', compact('order'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('report.pdf');
    })
        ->name('order-report.download');
});
