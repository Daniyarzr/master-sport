<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
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
        View::composer('*', function ($view): void {
            static $shared = null;

            if ($shared === null) {
                if (!Schema::hasTable('contacts')) {
                    $shared = [
                        'siteContacts' => collect(),
                        'siteContactsByType' => collect(),
                        'siteContactsByKey' => collect(),
                        'primaryPhoneContact' => null,
                        'headerToplineLeft' => 'Master Sport',
                        'headerToplineRight' => null,
                    ];
                } else {
                    $siteContacts = Contact::query()
                        ->active()
                        ->orderBy('sort_order')
                        ->orderBy('id')
                        ->get();

                    $siteContactsByType = $siteContacts->groupBy('type');
                    $siteContactsByKey = $siteContacts->keyBy('key');
                    $primaryPhoneContact = $siteContactsByType->get('phone')?->first();
                    $city = $siteContactsByKey->get('city_main')?->value;
                    $hours = $siteContactsByKey->get('hours_main')?->value;

                    $headerRightParts = array_values(array_filter([$hours, $primaryPhoneContact?->value]));

                    $shared = [
                        'siteContacts' => $siteContacts,
                        'siteContactsByType' => $siteContactsByType,
                        'siteContactsByKey' => $siteContactsByKey,
                        'primaryPhoneContact' => $primaryPhoneContact,
                        'headerToplineLeft' => $city ? 'Master Sport · '.$city : 'Master Sport',
                        'headerToplineRight' => $headerRightParts ? implode(' · ', $headerRightParts) : null,
                    ];
                }
            }

            $view->with($shared);
        });
    }
}
