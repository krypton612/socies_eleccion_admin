<?php

namespace App\Filament\Resources\ProvinciaResource\Pages;

use App\Filament\Resources\ProvinciaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProvincia extends EditRecord
{
    protected static string $resource = ProvinciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
