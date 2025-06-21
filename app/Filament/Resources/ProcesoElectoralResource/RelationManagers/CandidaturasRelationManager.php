<?php

namespace App\Filament\Resources\ProcesoElectoralResource\RelationManagers;

use App\Models\Candidato;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

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
                        Forms\Components\Select::make('candidato_id')
                            ->label('Candidato')
                            ->relationship(
                                name: 'candidato',
                                titleAttribute: 'nombre_candidato', // Usa el campo real
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->select([
                                        'id',
                                        'nombre_candidato',
                                        'apellido_paterno',
                                        'apellido_materno',
                                        DB::raw("CONCAT(nombre_candidato, ' ', apellido_paterno, ' ', apellido_materno) as nombre_completo")
                                    ])
                            )
                            ->getOptionLabelFromRecordUsing(fn (Candidato $record) => $record->nombre_completo)
                            ->preload()
                            ->searchable(['nombre_candidato', 'apellido_paterno', 'apellido_materno']),
                            
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
    
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_candidatura')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_candidatura')
                    ->label('Nombre')
                    ->icon('heroicon-o-identification')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('lema')
                    ->label('Lema')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->lema),
                Tables\Columns\TextColumn::make('total_votos')
                    ->label('Total de Votos')
                    ->alignCenter()
                    ->color(fn($state) => $state > 0 ? 'success' : 'danger')
                    ->badge()
                    ->icon('heroicon-o-chart-bar')
                    ->sortable(),

                Tables\Columns\TextColumn::make('candidato.nombre_completo')
                    ->label('Candidato')
                    ->icon('heroicon-o-user-circle')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('partido.nombre_partido')
                    ->label('Partido')
                    ->icon('heroicon-o-flag')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('estadoCandidatura.estado_candidatura')
                    ->label('Estado')
                    ->color(fn ($state) => match ($state) {
                        'Activo' => 'success',
                        'Inactivo' => 'gray',
                        default => 'warning',
                    })
                    ->icon('heroicon-o-check-circle'),

                Tables\Columns\TextColumn::make('procesoElectoral.nombre_proceso')
                    ->label('Proceso Electoral')
                    ->icon('heroicon-o-megaphone')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d/m/Y H:i'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-arrow-path')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
