<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request){
        if(empty($request->component)){
            $qty = 1;
        }else{
            $qty = $request->qty;  
        }
        Cart::instance('cart')->add($request->p_id,$request->p_name,$qty,$request->p_price)->associate('App\Models\Product');
        
        echo '<div class="wrap-icon-section minicart">
        <a href="'.route('product.cart').'" class="link-direction">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
            <div class="left-info">';
                if(Cart::instance('cart')->count()>0){
                    echo '<span class="index">'.Cart::instance('cart')->count().' items</span>';
                }
                echo '<span class="title">CART</span></div>
                </a></div>';
        
    }

    public function sorting(Request $request){
   
       $pagesize = $request->pagesize;

        if($request->sorting=='date'){
            $productss = product::whereBetween('regular_price',[$request->minval,$request->maxval])->orderBy('created_at','DESC')->paginate($pagesize);
            
        }
        else if($request->sorting=='price'){
            $productss = product::whereBetween('regular_price',[$request->minval,$request->maxval])->orderBy('regular_price','ASC')->paginate($pagesize);

        }
        else if($request->sorting=='price-desc'){
            $productss = product::whereBetween('regular_price',[$request->minval,$request->maxval])->orderBy('regular_price','DESC')->paginate($pagesize);

        }else{
            $productss = product::whereBetween('regular_price',[$request->minval,$request->maxval])->paginate($pagesize);
            
        }
        $witems = Cart::instance('wishlist')->content()->pluck('id');
        echo '<ul class="product-list grid-products equal-container" id="productlist">';
       
        foreach($productss as $product){
            echo  '<li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
            <div class="product product-style-3 equal-elem ">
            <div class="product-thumnail">
            <a href="'.route('product.details',['slug'=>$product->slug]).'" title="'.$product->name.'">
            <figure><img src="'.asset('assets/images/products').'/'.$product->image.'" alt="'.$product->name.'"></figure>

			</a>
			</div>
            <div class="product-info">
            <a href="'.route('product.details',['slug'=>$product->slug]).'" class="product-name"><span>'.$product->name.'</span></a>
            <div class="wrap-price"><span class="product-price">'.$product->regular_price.'</span></div>
            <a href="javascript:void(0);" id="addtocart" class="btn add-to-cart" data-id="'.$product->id.'" data-name="'.$product->name.'" data-price="'.$product->regular_price.'">Add To Cart</a>
            <div class="product-wish">';
            if($witems->contains($product->id)){
               echo '<a href="#" id="removewishlist" data-id="'.$product->id.'"><i class="fa fa-heart fill-heart"></i></a>';
            }else{
                echo '<a href="#" id="addwishlist" data-id="'.$product->id.'" data-name="'.$product->name.'" data-price="'.$product->regular_price.'"><i class="fa fa-heart"></i></a>';
            }
            echo '</div>
            </div>
        </div>
    </li>';
        }
       echo '</ul>';
       echo '<div class="wrap-pagination-info">'.$productss->links('pagination::bootstrap-4').'</div>';           
    }


    public function removewishlist(Request $request){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id == $request->p_id){
                Cart::instance('wishlist')->remove($witem->rowId);
            }
        }
        
        echo '<a href="'.route('product.wishlist').'" class="link-direction">
        <i class="fa fa-heart" aria-hidden="true"></i>
        <div class="left-info">';
            if (Cart::instance('wishlist')->count() > 0){
            echo '<span class="index">'.Cart::instance('wishlist')->count().' item</span>';	
            echo '<span class="title">Wishlist</span>';
            }else{
            echo '<span class="index">0 item</span>';	
            echo '<span class="title">Wishlist</span>';
            }
            
            echo '</div>';
            echo '</a>'; 
    }

    public function addwishlist(Request $request){
       
        Cart::instance('wishlist')->add($request->p_id,$request->p_name,$request->qty,$request->p_price)->associate('App\Models\Product');
   
        echo '<a href="'.route('product.wishlist').'" class="link-direction">
        <i class="fa fa-heart" aria-hidden="true"></i>
        <div class="left-info">';
            if (Cart::instance('wishlist')->count() > 0){
            echo '<span class="index">'.Cart::instance('wishlist')->count().' item</span>';	
            echo '<span class="title">Wishlist</span>';
            }else{
                echo '<span class="index">0 item</span>';	
                echo '<span class="title">Wishlist</span>';
            }
           
            echo '</div>';
            echo '</a>'; 
    }
}



