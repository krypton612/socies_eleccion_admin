<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidatoResource\RelationManagers\CandidaturasRelationManager;
use App\Filament\Resources\ProcesoElectoralResource\Pages;
use App\Filament\Resources\ProcesoElectoralResource\RelationManagers;
use App\Filament\Resources\ProcesoElectoralResource\RelationManagers\CandidaturasRelationManager as RelationManagersCandidaturasRelationManager;
use App\Models\ProcesoElectoral;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcesoElectoralResource extends Resource
{
    protected static ?string $model = ProcesoElectoral::class;

    protected static ?string $navigationLabel = 'Proceso Electoral';

    protected static ?string $pluralNavigationLabel = 'Proceso Electorales';

    protected static ?string $navigationGroup = 'Elecciones';

    protected static ?string $recordTitleAttribute = 'nombre_proceso';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos Generales del Proceso')
                    ->description('Define el nombre y la descripción del proceso electoral')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nombre_proceso')
                            ->label('Nombre del Proceso')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-megaphone'),
    
                        Forms\Components\Textarea::make('descripcion_proceso')
                            ->label('Descripción')
                            ->rows(3)
                            ->maxLength(50)

                    ]),
    
                Forms\Components\Section::make('Fechas')
                    ->description('Establece la duración del proceso')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('fecha_inicio')
                            ->label('Fecha de Inicio')
                            ->required()
                            ->prefixIcon('heroicon-o-calendar-days'),
    
                        Forms\Components\DateTimePicker::make('fecha_fin')
                            ->label('Fecha de Fin')
                            ->required()
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),
    
                Forms\Components\Section::make('Estado')
                    ->description('Asignación del estado organizacional del proceso')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('estado_proceso_id')
                            ->label('Estado del Proceso')
                            ->relationship('estadoProceso', 'estado_proceso')
                            ->required()
                            ->prefixIcon('heroicon-o-check-circle'),
                    ]),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('nombre_proceso')
                ->label('Nombre')
                ->icon('heroicon-o-megaphone')
                ->searchable()
                ->sortable()
                ->weight('bold'),

            Tables\Columns\TextColumn::make('descripcion_proceso')
                ->label('Descripción')
                ->limit(50)
                ->wrap(20)
                ->tooltip(fn ($record) => $record->descripcion_proceso)
                ->icon('heroicon-o-document-text'),

            Tables\Columns\TextColumn::make('fecha_inicio')
                ->label('Inicio')
                ->icon('heroicon-o-calendar-days')
                ->date('d/m/Y H:i')
                ->sortable(),

            Tables\Columns\TextColumn::make('fecha_fin')
                ->label('Fin')
                ->icon('heroicon-o-calendar')
                ->date('d/m/Y H:i')
                ->sortable(),

            Tables\Columns\BadgeColumn::make('estadoProceso.estado_proceso')
                ->label('Estado')
                ->color(fn ($record) => match ($record->estadoProceso?->estado_proceso) {
                    'Activo' => 'success',
                    'Finalizado' => 'danger',
                    'Programado' => 'warning',
                    default => 'gray',
                })
                ->icon('heroicon-o-check-circle'),

            Tables\Columns\TextColumn::make('duracion_dias')
                ->label('Duración (días)')
                ->icon('heroicon-o-clock'),

            Tables\Columns\IconColumn::make('esta_activo')
                ->label('¿Activo?')
                ->boolean()
                ->trueIcon('heroicon-o-bolt')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),

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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagersCandidaturasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcesoElectorals::route('/'),
            'create' => Pages\CreateProcesoElectoral::route('/create'),
            'edit' => Pages\EditProcesoElectoral::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
