<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 05.05.2023
 * Time: 16:57
 */

namespace App\Providers;

use App\Helpers\Updater;
use Illuminate\Support\ServiceProvider;

class UpdaterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('updater_helper', function () {
            return new Updater();
        });
    }
}
