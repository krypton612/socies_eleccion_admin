<?php

namespace App\Filament\Resources\ProcesoElectoralResource\Pages;

use App\Filament\Resources\ProcesoElectoralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcesoElectoral extends EditRecord
{
    protected static string $resource = ProcesoElectoralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
