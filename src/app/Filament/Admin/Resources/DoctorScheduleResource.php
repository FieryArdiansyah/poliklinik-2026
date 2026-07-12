<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DoctorScheduleResource\Pages;
use App\Models\DoctorSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorScheduleResource extends Resource
{
    protected static ?string $model = DoctorSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Jadwal Dokter';

    protected static ?string $modelLabel = 'Jadwal Dokter';

    protected static ?string $pluralModelLabel = 'Jadwal Dokter';

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

                Forms\Components\Select::make('doctor_id')
                    ->label('Dokter')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('day')
                    ->label('Hari Praktik')
                    ->options([
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu',
                    ])
                    ->required(),

                Forms\Components\TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->required(),

                Forms\Components\TextInput::make('quota')
                    ->label('Kuota Pasien')
                    ->numeric()
                    ->default(20)
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Dokter')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('polyclinic.name')
                    ->label('Poliklinik')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('day')
                    ->label('Hari')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('quota')
                    ->label('Kuota'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('polyclinic_id')
                    ->label('Poliklinik')
                    ->relationship('polyclinic', 'name'),

                Tables\Filters\SelectFilter::make('day')
                    ->label('Hari')
                    ->options([
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu',
                    ]),

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
            'index' => Pages\ListDoctorSchedules::route('/'),
            'create' => Pages\CreateDoctorSchedule::route('/create'),
            'edit' => Pages\EditDoctorSchedule::route('/{record}/edit'),
        ];
    }
}