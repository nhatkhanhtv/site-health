<?php

namespace App\Filament\Resources\ServerInfos\RelationManagers;

use App\Filament\Resources\ServerInfos\ServerInfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServerCheckRelationManager extends RelationManager
{
    protected static string $relationship = 'serverCheck';

    protected static ?string $relatedResource = ServerInfoResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at','desc')
            ->headerActions([
                CreateAction::make(),
            ])->columns([
                TextColumn::make('cpu')
                    ->html(),
                    
                TextColumn::make('ram')
                    ->html(),                
                TextColumn::make('disk')
                    ->html(),  
                TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime('H:i:s d/m/Y')             
                    

                    
            ]);
    }
}
