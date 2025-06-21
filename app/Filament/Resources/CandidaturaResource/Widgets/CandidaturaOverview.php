<?php

namespace App\Filament\Resources\CandidaturaResource\Widgets;

use App\Models\Candidatura;
use App\Models\EstadoCandidatura;
use App\Models\ProcesoElectoral;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CandidaturaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        // Widget para total general de candidaturas
        $totalCandidaturas = Candidatura::count();
        $stats[] = Stat::make('Total de candidaturas', $totalCandidaturas)
            ->description("Candidaturas en todos los estados")
            ->descriptionIcon('heroicon-o-clipboard-document')
            ->icon('heroicon-o-user-group')
            ->color('gray');

        // Widgets por estado de candidatura
        $estados = EstadoCandidatura::withCount('candidaturas')->get();
        foreach ($estados as $estado) {
            $stats[] = Stat::make("Total en estado: {$estado->estado_candidatura}", $estado->candidaturas_count)
                ->description("Candidaturas con estado '{$estado->estado_candidatura}'")
                ->descriptionIcon('heroicon-o-adjustments-horizontal')
                ->icon('heroicon-o-check-badge')
                ->color($this->getEstadoColor($estado->estado_candidatura));
        }

        // Widget para procesos electorales
        $totalProcesos = ProcesoElectoral::count();
        $stats[] = Stat::make('Total de procesos electorales', $totalProcesos)
            ->description("Procesos electorales registrados")
            ->descriptionIcon('heroicon-o-calendar-days')
            ->icon('heroicon-o-briefcase')
            ->color('indigo');

        return $stats;
    }

    /**
     * Devuelve un color para el estado
     */
    private function getEstadoColor(string $estado): string
    {
        return match (strtolower($estado)) {
            'activo'     => 'success',
            'inactivo'   => 'danger',
            'pendiente'  => 'warning',
            'rechazado'  => 'gray',
            default      => 'secondary',
        };
    }
}
