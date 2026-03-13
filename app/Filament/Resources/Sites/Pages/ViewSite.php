<?php

namespace App\Filament\Resources\Sites\Pages;

use App\Filament\Resources\Sites\SiteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSite extends ViewRecord
{
    protected static string $resource = SiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    /**
     * override để hiện đúng breadcrumbs
     */
    public function getBreadcrumbs(): array
    {
        // dd($this->record);
        return [
            SiteResource::getUrl('index') => 'Sites',
            $this->getRecord()->site_name
            // SiteResource::getUrl('view', ['record' => $this->record]) => $this->getRecord()->site_name
        ];
    }
}
