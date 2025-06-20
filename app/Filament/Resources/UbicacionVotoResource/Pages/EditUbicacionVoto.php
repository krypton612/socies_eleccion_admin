<?php

namespace App\Filament\Resources\UbicacionVotoResource\Pages;

use App\Filament\Resources\UbicacionVotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUbicacionVoto extends EditRecord
{
    protected static string $resource = UbicacionVotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
