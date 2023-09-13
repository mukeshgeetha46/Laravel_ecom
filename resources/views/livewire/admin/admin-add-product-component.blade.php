<div>

    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <div class="row">
                         <div class="col-md-6">
                         Add New Product
                         </div>
                         <div class="col-md-6">
                         <a href="{{route('admin.products')}}" class="btn btn-success pull-right">All Product</a>
                         </div>
                      </div>
                    </div>
                    <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('message')}}
                        </div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="addProduct">
                            <div class="form-group">
                                <label for="" class="col-md-4">Product Name</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="Product Name" class="form-control input-md" wire:model="name" wire:keyup="genrateSlug">
                                    @error('name') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Product Slug</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="Product Slug" class="form-control input-md" wire:model="slug">
                                    @error('slug') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Short Description</label>
                                <div class="col-md-4">
                                   <textarea rows="" cols="" class="form-control" placeholder="Short Description"  wire:model="short_discription"></textarea>
                                   @error('short_discription') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Description</label>
                                <div class="col-md-4">
                                   <textarea rows="" cols="" class="form-control" placeholder="Description" wire:model="description"></textarea>
                                   @error('description') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Regular Price</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="Regular Price" class="form-control input-md" wire:model="regular_price">
                                    @error('regular_price') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Sales Price</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="Sales Price" class="form-control input-md" wire:model="sale_price">
                                    @error('sale_price') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">SKU</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="SKU" class="form-control input-md" wire:model="SKU">
                                    @error('SKU') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Stock Status</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="stock_status">
                                        <option value="instock">Instock</option>
                                        <option value="outofstock">Out Of stock</option>
                                    </select>
                                    @error('stock_status') <p class="text-danger">{{$message}}</p> @enderror
    
                                   </div>
    
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Featured</label>
                                <div class="col-md-4">
                                    <select class="form-control" wire:model="featured">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                   </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Quantity</label>
                                <div class="col-md-4">
                                    <input type="text" name="" value="" placeholder="Quantity" class="form-control input-md" wire:model="quantity">
                                    @error('quantity') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4">Product Image</label>
                                <div class="col-md-4">
                                    <input type="file"  class="input-file"  wire:model="image">
    
                                    @if($image)
                                    <img src="{{$image->temporaryUrl()}}" width="120" alt="">
                                    @endif
                                    @error('image') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-md-4">Product Gallery</label>
                                <div class="col-md-4">
                                    <input type="file"  class="input-file"  wire:model="images" multiple>
    
                                    @if($images)
                                    @foreach ($images as $image)
                                    <img src="{{$image->temporaryUrl()}}" width="120" alt="">
                                    @endforeach
                                    
                                    @endif
                                    @error('images') <p class="text-danger">{{$message}}</p> @enderror
    
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="" class="col-md-4">Category</label>
                                <div class="col-md-4">
                                    <select class="form-control"  wire:model="category_id" wire:change="changeSubcategory">
                                        <option value="">Select Category</option>
                                         @foreach($categorys as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                         @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{$message}}</p> @enderror
    
                                   </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4">Sub Category</label>
                                <div class="col-md-4">
                                    <select class="form-control"  wire:model="scategory_id">
                                        <option value="0">Select Category</option>
                                         @foreach($scategorys as $scategory)
                                        <option value="{{$scategory->id}}">{{$scategory->name}}</option>
                                         @endforeach
                                    </select>
                                    @error('scategory_id') <p class="text-danger">{{$message}}</p> @enderror
    
                                   </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4">Product Attribute</label>
                                <div class="col-md-3">
                                    <select class="form-control"  wire:model="attr">
                                        <option value="0">Select Attribute</option>
                                         @foreach($pattributes as $pattribute)
                                        <option value="{{$pattribute->id}}">{{$pattribute->name}}</option>
                                         @endforeach
                                    </select>
    
                                   </div>
                                   <div class="col-md-1">
                                     <button type="button" class="btn btn-info" wire:click.prevent="add">Add</button>
                                   </div>
                            </div>
                             @foreach ($inputs as $key => $value)
                             <div class="form-group">
                                <label for="" class="col-md-4">{{$pattributes->where('id',$attribute_arr[$key])->first()->name}}</label>
                                <div class="col-md-3">
                                    <input type="text" name="" value="" placeholder="{{$pattributes->where('id',$attribute_arr[$key])->first()->name}}" class="form-control input-md" wire:model="attribute_values.{{$value}}">
    
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})">Remove</button>
                                </div>
                            </div>
                             @endforeach
                            <div class="form-group">
                                <label for="" class="col-md-4"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    </div>
     