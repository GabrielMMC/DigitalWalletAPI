<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\BankAccount;
use App\Models\Card;
use App\Models\Recharge;
use App\Models\Recipient;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdrawal;
use App\Observers\AddressObserver;
use App\Observers\BankAccountObserver;
use App\Observers\CardObserver;
use App\Observers\RechargeObserver;
use App\Observers\RecipientObserver;
use App\Observers\TransferObserver;
use App\Observers\UserObserver;
use App\Observers\WithdrawalObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Address::observe(AddressObserver::class);
        Card::observe(CardObserver::class);
        Recharge::observe(RechargeObserver::class);
        Recipient::observe(RecipientObserver::class);
        Transfer::observe(TransferObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
        BankAccount::observe(BankAccountObserver::class);
    }
}
