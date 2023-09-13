<?php

namespace App\Http\Livewire\Admin;

use App\Models\product;
use Livewire\Component;
use Livewire\WithPagination;
use File;

class AdminProuctComponent extends Component
{
    use WithPagination;
    public $searchterm;

    public function deleteCategory($id){
        $product = product::find($id);
        if(!empty($product->image)){
            unlink('assets/images/products'.'/'.$product->image); 
        }

        if(!empty($product->images)){
            $images = explode(",",$product->images);
            foreach($images as $image){
            $image_path  = public_path("assets/images/products/".$image."");
             if(File::exists($image_path)) {
                File::delete($image_path);
             } 
            }
        }
        $product->delete();
        session()->flash('message','Product Has been Deleted Successfully!');
   
       }
    public function render()
    {
        $search = '%' .$this->searchterm. '%';
        $products = product::where('name','LIKE',$search)
        ->orWhere('stock_status','LIKE',$search)
        ->orWhere('regular_price','LIKE',$search)
        ->orWhere('sale_price','LIKE',$search)
        ->orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.admin-prouct-component',['products'=>$products])->layout('layouts.base');  
    }
}
