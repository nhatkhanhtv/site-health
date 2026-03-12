<?php

namespace App\Filament\Resources\Sites\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('site_name'),
                TextEntry::make('time_interval')
                    ->numeric(),
                TextEntry::make('last_checked_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ssl_expire_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ssl_last_checked_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ssl_issuer')
                    ->placeholder('-'),
                IconEntry::make('ssl_is_valid')
                    ->boolean(),
                TextEntry::make('error')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
