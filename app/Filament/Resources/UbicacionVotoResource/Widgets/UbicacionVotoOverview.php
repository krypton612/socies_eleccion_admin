<?php

namespace App\Filament\Resources\UbicacionVotoResource\Widgets;

use App\Models\UbicacionVoto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UbicacionVotoOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUbicaciones = UbicacionVoto::count();
        $ubicacionesActivas = UbicacionVoto::where('estado', true)->count();
        $ubicacionesInactivas = UbicacionVoto::where('estado', false)->count();
        return [
            Stat::make('Total de Ubicaciones', $totalUbicaciones)->icon('heroicon-o-map')->color('gray'),
            Stat::make('Ubicaciones Activas', $ubicacionesActivas)->icon('heroicon-o-map-pin')->color('success'),
            Stat::make('Ubicaciones Inactivas', $ubicacionesInactivas)->icon('heroicon-o-map-pin')->color('danger'),
        ];
    }
}
