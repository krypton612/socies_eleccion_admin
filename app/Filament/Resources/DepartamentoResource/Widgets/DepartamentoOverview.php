<?php

namespace App\Filament\Resources\DepartamentoResource\Widgets;

use App\Models\Departamento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DepartamentoOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        // Total general de departamentos
        $totalDepartamentos = Departamento::count();
        $stats[] = Stat::make('Total de departamentos', $totalDepartamentos)
            ->description("Departamentos registrados en el sistema")
            ->descriptionIcon('heroicon-o-map')
            ->icon('heroicon-o-building-office')
            ->color('gray');

        // Cargar los departamentos con la cuenta de provincias
        $departamentos = Departamento::withCount('provincias')->get();

        foreach ($departamentos as $departamento) {
            $stats[] = Stat::make("{$departamento->nombre}", $departamento->provincias_count)
                ->description("Provincias en el departamento de {$departamento->nombre}")
                ->descriptionIcon('heroicon-o-map-pin')
                ->icon('heroicon-o-building-library')
                ->color($this->getColorPorCantidad($departamento->provincias_count));
        }

        return $stats;
    }

    /**
     * Determina un color según la cantidad de provincias
     */
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
