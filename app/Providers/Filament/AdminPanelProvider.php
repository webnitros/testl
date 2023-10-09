<?php

namespace App\Providers\Filament;

use Adrolli\FilamentJobManager\FilamentFailedJobsPlugin;
use Adrolli\FilamentJobManager\FilamentJobBatchesPlugin;
use Adrolli\FilamentJobManager\FilamentJobsPlugin;
use Adrolli\FilamentJobManager\FilamentWaitingJobsPlugin;
use App\Filament\Pages\HealthCheckResults;
use App\Policies\UserPolicy;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // custom css
        $css = public_path() . '/css/custom.css';
        if (file_exists($css)) {
            FilamentAsset::register([
                Css::make('custom-stylesheet', __DIR__ . '/../../resources/css/custom.css'),
                //Css::make('custom-stylesheet', $css),
            ]);
        }

        return $panel
            ->brandName('Filament Starter')
            ->default()
            ->darkMode(false)
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            /*->widgets([
                //Widgets\AccountWidget::class,
                #Widgets\FilamentInfoWidget::class,
                //SiteOverview::class,
                StatsOverview::class,
                FilamentInfoWidget::class,
            ])*/
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->authGuard('web')
            ->plugins([
                FilamentSpatieLaravelHealthPlugin::make()
                    ->usingPage(HealthCheckResults::class),

                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),

                BreezyCore::make()
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
                    )
                    ->enableSanctumTokens()
                    ->enableTwoFactorAuthentication()
                    ->avatarUploadComponent(fn(\Filament\Forms\Components\FileUpload $fileUpload) => $fileUpload->disableLabel()->directory('avatars')->disk('s3'))
                    ->myProfile(
                        hasAvatars: true,
                    ),

                //QuickCreatePlugin::make(),

                \Hasnayeen\Themes\ThemesPlugin::make(),
                #FilamentRouteStatisticsPlugin::make(),
                FilamentLaravelLogPlugin::make()
                    ->logDirs([
                        storage_path('logs'),     // The default value
                    ])
                    ->navigationGroup('System Tools')
                    ->navigationLabel('Logs')
                    ->navigationIcon('heroicon-o-bug-ant')
                    ->navigationSort(1)
                    ->slug('logs')
                ,
                EnvironmentIndicatorPlugin::make()
                    ->color(fn() => match (app()->environment()) {
                        'staging' => Color::Orange,
                        'production' => Color::Gray,
                        default => Color::Orange,
                    })
                    ->showBadge(true)
                    ->showBorder(true)
                    ->visible(fn() => !app()->environment('production'))
                ,

                FilamentJobsPlugin::make(),
                FilamentWaitingJobsPlugin::make(),
                FilamentFailedJobsPlugin::make(),
                FilamentJobBatchesPlugin::make(),
            ]);

    }
}
