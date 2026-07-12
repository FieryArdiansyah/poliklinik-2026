<?php

namespace App\Filament\Admin\Resources\TiketResource\Pages;

use App\Filament\Admin\Resources\TiketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTikets extends ListRecords
{
    protected static string $resource = TiketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
