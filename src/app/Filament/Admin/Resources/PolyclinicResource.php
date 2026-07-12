<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PolyclinicResource\Pages;
use App\Models\Polyclinic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PolyclinicResource extends Resource
{
    protected static ?string $model = Polyclinic::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Poliklinik';

    protected static ?string $modelLabel = 'Poliklinik';

    protected static ?string $pluralModelLabel = 'Poliklinik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Poli')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('code')
                    ->label('Kode Poli')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20)
                    ->helperText('Contoh: UMU, GIG, ANA'),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

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
                    ->label('Nama Poli')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
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
            'index' => Pages\ListPolyclinics::route('/'),
            'create' => Pages\CreatePolyclinic::route('/create'),
            'edit' => Pages\EditPolyclinic::route('/{record}/edit'),
        ];
    }
}