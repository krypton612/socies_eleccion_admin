<?php

namespace App\Filament\Resources\EstadoCandidatoResource\Pages;

use App\Filament\Resources\EstadoCandidatoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstadoCandidato extends EditRecord
{
    protected static string $resource = EstadoCandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
