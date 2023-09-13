<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\category;
use Carbon\Carbon;
use App\Models\product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use File;


class AdminEditProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $short_discription;
    public $description;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $newimage;
    public $product_id;

    public $images;
    public $newimages;
    public $scategory_id;

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values;

    public function mount($product_slug){
      $product = product::where('slug',$product_slug)->first();
      $this->name = $product->name;
      $this->slug = $product->slug;
      $this->short_discription = $product->short_discription;
      $this->description = $product->description;
      $this->regular_price = $product->regular_price;
      $this->sale_price = $product->sale_price;
      $this->SKU = $product->SKU;
      $this->stock_status = $product->stock_status;
      $this->featured = $product->featured;
      $this->quantity = $product->quantity;
      $this->image = $product->image;
      $this->images = explode(",",$product->images);
      $this->category_id = $product->category_id;
      $this->scategory_id = $product->subcategory_id;
      $this->product_id = $product->id;
      $this->inputs = $product->AttributeValues->where('product_id',$product->id)->unique('product_attribute_id')->pluck('product_attribute_id');
      $this->attribute_arr = $product->AttributeValues->where('product_id',$product->id)->unique('product_attribute_id')->pluck('product_attribute_id');

      foreach($this->attribute_arr as $a_arr){
        $allAttributeValue = AttributeValue::where('product_attribute_id',$a_arr)->get()->pluck('value');
      $valuestring ='';
        foreach($allAttributeValue as $value){
         $valuestring = $valuestring . $value . ","; 
        }

        $this->attribute_values[$a_arr] = rtrim($valuestring,",");
      }
    }


    public function add()
    {
       if(!$this->attribute_arr->contains($this->attr))
       {
          $this->inputs->push($this->attr);
          $this->attribute_arr->push($this->attr);
       }
    }

    public function remove($attr){
        unset($this->inputs[$attr]);
    }

    public function genrateSlug(){
        $this->slug  = str::slug($this->name, '-');
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name'              => 'required',
            'slug'              => 'required',
            'short_discription' => 'required',
            'description'       => 'required',
            'regular_price'     => 'required|numeric',
            'sale_price'        => 'numeric',
            'SKU'               => 'required',
            'stock_status'      => 'required',
            'quantity'          => 'required|numeric',    
            'category_id'       => 'required'
        ]);

        if($this->newimages){
            $this->validateOnly($fields,[
            'newimage' => 'required|mimes:jpeg,png'
            ]);
        }
    }

    public function updateProduct(){
        $this->validate([
            'name'              => 'required',
            'slug'              => 'required',
            'short_discription' => 'required',
            'description'       => 'required',
            'regular_price'     => 'required|numeric',
            'sale_price'        => 'numeric',
            'SKU'               => 'required',
            'stock_status'      => 'required',
            'quantity'          => 'required|numeric',
            'category_id'       => 'required'
       ]);


       if($this->newimages){
        $this->validate([
        'newimage' => 'required|mimes:jpeg,png'
        ]);
         }
        $product = product::find($this->product_id);
        $product->name  = $this->name;
        $product->slug  = $this->slug;
        $product->short_discription  = $this->short_discription;
        $product->description  = $this->description;
        $product->regular_price  = $this->regular_price;
        $product->sale_price  = $this->sale_price;
        $product->SKU  = $this->SKU;
        $product->stock_status  = $this->stock_status;
        $product->featured  = $this->featured;
        $product->quantity  = $this->quantity;
        if($this->newimage)
        {
              $image_path  = public_path("assets/images/products/".$product->image."");
              if(File::exists($image_path)) {
                File::delete($image_path);
             } 

              $imageName = Carbon::now()->timestamp. '.' . $this->newimage->extension();
              $this->newimage->storeAs('products',$imageName);
              $product->image = $imageName;
        }

        if($this->newimages)
        {
            if($product->images){
                $images = explode(",",$product->images);
                foreach($images as $image){
                    $image_path  = public_path("assets/images/products/".$image."");
                    if(File::exists($image_path)) {
                      File::delete($image_path);
                   }
                }
            }

            $imagename = '';
            foreach($this->newimages as $key => $image){
                $imgname = Carbon::now()->timestamp . $key . '.' .$image->extension();
                $image->storeAs('products',$imgname);
                $imagename = $imagename . ',' . $imgname;
            }
            $product->images = $imagename;
              
        }



        $product->category_id  = $this->category_id;
        if($this->scategory_id){
            $product->subcategory_id = $this->scategory_id;
        }
        $product->save();

        AttributeValue::where('product_id',$product->id)->delete();
        foreach($this->attribute_values as $key => $attribute_value){
            $values = explode(",",$attribute_value);
            foreach($values as $value){
                $attr_value = new AttributeValue();
                $attr_value->product_attribute_id = $key;
                $attr_value->value = $value;
                $attr_value->product_id = $product->id;
                $attr_value->save();

            }
        }
        session()->flash('message','Product has been Updated Successfully!');
    }

    public function changeSubcategory(){
        $this->scategory_id = 0;
    }

    public function render()
    {
        $categorys = category::all();
        $scategorys = Subcategory::where('category_id',$this->category_id)->get();
        $pattributes = ProductAttribute::all();
        return view('livewire.admin.admin-edit-product-component',['categorys'=>$categorys,'scategorys'=>$scategorys,'pattributes'=>$pattributes])->layout('layouts.base');  
    }
}
