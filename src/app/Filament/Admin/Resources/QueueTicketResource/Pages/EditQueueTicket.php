<?php

namespace App\Filament\Admin\Resources\QueueTicketResource\Pages;

use App\Filament\Admin\Resources\QueueTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQueueTicket extends EditRecord
{
    protected static string $resource = QueueTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
