<div class="food-box-circle box px-1 px-lg-3">
    <div class="cover">
        @if ($food_photo->where('pictures_id',$food->id)->first())
            <div class="text-center">
                <img class="custom shadow" src="{{ url($food_photo->where('pictures_id',$food->id)->first()->path) }}" alt="{{$food->title}}">
            </div>
        @endif
        <div class="body">
            <h6>{{$food->price}}</h6>
            <h4>{{$food->title}}</h4>
            {{ $food->text }}
            <div class="d-flex mt-2">
                @if (\Request::route()->getName() == 'user.index')
                    <a href="{{ route('user.restaurant-foods.edit', $food->id) }}" class="badge bg-primary px-3 p-2 mx-1" title="ویرایش">
                        <i class="fa fa-edit" style="font-size: 14px;"></i>
                    </a>
                    {{ Form::open(array('route' => array('user.restaurant-foods.update', $food->id), 'method' => 'PATCH', 'files' => true)) }}
                        @if ($food->status=='active')
                            <input type="hidden" name="status" id="status" value="pending">
                            {{ Form::button('<i class="fa fa-eye-slash" style="font-size: 14px;"></i>', array('type' => 'submit', 'class' => 'btn badge bg-warning p-custome-1 mx-1')) }}
                        @else
                            <input type="hidden" name="status" id="status" value="active">
                            {{ Form::button('<i class="fa fa-eye" style="font-size: 14px;"></i>', array('type' => 'submit', 'class' => 'btn badge bg-success p-custome-1 mx-1')) }}
                        @endif
                    {{ Form::close() }}   
                    <a href="#" data-toggle="modal" data-target="#deleteFood{{$food->id}}" class="badge bg-danger px-3 p-2 mx-1" title="حذف">
                        <i class="fa fa-trash" style="font-size: 14px;"></i>
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>