<?php

namespace App\Filament\User\Resources\QuestionResource\Infolists;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class QuestionInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
                    ->label(__('Title'))
                    ->size('xl')
                    ->weight('bold'),
                TextEntry::make('body')
                    ->label(__('Details'))
                    ->markdown(),
                Grid::make()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('user.display_name')
                            ->label(__('Asked by')),
                        TextEntry::make('creation_date')
                            ->label(__('Asked'))
                            ->dateTime(),
                        TextEntry::make('tags')
                            ->label(__('Tags'))
                            ->formatStateUsing(fn (?string $state) => collect(explode(',', (string) $state))
                                ->map(fn (string $tag) => trim($tag))
                                ->filter()
                                ->implode(', ')),
                    ]),
            ]);
    }
}

