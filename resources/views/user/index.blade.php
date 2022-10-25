@extends('user.master')
@section('content')

<style>
    .page-content .header-clear-medium {
        padding: 0px !important;
    }
    .social-network .box a {

    }
    .food-box img {
        width: 100%;
        height: 140px;
        padding: 4px;
        border-radius: 8px;
    }
    .food-box body {
        
    }

    .food-box-circle img {
        width: 200px;
        height: 200px;
        border-radius: 50px;
    }
    .food-box button {
        background-color: #f00;
        padding: 6px 12px;
        border-radius: 4px;
    }
    .add-menu {
        background-color: #f00;
        padding: 5px 20px;
        color: white;
        border-radius: 30px;
    }
    .banner-res-one img {
        width: 100%;
        height: 180px;
    }
    .btn-orange {
        background-color: #FF8C00;
        color: white;
    }

    button.select-food {
        padding: 7px 24px 2px;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    #qrcode {
        width:160px;
        height:160px;
        margin-top:15px;
    }
</style>
    {{-- لیست وبینارها end --}}
    <h1 class="text-center">
        {{$restaurant->title}}
        <a href="#" class="btn btn-light text-primary" data-toggle="modal" data-target="#editresName"><i class="fa fa-edit"></i></a>
    </h1>

    {{-- banner --}}
    <div class="banner-res-one">
        @if($restaurant->banner)
            <img src="{{$restaurant->banner}}" alt="{{$restaurant->title}}">
            @if (auth()->user())
                {{ Form::open(array('route' => array('user.restaurant.destroy', $restaurant->id), 'method' => 'DELETE', 'files' => true)) }}
                    <a href="#" class="btn btn-light text-primary" data-toggle="modal" data-target="#editBanner"><i class="fa fa-edit"></i></a>
                    {{ Form::button('<i class="fa fa-trash"></i>', array('type' => 'submit', 'class' => 'btn btn-light text-danger mx-2')) }}
                {{ Form::close() }}         
            @endif
        @else
            @if (auth()->user())
                <div class="pb-4">
                    <h3 class="text-center my-4">
                        <a href="#" data-toggle="modal" data-target="#editBanner" class="add-menu bg-warning">
                            <i class="fa fa-plus text-white" aria-hidden="true" style="font-size: 20px;"></i>
                            اضافه کردن بنر
                        </a>
                    </h3>
                </div>
            @endif
        @endif
    </div>
    {{-- end banner --}}
    
    @if ($serviceCat->count())
        
        @foreach ($serviceCat as $cat)
                
            {{-- دسته غذا --}}
            <div class="d-flex p-3">
                <div class="align-self-center">
                    {{ Form::open(array('route' => array('user.restaurant-food-categories.update', $cat->id), 'method' => 'PATCH', 'files' => true)) }}
                        <div class="d-flex">
                            <h2 class="mb-0 pt-1 border-bottom">{{$cat->title}}</h2>
                            <input type="hidden" name="status" id="status" value="deactivate" >
                            <input type="hidden" name="title" id="title" value="{{$cat->title}}" >
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i><i class="fa fa-eye-slash text-danger" style="font-size: 18px;"></i>', array('type' => 'submit', 'class' => 'btn mx-2')) }}
                        </div>
                    {{ Form::close() }}
                    <p class="mt-n1 mb-0"></p>
                </div>
                <div class="align-self-center ms-auto">
                </div>
            </div> 

            @if (auth()->user())
                <a href="{{ route('user.restaurant-foods.create') }}" class="text-dark">
                    <h6 class="mb-2 mx-3">اضافه کردن به این دسته</h6>
                </a>
            @endif
            <div class="row">
                @foreach($items->where('food_type',$cat->id) as $food)

                    <div class="d-none">{{$index=1}}</div>
                    <div class="@if($index == 1) food-box @elseif($index > 1) food-box-circle @else food-box-circle @endif box px-4 px-lg-0 border rounded">
                        <div class="row mb-2">
                            <div class="col p-0">
                                <div class="body mx-2 mx-lg-3 mb-3">
                                    <h4 class="my-2" style="color: #f00;">{{$food->title}}</h4>
                                    {!! $food->text !!}
                                </div>
                            </div>
                            <div class="col-5 p-0">
                                @if ($food_photo->where('pictures_id',$food->id)->first())
                                    <img class="shadow" src="{{ $food_photo->where('pictures_id',$food->id)->first()->path }}" alt="{{$food->title}}">
                                @endif
                            </div>
                            <div class="d-flex mt-2">
                                <button class="price">
                                    <h6 class="text-white m-0 pt-1" >{{$food->price}}</h6>
                                </button>
                                @if (auth()->user())
                                    <a href="{{ route('user.restaurant-foods.edit', $food->id) }}" class="badge bg-primary px-3 p-2 mx-1" title="ویرایش">
                                        <i class="fa fa-edit" style="font-size: 16px;"></i>
                                    </a>
                                    {{ Form::open(array('route' => array('user.restaurant-foods.update', $food->id), 'method' => 'PATCH', 'files' => true)) }}
                                        @if ($food->status=='active')
                                            <input type="hidden" name="status" id="status" value="pending">
                                            {{ Form::button('<i class="fa fa-eye-slash" style="font-size: 20px;"></i>', array('type' => 'submit', 'class' => 'btn badge bg-warning p-2 mx-1')) }}
                                        @else
                                            <input type="hidden" name="status" id="status" value="active">
                                            {{ Form::button('<i class="fa fa-eye" style="font-size: 20px;"></i>', array('type' => 'submit', 'class' => 'btn badge bg-success p-2 mx-1')) }}
                                        @endif
                                    {{ Form::close() }}   
                                    <a href="#" data-toggle="modal" data-target="#deleteFood{{$food->id}}" class="badge bg-danger px-3 p-2 mx-1" title="حذف">
                                        <i class="fa fa-trash" style="font-size: 16px;"></i>
                                    </a>
                                @else
                                    <button class="select-food" onclick="factor({{$restaurant->id}} , {{$food->id}})">انتخاب</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-none">{{$index+=1}}</div>
                @endforeach
            </div>
            {{-- دسته غذا end --}}
            
        @endforeach

    @else
        @if (auth()->user())
            <h3 class="text-center mt-5">
                <a href="{{ route('user.restaurant-food-categories.create') }}" class="add-menu bg-warning">
                    <i class="fa fa-plus text-white" aria-hidden="true" style="font-size: 20px;"></i>
                    اضافه کردن
                </a>
            </h3>
        @endif
    @endif

    {{-- edit banner --}}
    <div class="modal" id="editBanner">
        <div class="modal-dialog mt-5 pt-5">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title text-center mb-2">بنر را انتخاب کنید</h5>
                    {{ Form::open(array('route' => array('user.restaurant.update', auth()->user()->id), 'method' => 'PATCH', 'files' => true)) }}
                        <div class="btn btn-file btn btn-file col-12 border mb-3">
                            انتخاب تصویر 
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="banner" accept=".jpeg,.jpg,.png" required>
                        </div>
                    {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>تایید', array('type' => 'submit', 'class' => 'btn btn-outline-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    {{-- end edit banner --}}
 
    {{-- edit name --}}
    <div class="modal" id="editresName">
        <div class="modal-dialog mt-5 pt-5">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title text-center">متن را انتخاب کنید</h5>
                    {{ Form::open(array('route' => array('user.restaurant.update', auth()->user()->id), 'method' => 'PATCH', 'files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('title', '* متن فعلی') }}
                            {{ Form::text('title',$restaurant->title, array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                    {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>ویرایش', array('type' => 'submit', 'class' => 'btn btn-outline-success mt-3')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    {{-- end edit name --}}

    @if (auth()->user())
        @foreach($items as $food)
            {{-- delete category --}}
            <div class="modal" id="deleteFood{{$food->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title text-center mb-2">حذف فایل</h5>
                            {{ Form::open(array('route' => array('user.restaurant-foods.destroy', $food->id), 'method' => 'DELETE', 'files' => true)) }}
                                <div class=" text-center">
                                    <h4 class="text-danger">این عملیات غیرقابل برگشت هست</h4>
                                    <h6>حذف فایل {{$food->title}} </h6>
                                </div>
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>حذف کردن', array('type' => 'submit', 'class' => 'btn btn-outline-danger mr-3')) }}
                            {{ Form::close() }}
                        </div>
                
                    </div>
                </div>
            </div>
            {{-- end delete category --}}
        @endforeach
    @endif
    
@endsection

