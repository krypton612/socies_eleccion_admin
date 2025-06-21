<?php

namespace App\Filament\Resources\UsuarioResource\Widgets;

use App\Models\Usuario;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsuariosOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $usuarios = Usuario::all();
        $totalUsuarios = $usuarios->count();
        $totalUsuariosAunSinVotar = $usuarios->where('estado', false)->count();
        $totalUsuariosVotaron = $usuarios->where('estado', true)->count();

        $semanaPasada = now()->subWeek();
        $usuariosSemanaPasada = Usuario::whereBetween('created_at', [$semanaPasada, now()])->count();
        $porcentajeSemanaPasada = ($totalUsuarios * 100) / $usuariosSemanaPasada;
        $color = $porcentajeSemanaPasada > 100 ? 'warning' : 'success';


        return [
            Stat::make('Total de usuarios', $totalUsuarios)
                ->descriptionIcon('heroicon-o-arrow-up')
                ->icon('heroicon-o-user-group')
                ->color($color), 
            Stat::make('Total de usuarios que no votaron A/U', $totalUsuariosVotaron)
                ->descriptionIcon('heroicon-o-arrow-up')
                ->icon('heroicon-o-user-group')
                ->color('warning'), 

            Stat::make('Total de usuarios que votaron A/U', $totalUsuariosAunSinVotar)
                ->descriptionIcon('heroicon-o-arrow-up')
                ->icon('heroicon-o-user-group')
                ->color('warning'), 
        ];
    }
}
