<style>
    .sclist{
        list-style: none;
    }

    .sclist li{
        line-height: 33px;
        border-bottom: 1px solid #ccc;
    }
    .slink i{
        font-size: 16px;
        margin-left: 16px;
    }
</style>
<div class="container" style="padding:30px 0;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            All Category
                        </div>
                        <div class="col-md-6">
                             <a href="{{route('admin.addcategory')}}" class="btn btn-success pull-right">Add New Category</a>
                            </div>
                    </div>
                </div>
                <div class="panel-body">
                    
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Catogrie Name</th>
                            <th>Slug </th>
                            <th>Sub Category </th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            @foreach($categories as $categorie)
                            <tr>
                                <td>{{$categorie->id}}</td>
                                <td>{{$categorie->name}}</td>
                                <td>{{$categorie->slug}}</td>
                                <td>
                                    <ul class="sclist">
                                        @foreach ($categorie->subCategories as $scategori)
                                            <li><i class="fa fa-caret-right"></i> {{$scategori->name}}
                                                 <a href="{{route('admin.editcategory',['category_slug'=>$categorie->slug,'scategory_slug'=>$scategori->slug])}}" class="slink"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="confirm('Are You Sure, You Want to delete this SubCategory?') || event.stopImmediatePropagation()" wire:click.prevent="deleteSubcategory('{{$scategori->id}}')" class="slink"><i class="fa fa-times text-danger"></i></a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{route('admin.editcategory',['category_slug'=>$categorie->slug])}}"><i class="fa fa-edit fa-2x"></i></a>
                                    <a href="#" onclick="confirm('Are You Sure, You Want to delete this Category?') || event.stopImmediatePropagation()" wire:click.prevent="deleteCategory({{$categorie->id}})" style="margin-left: 10px;"><i class="fa fa-times fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                  {{$categories->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>

