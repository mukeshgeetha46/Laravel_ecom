<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishListComponent extends Component
{

    public function removeFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-count-component','refreshComponent');
                return redirect()->route('product.shop');
            }
        }

     }


     public function moveProductFromWishlist($rowid){
        $item = Cart::instance('wishlist')->get($rowid);
        Cart::instance('wishlist')->remove($rowid);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');
        $this->emitTo('cart-count-component','refreshComponent');


     }
    public function render()
    {
        return view('livewire.wish-list-component')->layout('layouts.base');
    }
}
