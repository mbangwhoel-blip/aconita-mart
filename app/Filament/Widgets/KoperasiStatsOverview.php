<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KoperasiStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('order_date', today())
            ->where('payment_status', 'paid')
            ->sum('final_amount');

        $monthProfit = Order::whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->where('payment_status', 'paid')
            ->sum('total_profit');

        $totalMembers = Member::where('is_active', true)->count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')
            ->where('is_active', true)
            ->count();

        return [
            Stat::make('Omset Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Penjualan tunai & non-tunai hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Estimasi Laba / SHU Bulan Ini', 'Rp ' . number_format($monthProfit, 0, ',', '.'))
                ->description('Laba kotor penjualan mart bulan ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Anggota Aktif', $totalMembers . ' Orang')
                ->description('Anggota koperasi terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Peringatan Stok Menipis', $lowStockCount . ' Produk')
                ->description('Stok di bawah batas minimum')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'gray'),
        ];
    }
}
