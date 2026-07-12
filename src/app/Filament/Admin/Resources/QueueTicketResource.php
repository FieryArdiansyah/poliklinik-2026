<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QueueTicketResource\Pages;
use App\Models\QueueTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QueueTicketResource extends Resource
{
    protected static ?string $model = QueueTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Antrian';

    protected static ?string $navigationLabel = 'Antrian Pasien';

    protected static ?string $modelLabel = 'Antrian Pasien';

    protected static ?string $pluralModelLabel = 'Antrian Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->label('Pasien')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

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

                Forms\Components\TextInput::make('queue_code')
                    ->label('Nomor Antrian')
                    ->required()
                    ->maxLength(50)
                    ->helperText('Contoh: UMU-001'),

                Forms\Components\DatePicker::make('queue_date')
                    ->label('Tanggal Antrian')
                    ->default(now())
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'called' => 'Dipanggil',
                        'done' => 'Selesai',
                        'cancelled' => 'Batal',
                    ])
                    ->default('waiting')
                    ->required(),

                Forms\Components\TextInput::make('estimated_waiting_minutes')
                    ->label('Estimasi Tunggu')
                    ->numeric()
                    ->suffix('menit')
                    ->default(0)
                    ->required(),

                Forms\Components\Textarea::make('complaint')
                    ->label('Keluhan')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('called_at')
                    ->label('Waktu Dipanggil'),

                Forms\Components\DateTimePicker::make('finished_at')
                    ->label('Waktu Selesai'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('queue_code')
                    ->label('No. Antrian')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Pasien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('polyclinic.name')
                    ->label('Poliklinik')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Dokter')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'gray',
                        'called' => 'warning',
                        'done' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'waiting' => 'Menunggu',
                        'called' => 'Dipanggil',
                        'done' => 'Selesai',
                        'cancelled' => 'Batal',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('estimated_waiting_minutes')
                    ->label('Estimasi')
                    ->suffix(' menit')
                    ->sortable(),

                Tables\Columns\TextColumn::make('queue_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('called_at')
                    ->label('Dipanggil')
                    ->dateTime('H:i')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Selesai')
                    ->dateTime('H:i')
                    ->placeholder('-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'called' => 'Dipanggil',
                        'done' => 'Selesai',
                        'cancelled' => 'Batal',
                    ]),

                Tables\Filters\SelectFilter::make('polyclinic_id')
                    ->label('Poliklinik')
                    ->relationship('polyclinic', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('call')
                    ->label('Panggil')
                    ->icon('heroicon-o-speaker-wave')
                    ->color('warning')
                    ->visible(fn ($record): bool => $record->status === 'waiting')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'called',
                            'called_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('done')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record): bool => $record->status === 'called')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'done',
                            'finished_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('cancel')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record): bool => in_array($record->status, ['waiting', 'called']))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'cancelled',
                        ]);
                    }),

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
            'index' => Pages\ListQueueTickets::route('/'),
            'create' => Pages\CreateQueueTicket::route('/create'),
            'edit' => Pages\EditQueueTicket::route('/{record}/edit'),
        ];
    }
}