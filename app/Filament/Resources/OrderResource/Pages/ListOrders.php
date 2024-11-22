<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class
        ];
    }

    public function getTabs(): array
    {
        return[
            null => Tab::make('All'),
            'new' => Tab::make('New')
                ->query(function ($query) {
                    return $query->where('status', 'new');
                }),
            'processing' => Tab::make('Processing')
                ->query(function ($query) {
                    return $query->where('status', 'processing');
                }),

            'shipped' => Tab::make('Shipped')
                ->query(function ($query) {
                    return $query->where('status', 'shipped');
                }),

            'delivered' => Tab::make('Delivered')
                ->query(function ($query) {
                    return $query->where('status', 'delivered');
                }),

            'canncalled' => Tab::make('Canncalled')
                ->query(function ($query) {
                    return $query->where('status', 'canncalled');
                }),
        ];
    }
}
