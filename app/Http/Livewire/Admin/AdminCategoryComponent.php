<?php

namespace App\Http\Livewire\Admin;

use App\Models\category;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    use WithPagination;
   
    public function deleteCategory($id){
     $category = category::find($id);
     $category->delete();
     session()->flash('message','Category Has been Deleted Successfully');

    }

    public function deleteSubcategory($id){
         $scategory = Subcategory::find($id);
         $scategory->delete();
         session()->flash('message','SubCategory Has been Deleted Successfully');

    }

    public function render()
    {  
        $categories = category::paginate(5);
       
        return view('livewire.admin.admin-category-component',['categories'=>$categories])->layout('layouts.base');  
    }
}
