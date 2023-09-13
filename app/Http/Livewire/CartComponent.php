<?php

namespace App\Http\Livewire;
use Carbon\Carbon;
use App\Models\Coupon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartComponent extends Component
{

     public $haveCouponcode;
     public $couponcode;
     public $discount;
     public $subtotalAfterDiscount;
     public $taxAfterDiscount;
     public $totalAfterDiscount;


    public function increaseQuantity($rowid){
     $product = Cart::instance('cart')->get($rowid);
     $qty = $product->qty + 1;
     Cart::instance('cart')->update($rowid,$qty);
     $this->emitTo('cart-count-component','refreshComponent');

    }

      public function decreaseQuantity($rowid){
        $product = Cart::instance('cart')->get($rowid);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowid,$qty);
        $this->emitTo('cart-count-component','refreshComponent');

       }

      public function Switchtosaveforlater($rowid){
        $item = Cart::instance('cart')->get($rowid);
        Cart::instance('cart')->remove($rowid);
        Cart::instance('SaveForLater')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('success_message','Item has been Saved For Later');

      }

      public function Movetocart($rowid){
        $item = Cart::instance('SaveForLater')->get($rowid);
        Cart::instance('SaveForLater')->remove($rowid);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('s_success_message','Item has been Moved to cart');
      }

     public function deletefromsaveforlater($rowid){
        Cart::instance('SaveForLater')->remove($rowid);
        session()->flash('success_message','Item has been removed from save for later');

     }


      
    public function applyCouponcode(){
       $coupon = Coupon::where('code',$this->couponcode)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
       if(!$coupon){
          session()->flash('coupon_message','Coupon Code is invalid!');
          return;
       }

       session()->put('coupon',[
        'code' => $coupon->code,
        'type' => $coupon->type,
        'value' => $coupon->value,
        'cart_value' => $coupon->cart_value
       ]);
    }




       public function destroy($rowid){
        Cart::instance('cart')->remove($rowid);
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('success_message','Item has been Removed');

       }
       public function destroyAll(){
        Cart::instance('cart')->destroy();
        $this->emitTo('cart-count-component','refreshComponent');

       }

      public function removeCoupon(){
         session()->forget('coupon');
      }

      public function checkout(){
         if(Auth::check()){
            return redirect()->route('checkout');
         }else{
            return redirect()->route('login');
         }
      }

      public function setAmountForCheckout(){
         if(!Cart::instance('cart')->count() > 0){
            session()->forget('checkout');
            return;
         }
         if(session()->has('coupon')){
              session()->put('checkout',[
               'discount' => $this->discount,
               'subtotal' => $this->subtotalAfterDiscount,
               'tax' => $this->taxAfterDiscount,
               'total' => $this->totalAfterDiscount
              ]);
         }else{
            session()->put('checkout',[
               'discount' => 0,
               'subtotal' => Cart::instance('cart')->subtotal(),
               'tax' => Cart::instance('cart')->subtotal(),
               'total' => Cart::instance('cart')->total()
              ]);
         }
      }

      public function calculateDiscount(){
         if(session()->has('coupon')){
            if(session()->get('coupon')['type'] == 'fixed'){
               $this->discount = session()->get('coupon')['value'];
            }else{
               $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax'))/100;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
         }
      }

    public function render()
    {
       if(session()->has('coupon')){
          if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']){
             session()->forget('coupon');
          }else{
            $this->calculateDiscount();
          }
       }
       $this->setAmountForCheckout();

       if(Auth::check()){
         Cart::instance('cart')->store(Auth::user()->email);
     }
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
