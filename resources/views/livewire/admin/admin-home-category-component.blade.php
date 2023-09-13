<div>
    .<div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Home category
                    </div>
                    <div class="panel-body">
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                        <form class="form-horizontal" wire:submit.prevent="updateHomeCategory">
                            <div class="form-group">
                            <label for="" class="col-md-4 control-label">Choose Categories</label>
                            <div class="col-md-4">
                                <select class="sel_categories form-control" name="categories[]" multiple="multiple" wire:model="selected_categories">
                                    @foreach($categories as $categorie)
                                      <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="" class="col-md-4 control-label">No of Product</label>
                            <div class="col-md-4">
                               <input type="text" name="" value="" class="form-control input-md" wire:model="numberofproduct">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="" class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>




                        
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function(){
      $('.sel_categories').select2();
      $('.sel_categories').on('change',function(e){
     var data = $('.sel_categories').select2("val");
     @this.set('selected_categories',data);
      });
    });
</script>
@endpush