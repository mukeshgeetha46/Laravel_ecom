<?php

namespace App\Http\Livewire\Admin;

use App\Models\category;
use App\Models\HomeCategory;
use Livewire\Component;

class AdminHomeCategoryComponent extends Component
{
    public $selected_categories = [];
    public $numberofproduct;


    public function mount(){
        $categories = HomeCategory::find(1);
        $this->selected_categories = explode(',',$categories->sel_categories);
        $this->numberofproduct  = $categories->no_of_product;
    }

    public function updateHomeCategory(){
        $categorie = HomeCategory::find(1);
        $categorie->sel_categories = implode(',',$this->selected_categories);
        $categorie->no_of_product = $this->numberofproduct;
        $categorie->save();
        session()->flash('message','HomeCategory has been Updated Successfully!');
    }
    public function render()
    {
        $categories = category::all();
        return view('livewire.admin.admin-home-category-component',['categories'=>$categories])->layout('layouts.base');
    }
}
