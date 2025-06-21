<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ControlPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('control')
            ->path('control')
            ->login(
                CustomLogin::class
            )
            ->colors([
                'primary' => Color::Blue,         // confianza, seriedad
                'secondary' => Color::Slate,      // neutro, profesional
                'danger' => Color::Red,           // errores, alertas
                'success' => Color::Green,        // operaciones exitosas
                'warning' => Color::Amber,        // advertencias
                'info' => Color::Cyan,            // información
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->plugin(
                
            )
            ->navigationGroups([
                NavigationGroup::make()
                     ->label('Candidatos')
                     ->icon('heroicon-o-heart'),
                NavigationGroup::make()
                    ->label('Candidaturas')
                    ->icon('heroicon-o-user-group'),
                NavigationGroup::make()
                    ->label('Municipios')
                    ->icon('heroicon-o-arrow-down-on-square-stack'),
                NavigationGroup::make()
                    ->label('Elecciones')
                    ->icon('heroicon-o-flag'),
                NavigationGroup::make()
                    ->label('Votos')
                    ->icon('heroicon-o-presentation-chart-line'),
                NavigationGroup::make()
                    ->label('Configuración')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->brandName('Elecciones Intra')
            ->authMiddleware([
                Authenticate::class,
            ]);
            
    }
}
