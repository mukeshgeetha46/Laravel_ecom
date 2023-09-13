<?php


namespace App\Http\Livewire;

use App\Models\product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\category;
use App\Models\Subcategory;

class CategoryComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $category_slug;

    public $scategory_slug;


    public function mount($category_slug,$scategory_slug=null){
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->category_slug = $category_slug;
        $this->scategory_slug = $scategory_slug;
        
    }
    public function store($product_id,$product_name,$product_price){
        Cart::add($product_id,$product_name,1,$product_price)->associate('App\Models\product');
        Session()->flash('success_message','item added in cart');
        return redirect()->route('product.cart');

    }
    use WithPagination;
    public function render()
    {
        $category_id = null;
        $category_name = "";
        $filter = "";

         if($this->scategory_slug){
            $scategory = Subcategory::where('slug',$this->scategory_slug)->first();
            $category_id = $scategory->id;
            $category_name = $scategory->name;
            $filter = "sub";
         }else{
            $category = category::where('slug',$this->category_slug)->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $filter = "";
         }

        
        if($this->sorting=='date'){
            $products = product::where($filter.'category_id',$category_id)->orderBy('created_at','DESC')->paginate($this->pagesize);
            
        }
        else if($this->sorting=='price'){
            $products = product::where($filter.'category_id',$category_id)->orderBy('regular_price','ASC')->paginate($this->pagesize);

        }
        else if($this->sorting=='price-desc'){
            $products = product::where($filter.'category_id',$category_id)->orderBy('regular_price','DESC')->paginate($this->pagesize);

        }else{
            $products = product::where($filter.'category_id',$category_id)->paginate($this->pagesize);

        }
        $categories = category::all();
    
        return view('livewire.category-component',['products'=>$products,'categories'=>$categories,'category_name'=>$category_name])->layout('layouts.base');
    }
}

?>