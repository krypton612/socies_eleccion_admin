<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidaturaResource\Pages;
use App\Filament\Resources\CandidaturaResource\RelationManagers;
use App\Filament\Resources\CandidaturaResource\Widgets\CandidaturaOverview;
use App\Models\Candidato;
use App\Models\Candidatura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class CandidaturaResource extends Resource
{
    protected static ?string $model = Candidatura::class;

    protected static ?string $navigationLabel = 'Candidaturas';

    protected static ?string $pluralNavigationLabel = 'Candidaturas';

    protected static ?string $navigationGroup = 'Candidaturas';

    protected static ?string $recordTitleAttribute = 'nombre_candidatura';

    public static function form(Form $form): Form
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
    

    public static function table(Table $table): Table
    {
        return $table
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidaturas::route('/'),
            'create' => Pages\CreateCandidatura::route('/create'),
            'edit' => Pages\EditCandidatura::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CandidaturaOverview::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
