<?php

namespace App\Providers\Filament;

use Filament\Panel;
use \App\Models\User;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\QuickEditPagesWidget;
use App\Filament\Widgets\RecentSubscribersWidget;
use App\Filament\Widgets\SeoHealthWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\SubscriberGrowthChart;
use App\Filament\Widgets\TopTreeClicks;
use Filament\Jetstream\JetstreamPlugin;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\PanAnalyticsWidget;
use Illuminate\Session\Middleware\StartSession;
use AchyutN\FilamentLogViewer\FilamentLogViewer;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Widgets\MostVisitedSocMediaChart;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarFullyCollapsibleOnDesktop()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->widgets([
                QuickEditPagesWidget::class,
                SubscriberGrowthChart::class,
                RecentSubscribersWidget::class,
                SeoHealthWidget::class,
                StatsOverview::class,
                TopTreeClicks::class,
                MostVisitedSocMediaChart::class,
                PanAnalyticsWidget::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Preview Website')
                    ->url(fn(): string => route('home'))
                    ->icon('heroicon-o-eye'),
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->plugins([
                JetstreamPlugin::make()
                    ->configureUserModel(userModel: User::class)
                    ->profilePhoto(condition: fn() => true, disk: 'public')
                    ->profileInformation(condition: fn() => true)
                    ->logoutBrowserSessions(condition: fn() => true),
                FilamentLogViewer::make(),
            ]);
    }
}
