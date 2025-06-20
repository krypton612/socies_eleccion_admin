<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartidoResource\Pages;
use App\Filament\Resources\PartidoResource\RelationManagers;
use App\Models\Partido;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartidoResource extends Resource
{
    protected static ?string $model = Partido::class;

    protected static ?string $navigationLabel = 'Partidos Políticos';

    protected static ?string $pluralNavigationLabel = 'Partidos Políticos';

    protected static ?string $navigationGroup = 'Candidaturas';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->description('Datos principales del partido político')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nombre_partido')
                            ->label('Nombre del Partido')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-flag'),
    
                        Forms\Components\TextInput::make('sigla')
                            ->label('Sigla')
                            ->required()
                            ->maxLength(10)
                            ->prefixIcon('heroicon-o-bookmark'),
    
                        Forms\Components\TextInput::make('lema')
                            ->label('Lema')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-chat-bubble-left-ellipsis'),
    
                        Forms\Components\DatePicker::make('fecha_fundacion')
                            ->label('Fecha de Fundación')
                            ->required()
                            ->prefixIcon('heroicon-o-calendar-days'),
                    ]),
    
                Forms\Components\Section::make('Representación Legal')
                    ->description('Información del representante legal')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('representante_legal')
                            ->label('Representante Legal')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user-circle'),
    
                        Forms\Components\TextInput::make('direccion_sede')
                            ->label('Dirección de la Sede')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-home'),
                    ]),
    
                Forms\Components\Section::make('Contacto')
                    ->description('Datos de contacto oficiales')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pais')
                            ->label('País')
                            ->required()
                            ->maxLength(100)
                            ->prefixIcon('heroicon-o-globe-alt'),
    
                        Forms\Components\TextInput::make('telefono_contacto')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20)
                            ->prefixIcon('heroicon-o-phone'),
    
                        Forms\Components\TextInput::make('correo_contacto')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->prefixIcon('heroicon-o-envelope'),
    
                        Forms\Components\TextInput::make('pagina_web')
                            ->label('Página Web')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                    ]),
    
                Forms\Components\Section::make('Multimedia y Estética')
                    ->description('Logotipo y color representativo')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('logo_url')
                            ->label('Logo del Partido')
                            ->image()
                            ->directory('logos-partidos')
                            ->imagePreviewHeight('100')
                            ->previewable()
                            ->preserveFilenames(),
    
                        Forms\Components\ColorPicker::make('color_hex')
                            ->label('Color del Partido')
                            ->required()
                            ->prefixIcon('heroicon-o-paint-brush'),
                    ]),
    
                Forms\Components\Section::make('Estado')
                    ->description('Configuración del estado actual del partido')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('estado')
                            ->label('¿Está activo?')
                            ->inline(false)
                            ->required()
                            ->onColor('success')
                            ->offColor('danger')
                    ]),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Logo del partido (si existe)
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->height(40)
                    ->width(40),

                // Nombre del partido con su lema como descripción
                Tables\Columns\TextColumn::make('nombre_partido')
                    ->label('Nombre')
                    ->description(fn ($record) => $record->lema)
                    ->icon('heroicon-o-flag')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // Sigla con color de partido
                Tables\Columns\TextColumn::make('sigla')
                    ->label('Sigla')
                    ->badge()
                    ->icon('heroicon-o-bookmark')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->color(fn ($record) => $record->color_hex ?? 'gray')
                    ->extraAttributes(fn ($record) => [
                        'style' => "background-color: {$record->color_hex}; color: white; font-weight: bold;",
                    ])
                    ->searchable()
                    ->sortable(),

                // Representante Legal
                Tables\Columns\TextColumn::make('representante_legal')
                    ->label('Representante')
                    ->icon('heroicon-o-user-circle')
                    ->searchable()
                    ->sortable(),

                // Fundación
                Tables\Columns\TextColumn::make('fecha_fundacion')
                    ->label('Fundación')
                    ->icon('heroicon-o-calendar-days')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                // País
                Tables\Columns\TextColumn::make('pais')
                    ->label('País')
                    ->icon('heroicon-o-globe-alt')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                // Estado (activo/inactivo con color)
                Tables\Columns\IconColumn::make('estado')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                // Fecha creación
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                // Fecha actualización
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->icon('heroicon-o-arrow-path')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
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
            'index' => Pages\ListPartidos::route('/'),
            'create' => Pages\CreatePartido::route('/create'),
            'edit' => Pages\EditPartido::route('/{record}/edit'),
        ];
    }
}
