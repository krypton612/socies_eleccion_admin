<?php

namespace App\Filament\Resources\EstadoProcesoResource\Pages;

use App\Filament\Resources\EstadoProcesoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstadoProceso extends EditRecord
{
    protected static string $resource = EstadoProcesoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
