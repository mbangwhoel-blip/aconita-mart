<?php

namespace App\Filament\Resources\ShuAllocations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShuAllocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_revenue')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_profit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('member_share_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('member_shu_pool')
                    ->numeric()
                    ->sortable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
