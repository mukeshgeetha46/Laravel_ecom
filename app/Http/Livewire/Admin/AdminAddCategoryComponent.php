<?php

namespace App\Http\Livewire\Admin;

use App\Models\category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;
class AdminAddCategoryComponent extends Component
{
    public $name;
    public $slug;
    public $category_id;

    public function generateslug(){
        $this->slug = str::slug($this->name);
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
    }


    public function StoreCategory(){

        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);

        if($this->category_id){
            $category = new Subcategory();
            $category->name = $this->name;
            $category->slug = $this->slug;
            $category->category_id = $this->category_id;
            $category->save();
        }else{
            $category = new category();
            $category->name = $this->name;
            $category->slug = $this->slug;
            $category->save(); 
        }

        
        session()->flash('message','Category Has been Created Successfully');
    }
    public function render()
    {
        $catogries = category::all();
        return view('livewire.admin.admin-add-category-component',['catogries'=>$catogries])->layout('layouts.base');
    }
}
