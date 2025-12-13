<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        // Share legacy contact info (if available) with all views so legacy header/footer display correctly
        View::composer('*', function ($view) {
            $contact_email = null;
            $contact_phone = null;
            if (Schema::hasTable('tblcontactusinfo')) {
                // defensively fetch the first row and map known column names if present
                try {
                    $c = DB::table('tblcontactusinfo')->first();
                } catch (\Exception $e) {
                    $c = null;
                }
                if ($c) {
                    // legacy columns may vary; try common variants
                    $contact_email = $c->EmailId ?? $c->email ?? $c->Email ?? null;
                    $contact_phone = $c->ContactNumber ?? $c->ContactNo ?? $c->phone ?? $c->Phone ?? null;
                }
            }
            $view->with('contact_email', $contact_email)->with('contact_phone', $contact_phone);
            
            if ($this->app->environment('production')) {
            URL::forceScheme('https');}
        });
    }
}
