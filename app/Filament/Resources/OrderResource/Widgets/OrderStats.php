<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        $newOrdersCount = Order::query()->where('status', 'new')->count();
        $processingOrdersCount = Order::query()->where('status', 'processing')->count();
        $shippedOrdersCount = Order::query()->where('status', 'shipped')->count();
        
        $averagePrice = Order::query()->avg('grand_total');
        $averagePrice = $averagePrice ? Number::currency($averagePrice, 'IDR') : 0;

        return [
            Stat::make('New Orders', $newOrdersCount > 0 ? $newOrdersCount : 0),
            Stat::make('Order Processing', $processingOrdersCount > 0 ? $processingOrdersCount : 0),
            Stat::make('Order Shipped', $shippedOrdersCount > 0 ? $shippedOrdersCount : 0),
            Stat::make('Average Price', $averagePrice),
        ];
    }
}
