<?php

namespace App\Filament\Resources\Sites\Pages;

use App\Filament\Resources\Sites\SiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSites extends ListRecords
{
    protected static string $resource = SiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * override để hiện đúng breadcrumbs
     */
    public function getBreadcrumbs(): array
    {
        // dd($this->record);
        return [
            // SiteResource::getUrl('index') => 'Site',
            // 'Sites'
            // SiteResource::getUrl('view', ['record' => $this->record]) => $this->getRecord()->site_name
        ];
    }
}
