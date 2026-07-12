<?php

namespace App\Filament\Admin\Resources\QueueTicketResource\Pages;

use App\Filament\Admin\Resources\QueueTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQueueTickets extends ListRecords
{
    protected static string $resource = QueueTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
