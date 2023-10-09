<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 26.09.2023
 * Time: 10:16
 */

namespace App\Filament\Pages;

use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class HealthCheckResults extends BaseHealthCheckResults
{
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public function getHeading(): string
    {
        return 'Health Check Results';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'System Tools';
    }
}
