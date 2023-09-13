<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboardComponent extends Component
{
    public function render()
    {
        $orders = Order::orderBy('created_at','DESC')->where('user_id',Auth::user()->id)->get()->take(10);
        $total = Order::where('status','!=','canceled')->where('user_id',Auth::user()->id)->sum('total');
        $totalPurchase = Order::where('status','!=','canceled')->where('user_id',Auth::user()->id)->count();
        $totaldelivered = Order::where('status','delivered')->where('user_id',Auth::user()->id)->count();
        $totalcancel = Order::where('status','canceled')->where('user_id',Auth::user()->id)->count();

        return view('livewire.user.user-dashboard-component',['orders'=>$orders,'total'=>$total,'totalPurchase'=>$totalPurchase,'totaldelivered'=>$totaldelivered,'totalcancel'=>$totalcancel,])->layout('layouts.base');
    }
}
