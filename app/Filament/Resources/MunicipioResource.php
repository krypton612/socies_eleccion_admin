<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MunicipioResource\Pages;
use App\Filament\Resources\MunicipioResource\RelationManagers;
use App\Filament\Resources\MunicipioResource\RelationManagers\UbicacionesVotoRelationManager;
use App\Models\Municipio;
use Filament\Forms;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Filters\SelectFilter;

class MunicipioResource extends Resource
{
    protected static ?string $model = Municipio::class;

    protected static ?string $navigationLabel = 'Municipios';

    protected static ?string $pluralNavigationLabel = 'Municipios';

    protected static ?string $navigationGroup = 'Municipios';
    protected static ?string $recordTitleAttribute = 'nombre';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->label('Nombre del Municipio')
                    ->required()
                    ->maxLength(50)
                    ->prefixIcon('heroicon-o-map'),
    
                Select::make('departamento_id')
                    ->label('Departamento')
                    ->options(\App\Models\Departamento::pluck('nombre', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set) => $set('provincia_id', null))
                    ->required()
                    ->prefixIcon('heroicon-o-globe-alt'),
    
                Select::make('provincia_id')
                    ->label('Provincia')
                    ->options(function (Get $get) {
                        $departamentoId = $get('departamento_id');
                        if (!$departamentoId) return [];
    
                        return \App\Models\Provincia::where('departamento_id', $departamentoId)
                            ->pluck('nombre', 'id');
                    })
                    ->required()
                    ->disabled(fn (Get $get) => !$get('departamento_id'))
                    ->prefixIcon('heroicon-o-map-pin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-arrow-path')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('provincia.nombre')
                    ->label('Provincia')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('provincia.departamento.nombre')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
            ])
            ->filters([
                SelectFilter::make('provincia_id')
                    ->label('Provincia')
                    ->relationship('provincia', 'nombre')
                    ->searchable(),
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
            UbicacionesVotoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMunicipios::route('/'),
            'create' => Pages\CreateMunicipio::route('/create'),
            'edit' => Pages\EditMunicipio::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
