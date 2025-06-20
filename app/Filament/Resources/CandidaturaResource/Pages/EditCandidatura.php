<?php

namespace App\Filament\Resources\CandidaturaResource\Pages;

use App\Filament\Resources\CandidaturaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCandidatura extends EditRecord
{
    protected static string $resource = CandidaturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
