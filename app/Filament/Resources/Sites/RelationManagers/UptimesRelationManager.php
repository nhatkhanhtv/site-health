<?php

namespace App\Filament\Resources\Sites\RelationManagers;

use App\Filament\Resources\Sites\SiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UptimesRelationManager extends RelationManager
{
    protected static string $relationship = 'uptimes';

    protected static ?string $relatedResource = SiteResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('checked_at', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])->columns([
                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('http_status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('response_time_ms')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('checked_at')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('error')
                    ->sortable()
                    ->searchable()
                    ->wrap()
            ])
            ;
    }
}
