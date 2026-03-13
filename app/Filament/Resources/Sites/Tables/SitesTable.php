<?php

namespace App\Filament\Resources\Sites\Tables;

use App\UptimeStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SitesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')
                    ->translateLabel('site_name')
                    ->searchable(),
                TextColumn::make('lastestUptime.status')
                    ->label('Status')
                    ->placeholder("error")
                    // ->numeric()
                    ->sortable()
                    
                    ->badge(UptimeStatus::class)
                    ->label('Status'),
                TextColumn::make('lastestUptime.checked_at')
                    ->label('Last Checked')
                    ->since()
                    ->sortable(),
                TextColumn::make('lastestUptime.error')
                    ->label('Uptime Error')
                    ->searchable()->limit(20)
                    ->color('danger')
                    ->extraAttributes([
                        'class' => 'cursor-pointer underline',
                    ])
                    ->tooltip(fn ($record) => $record->error)
                    ->action(//lam modal de xem details
                        Action::make('view_error')
                            ->label('Error Details')
                            ->schema([
                                TextEntry::make('lastestUptime.error')
                                    // ->translateLabel('uptime_error')
                                    ->hiddenLabel(true)
                            ])   
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                            ->modalAlignment('center')
                            ->modalIcon(Heroicon::ExclamationTriangle)

                            
                    ),
                
                TextColumn::make('ssl_expire_date')
                    ->translateLabel('ssl_expire_date')
                    ->date('d/m/Y')
                    ->sortable(),
                // TextColumn::make('ssl_last_checked_at')
                //     ->since()
                //     ->sortable(),
                // TextColumn::make('ssl_issuer')
                //     ->searchable(),
                IconColumn::make('ssl_is_valid')
                    ->translateLabel('ssl_is_valid')
                    ->boolean(),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
