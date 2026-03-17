<?php

namespace App\Filament\Resources\ServerInfos\Pages;

use App\Filament\Resources\ServerInfos\ServerInfoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServerInfo extends ViewRecord
{
    protected static string $resource = ServerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
