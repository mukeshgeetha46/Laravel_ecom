<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

class AdminAddHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $status;

    public function mount(){
        $this->status = 0;
    }

    public function addSlider(){
        $slider = new HomeSlider();
        $slider->title  = $this->title;
        $slider->subtitle  = $this->subtitle;
        $slider->price  = $this->price;
        $slider->link  = $this->link;
        $imagename  = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('sliders',$imagename);
        $slider->image  = $imagename;
        $slider->status  = $this->status;
        $slider->save();
        session()->flash('message','Slider Has been Created Successfully!');
    }
    public function render()
    {
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.base');
    }
}
