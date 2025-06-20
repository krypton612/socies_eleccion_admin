<?php

namespace App\Filament\Resources\VotoResource\Pages;

use App\Filament\Resources\VotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVoto extends EditRecord
{
    protected static string $resource = VotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
