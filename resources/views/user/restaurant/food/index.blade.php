@extends('user.master')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="card res_table">
                    <div class="card-header">
                        <h5 class="card-title {{session()->get('locale')=='fa'? 'float-right' : 'float-left'}} mt-2">{{__('text.food.title_sum')}}</h5>
                        <a href="{{ route('user.restaurant-foods.create') }}" class="{{session()->get('locale')=='fa'? 'float-left' : 'float-right'}} bg-primary rounded p-1 px-3 text-light">{{ __('text.add') }}</a>
                        @if ($categories->count())
                            <div class="dropdown px-1 {{session()->get('locale')=='fa'? 'float-left' : 'float-right'}}" style="position: unset;">
                                <button class="btn btn-secondary dropdown-toggle mx-2" style="font-size: 13px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(isset($category_id)) {{App\Model\Category::where('id',$category_id)->first()->title}} @else {{ __('text.food.cats') }} @endif
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($categories as $ServiceCat)
                                        <li class="border-bottom px-2"><a class="fix" href="{{route('user.restaurant-foods.show',$ServiceCat->id)}}" title="category">{{$ServiceCat->title}}</a></li>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row text-center m-0">
                        <div class="col p-0 border">
                            {{ __('text.food.name') }}
                        </div>
                        <div class="col p-0 border">
                                {{ __('text.food.cat_name') }}
                        </div>
                        {{-- <div class="col-2 p-0 border">
                            نمایش
                        </div> --}}
                        <div class="col p-0 border">
                            {{ __('text.food.price') }}
                        </div>
                        <div class="col p-0 border">
                            {{ __('text.food.actions') }}
                        </div>
                    </div>
                    @foreach($foods as $item)
                        <div class="row mb-0 py-2 text-center border-bottom">
                            <div class="col">
                                {{$item->title}}
                            </div>
                            <div class="col">
                                {{ $categories->where('id', $item->food_type)->first()? $categories->where('id', $item->food_type)->first()->title: '_____' }} 
                            </div>
                            {{-- <div class="col-2">
                                @if ($item->status=="active")
                                    <i class="fa fa-eye text-success" style="font-size: 16px;"></i>
                                @else
                                    <i class="fa fa-eye-slash" style="font-size: 16px;"></i>
                                @endif
                            </div> --}}
                            <div class="col">
                                @item(price($item->price))
                            </div>
                            <div class="col">
                                <a href="{{route('user.restaurant-foods.edit', $item->id)}}" class="badge bg-primary ml-1" title="{{ __('text.delete') }}"><i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="modal" data-target="#deleteFood{{$item->id}}" class="badge bg-danger mx-1" title="{{ __('text.edit') }}"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pag_ul">
                    {{-- {{ $foods->count()? $foods->appends(request()->query())->links(): '' }} --}}
                </div>
            </div>
        </div>
    </section>

    @foreach($foods as $food)
        {{-- delete category --}}
        <div class="modal" id="deleteFood{{$food->id}}">
            <div class="modal-dialog mt-5 pt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-danger">{{__('cat.modal_title')}}</h6>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('route' => array('user.restaurant-foods.destroy', $food->id), 'method' => 'DELETE', 'files' => true)) }}
                            <h6 class="mb-3">{{__('cat.modal_body').' '.$food->title}}</h6>
                            {{ Form::button(__('cat.modal_btn'), array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cat.modal_btn2')}}</button>
                        {{ Form::close() }}
                    </div>
            
                </div>
            </div>
        </div>
        {{-- end delete category --}}
    @endforeach

@endsection
