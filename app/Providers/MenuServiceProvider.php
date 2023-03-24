<?php

namespace App\Providers;

use App\Models\Center;
use App\Models\Type;
use App\Models\Volume;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $vols = Volume::where('status', '1')->get(['id', 'name']);
        $centers = Center::where('status', '1')->get(['id', 'name']);
        $savingTypes = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        $loanTypes = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);

        view()->share(['vol_lists' => $vols, 'center_lists' => $centers, 'savingTypes_lists' => $savingTypes, 'loanTypes_lists' => $loanTypes]);
    }
}
