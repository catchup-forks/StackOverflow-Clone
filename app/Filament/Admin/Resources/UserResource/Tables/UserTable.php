<?php

namespace App\Filament\Admin\Resources\UserResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class UserTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('display_name')
                    ->label(trans('stackoverflow.admin.user.table.display_name'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('email')
                    ->label(trans('stackoverflow.admin.user.table.email'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('reputation')
                    ->label(trans('stackoverflow.admin.user.table.reputation'))
                    ->sortable(),
                TextColumn::make('views')
                    ->label(trans('stackoverflow.admin.user.table.profile_views'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.user.table.joined'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_access_date')
                    ->label(trans('stackoverflow.admin.user.table.last_seen'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('high_reputation')
                    ->label(trans('stackoverflow.admin.user.table.reputation_filter'))
                    ->query(fn ($query) => $query->where('reputation', '>=', 5000)),
                Filter::make('active_recently')
                    ->label(trans('stackoverflow.admin.user.table.seen_recently'))
                    ->query(fn ($query) => $query->where('last_access_date', '>=', now()->subDays(30))),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
