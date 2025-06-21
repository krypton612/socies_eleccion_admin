<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UbicacionVotoResource\Pages;
use App\Filament\Resources\UbicacionVotoResource\RelationManagers;
use App\Models\UbicacionVoto;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UbicacionVotoResource extends Resource
{
    protected static ?string $model = UbicacionVoto::class;

    protected static ?string $navigationLabel = 'Ubicaciones de Voto';

    protected static ?string $pluralNavigationLabel = 'Ubicaciones de Voto';

    protected static ?string $navigationGroup = 'Municipios';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de la Ubicación')
                    ->description('Información principal del recinto de votación')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nombre_ubicacion')
                            ->label('Nombre de la Ubicación')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-map-pin'),
    
                        Forms\Components\TextInput::make('direccion')
                            ->label('Dirección')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-home-modern'),
    
                        Forms\Components\Textarea::make('descripcion_ubicacion')
                            ->label('Descripción')
                            ->columnSpan(2)
                            ->rows(3)
                            ->maxLength(500)
                    ]),
    
                Forms\Components\Section::make('Ubicación Geográfica')
                    ->description('Coordenadas de latitud y longitud')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->required()
                            ->reactive()
                            ->readOnly()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('longitude')
                            ->required()
                            ->reactive()
                            ->readOnly()
                            ->maxLength(255),
                        // -17.035849, -65.179000
                        Map::make('location')
                            ->label('Ubicación')
                            ->live()
                            ->showMarker(true)
                            ->reactive()
                            ->clickable(true)
                            ->tilesUrl("https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.png")
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($state, callable $get, callable $set) {
                                $lat = $get('latitude') ?? -17.035849;
                                $lng = $get('longitude') ?? -65.179000;

                                $set('location', [
                                    'lat' => floatval($lat),
                                    'lng' => floatval($lng),
                                ]);
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            })
                            ->extraStyles([
                                'min-height: 70vh',
                                'border-radius: 50px',
                            ]),
                    ]),
    
                Forms\Components\Section::make('Jurisdicción')
                    ->description('Municipio donde se ubica el recinto')
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make('municipio_id')
                            ->label('Municipio')
                            ->relationship('municipio', 'nombre')
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-o-map'),
                    ]),
    
                Forms\Components\Toggle::make('estado')
                    ->label('Activo')
                    ->default(true)
                    ->inline()
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle'),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_ubicacion')
                    ->label('Ubicación')
                    ->icon('heroicon-o-map-pin')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('municipio.nombre')
                    ->label('Municipio')
                    ->icon('heroicon-o-map')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('municipio.provincia.nombre')
                    ->label('Provincia')
                    ->icon('heroicon-o-map'),

                Tables\Columns\TextColumn::make('direccion')
                    ->label('Dirección')
                    ->icon('heroicon-o-home-modern')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->direccion),

                Tables\Columns\TextColumn::make('total_votos')
                    ->label('Total de Votos')
                    ->alignCenter()
                    ->icon('heroicon-o-user-group'),

                Tables\Columns\TextColumn::make('coordenadas')
                    ->label('Lat, Lng')
                    ->icon('heroicon-o-globe-alt')
                    ->copyable()
                    ->copyMessage('Coordenadas copiadas'),

                Tables\Columns\IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color(fn (bool $state) => $state ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->icon('heroicon-o-clock'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->icon('heroicon-o-arrow-path'),
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
            'index' => Pages\ListUbicacionVotos::route('/'),
            'create' => Pages\CreateUbicacionVoto::route('/create'),
            'edit' => Pages\EditUbicacionVoto::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UbicacionVotoResource\Widgets\UbicacionVotoOverview::class,
        ];
    }
}
