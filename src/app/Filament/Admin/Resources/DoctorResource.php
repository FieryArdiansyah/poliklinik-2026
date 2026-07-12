<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Dokter';

    protected static ?string $modelLabel = 'Dokter';

    protected static ?string $pluralModelLabel = 'Dokter';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('polyclinic_id')
                    ->label('Poliklinik')
                    ->relationship('polyclinic', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Dokter')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('sip_number')
                    ->label('Nomor SIP')
                    ->maxLength(100),

                Forms\Components\TextInput::make('phone')
                    ->label('Nomor HP')
                    ->tel()
                    ->maxLength(30),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Dokter')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('polyclinic.name')
                    ->label('Poliklinik')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sip_number')
                    ->label('Nomor SIP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('No HP')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('polyclinic_id')
                    ->label('Poliklinik')
                    ->relationship('polyclinic', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}