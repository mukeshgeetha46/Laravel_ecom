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
                            All Attributes
                        </div>
                        <div class="col-md-6">
                             <a href="{{route('admin.add_attributes')}}" class="btn btn-success pull-right">Add New Category</a>
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
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            @foreach($pattributes as $pattribute)
                            <tr>
                                <td>{{$pattribute->id}}</td>
                                <td>{{$pattribute->name}}</td>
                                <td>{{$pattribute->created_at}}</td>
                                
                                <td>
                                    <a href="{{route('admin.edit_attributes',['attribute_id'=>$pattribute->id])}}"><i class="fa fa-edit fa-2x"></i></a>
                                    <a href="#" onclick="confirm('Are You Sure, You Want to delete this Category?') || event.stopImmediatePropagation()" wire:click.prevent="deleteAttribute({{$pattribute->id}})"  style="margin-left: 10px;"><i class="fa fa-times fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                  {{$pattributes->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

