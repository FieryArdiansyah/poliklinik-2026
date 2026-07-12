<?php

namespace App\Filament\Admin\Resources\TiketResource\Pages;

use App\Filament\Admin\Resources\TiketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTiket extends EditRecord
{
    protected static string $resource = TiketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
