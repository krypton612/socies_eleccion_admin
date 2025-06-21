<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidatoResource\Pages;
use App\Filament\Resources\CandidatoResource\RelationManagers;
use App\Filament\Resources\CandidatoResource\RelationManagers\CandidaturasRelationManager;
use App\Models\Candidato;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CandidatoResource extends Resource
{
    protected static ?string $model = Candidato::class;

    protected static ?string $navigationLabel = 'Candidatos';

    protected static ?string $pluralNavigationLabel = 'Candidatos';

    protected static ?string $navigationGroup = 'Candidatos';

    protected static ?string $recordTitleAttribute = 'nombre_candidato';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos Primarios')
                    ->description('Información personal del socio')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nombre_candidato')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        Forms\Components\TextInput::make('apellido_paterno')
                            ->label('Apellido Paterno')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        Forms\Components\TextInput::make('apellido_materno')
                            ->label('Apellido Materno')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        Forms\Components\TextInput::make('cedula_identidad')
                            ->label('Cédula de Identidad')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-document'),
                        Forms\Components\Select::make('cargo_id')
                            ->label('Cargo')
                            ->relationship('cargo', 'nombre')
                            ->required()
                            ->preload()
                            ->prefixIcon('heroicon-o-user'),
                        Forms\Components\Select::make('estado_candidato_id')
                            ->label('Estado')
                            ->relationship('estadoCandidato', 'estado_candidato')
                            ->required()
                            ->preload()
                            ->prefixIcon('heroicon-o-user'),
                    ]),
                Forms\Components\Section::make('Datos Secundarios')
                    ->description('Documentación, licencia y estado del socio')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('correo')
                            ->label('Correo')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        Forms\Components\DatePicker::make('fecha_nacimiento')
                            ->label('Fecha de Nacimiento')
                            ->required()
                            ->prefixIcon('heroicon-o-user')
                            ->default(now()),
                        Forms\Components\FileUpload::make('foto_url')
                            ->label('Foto')
                            ->required()
                            ->image(),
                        Forms\Components\Textarea::make('propuesta')
                            ->label('Propuesta')
                            ->required()
                            ->rows(3)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_url')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable()
                    ->icon('heroicon-o-user'),
                Tables\Columns\TextColumn::make('cedula_identidad')
                    ->label('Cédula de Identidad')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->searchable()
                    ->icon('heroicon-o-document'),

                Tables\Columns\TextColumn::make('correo')
                    ->label('Correo')
                    ->alignCenter()
                    ->copyable()
                    ->icon('heroicon-o-at-symbol'),
                Tables\Columns\TextColumn::make('cargo.nombre')
                    ->label('Cargo')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('estadoCandidato.estado_candidato')
                    ->label('Estado')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('propuesta')
                    ->label('Propuesta')
                    ->searchable()
                    ->limit(20)
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            CandidaturasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidatos::route('/'),
            'create' => Pages\CreateCandidato::route('/create'),
            'edit' => Pages\EditCandidato::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CandidatoResource\Widgets\CandidatosOverview::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
