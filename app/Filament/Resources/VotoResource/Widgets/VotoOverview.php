<?php

namespace App\Filament\Resources\VotoResource\Widgets;

use App\Models\Voto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VotoOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        // Total general de votos
        $totalVotos = Voto::count();
        $stats[] = Stat::make('Total de votos', $totalVotos)
            ->description("Departamentos registrados en el sistema")
            ->descriptionIcon('heroicon-o-map')
            ->icon('heroicon-o-building-office')
            ->color('gray');

        // Cargar los departamentos con la cuenta de provincias
        $votos = Voto::withCount('metodoVoto')->get();
        
        // OJO POSIBLE PROBLEMA HASTA QUE ALMENOS EXISTA UN VOTO REGISTRADO

        foreach ($votos as $voto) {
            $stats[] = Stat::make("{$voto->metodo_voto->nombre}", $voto->metodo_voto_count)
                ->description("Provincias en el departamento de {$voto->metodo_voto->nombre}")
                ->descriptionIcon('heroicon-o-map-pin')
                ->icon('heroicon-o-building-library')
                ->color($this->getColorPorCantidad($voto->metodo_voto_count));
        }

        return $stats;
    }

    private function getColorPorCantidad(int $cantidad): string
    {
        return match (true) {
            $cantidad === 0            => 'gray',
            $cantidad <= 5             => 'warning',
            $cantidad <= 10            => 'info',
            $cantidad <= 20            => 'success',
            default                    => 'primary',
        };  
    }
}
