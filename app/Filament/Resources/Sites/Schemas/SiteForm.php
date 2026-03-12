<?php

namespace App\Filament\Resources\Sites\Schemas;

// use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->required()
                    ->prefix('https://'),
                TextInput::make('time_interval')
                    ->required()
                    ->numeric(),
                // DateTimePicker::make('last_checked_at'),
                // DateTimePicker::make('ssl_expire_date'),
                // DateTimePicker::make('ssl_last_checked_at'),
                // TextInput::make('ssl_issuer'),
                // Toggle::make('ssl_is_valid')
                //     ->required(),
                // TextInput::make('error'),
            ]);
    }
}
