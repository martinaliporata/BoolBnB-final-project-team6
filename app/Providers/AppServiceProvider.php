<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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
    public function boot()
    {
        // Usa il View Composer per passare $unreadMessagesCount globalmente
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Conta i messaggi non letti dell'utente autenticato
                $unreadMessagesCount = Message::whereHas('apartment', function ($query) {
                    $query->where('user_id', Auth::id());
                })->where('is_read', false)->count();

                // Condividi la variabile con tutte le viste
                $view->with('unreadMessagesCount', $unreadMessagesCount);
            }
        });
    }
}
