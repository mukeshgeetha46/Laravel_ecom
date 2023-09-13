<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function render()
    {
        $orders = Order::orderBy('created_at','DESC')->get()->take(10);
        $totalSales = Order::where('status','delivered')->count();
        $totalrevenue = Order::where('status','delivered')->sum('total');

        $todaySales = Order::where('status','delivered')->whereDate('created_at',Carbon::today())->count();
        $todayrevenue = Order::where('status','delivered')->whereDate('created_at',Carbon::today())->sum('total');
        return view('livewire.admin.admin-dashboard-component',[
            'orders'=>$orders,
            'totalSales'=>$totalSales,
            'totalrevenue'=>$totalrevenue,
            'todaySales'=>$todaySales,
            'todayrevenue'=>$todayrevenue
            ])->layout('layouts.base');
    }
}
