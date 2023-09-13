<div>

<div class="container" style="padding:30px 0;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="row">
                     <div class="col-md-6">
                     All Sliders
                     </div>
                     <div class="col-md-6">
                     <a href="{{route('admin.addhomeslider')}}" class="btn btn-success pull-right">Add New Slides</a>
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
                            <th>Image</th>
                            <th>Title </th>
                            <th>Subtitle</th>
                            <th>Price</th>
                            <th>Link </th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            @foreach($sliders as $slider)
                            <tr>
                                <td>{{$slider->id}}</td>
                                <td><img src="{{asset('assets/images/sliders')}}/{{$slider->image}}" width="120" alt=""></td>
                                <td>{{$slider->title}}</td>
                                <td>{{$slider->subtitle}}</td>
                                <td>{{$slider->price}}</td>
                                <td>{{$slider->link}}</td>
                                <td>{{$slider->status==1 ? 'Active' : 'inactive'}}</td>
                                <td>{{$slider->created_at}}</td>
                                <td>
                                    <a href="{{route('admin.edithomeslider',['slide_id'=>$slider->id])}}" class="fa fa-edit fa-2x text-info"></a>
                                    <a href="#" wire:click.prevent="deleteSlide({{$slider->id}})" class="fa fa-times fa-2x text-danger"></a>
                                </td>
                      
                                
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
 