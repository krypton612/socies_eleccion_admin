<?php

namespace App\Filament\Resources\CandidatoResource\RelationManagers;

use App\Models\Candidato;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CandidaturasRelationManager extends RelationManager
{
    protected static string $relationship = 'candidaturas';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Datos Generales de la Candidatura')
                ->description('Información principal de la candidatura')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('nombre_candidatura')
                        ->label('Nombre de la Candidatura')
                        ->required()
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-identification'),

                    Forms\Components\TextInput::make('lema')
                        ->label('Lema')
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-chat-bubble-left-ellipsis'),
                ]),

            Forms\Components\Section::make('Relaciones')
                ->description('Relación con entidades del sistema electoral')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('partido_id')
                        ->label('Partido Político')
                        ->relationship('partido', 'nombre_partido')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->prefixIcon('heroicon-o-flag'),

                    Forms\Components\Select::make('estado_candidatura_id')
                        ->label('Estado de la Candidatura')
                        ->relationship('estadoCandidatura', 'estado_candidatura')
                        ->required()
                        ->prefixIcon('heroicon-o-check-circle'),

                    Forms\Components\Select::make('proceso_electoral_id')
                        ->label('Proceso Electoral')
                        ->relationship('procesoElectoral', 'nombre_proceso')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->prefixIcon('heroicon-o-megaphone'),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_candidatura')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_candidatura'),
                Tables\Columns\TextColumn::make('estadoCandidatura.estado_candidatura')
                    ->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('partido.sigla')
                    ->label('Sigla')
                    ->badge()
                    ->icon('heroicon-o-bookmark')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->color(fn ($record) => $record->partido->color_hex ?? 'gray')
                    ->extraAttributes(fn ($record) => [
                        'style' => "background-color: {$record->partido->color_hex}; color: white; font-weight: bold;",
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_votos')
                    ->label('Total de Votos')
                    ->badge()
                    ->alignCenter()
                    ->color(fn($state) => $state > 0 ? 'success' : 'danger')
                    ->searchable(),
                Tables\Columns\TextColumn::make('procesoElectoral.nombre_proceso')
                    ->label('Proceso Electoral')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-arrow-path')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function canCreate(): bool
    {
        return false;
    }
}
