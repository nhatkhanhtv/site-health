<?php

namespace App\Filament\Resources\ServerInfos\Pages;

use App\Filament\Resources\ServerInfos\ServerInfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageServerInfos extends ManageRecords
{
    protected static string $resource = ServerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
