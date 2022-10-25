<form action="{{route('user.restaurant-food-categories.update', $cat->id)}}" method="POST">
    @csrf
    @method('PATCH')
    <div class="food-box-circle box">
        {{-- @if ($food_photo->where('pictures_id',$food->id)->first())
        @endif --}}
        <div class="body px-2 px-lg-3">
            <input type="hidden" name="status" id="status" value="deactivate" >
            <input type="hidden" name="title" id="title" value="{{$cat->title}}" >
            <img class="custom menu-img" src="https://menum.online/source/asset/uploads/service/1401-03-02/photos/photo-7607e710fd3cd0320e7d8b5ed0a3abf6.jpeg" alt="">
            @if (\Request::route()->getName() == 'user.index')
                <button type="submit" style="width: 50%;">
                    <div class="abs">
                        <i class="fa fa-eye-slash text-dark" style="font-size: 16px;"></i>
                    </div>  
                </button>
            @endif
            <h4 class="menu-name" >{{$cat->title}}</h4>
        </div>
    </div>
</form>