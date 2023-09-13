<?php

namespace App\Http\Livewire;

use App\Models\product;
use App\Models\sale;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class DetailsComponent extends Component
{

    protected $listeners = ['refreshComponent'=> '$refresh'];
    public $slug;
    public $qty;
    public $satt = [];
    public $action;

    public function mount($slug){
         $this->slug = $slug;
         $this->qty  = 1;
    }

    public function store($product_id,$product_name,$product_price){
        Cart::instance('cart')->add($product_id,$product_name,$this->qty,$product_price,$this->satt)->associate('App\Models\Product');
        Session()->flash('success_message','item added in cart');
        return redirect()->route('product.cart');

    }

    public function increaseQuantity(){
        $this->qty++;
    }

    public function decreaseQuantity(){
        if($this->qty > 1){
            $this->qty--;
        }
    }

    
    public function render()
    {
        $product = product::where('slug',$this->slug)->first();
        $popular_product = product::inRandomOrder()->limit(4)->get();
        $related_product = product::where('category_id',$product->category_id)->inRandomOrder()->limit(6)->get();
        $sales = sale::find(1);
        return view('livewire.details-component',['product'=>$product,'popular_product'=>$popular_product,'related_product'=>$related_product,'sales'=>$sales])->layout('layouts.base');
    }

    
}
