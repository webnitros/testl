<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Storage;
use Spatie\Health\Facades\Health;
use Spatie\Health\Models\HealthCheckResultHistoryItem;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';


    protected function getStats(): array
    {

        $isConnected = false;
        if ($Minio = HealthCheckResultHistoryItem::where('check_name', 'Minio')->orderByDesc('id')->first()) {
            $status = $Minio->status;
            $isConnected = $status === 'ok';
        }

        $msg = 'Browser: ' . getenv('AWS_URL_BROWSER') . '<br>' . ($isConnected ? 'Connected' : 'Disconnect');

        return [
            Stat::make('Minio bucket', getenv('AWS_BUCKET'))
                ->color($isConnected ? 'success' : 'danger')
                ->description(new \Illuminate\Support\HtmlString($msg))
            ,
        ];
    }
}
