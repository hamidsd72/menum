@extends('user.master')
@section('content')

    <section class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="card res_table">
                    <div class="card-header">
                        <h6 class="text-danger">{{$err_message ?? ''}}</h6>
                        <h5 class="card-title {{session()->get('locale')=='fa'? 'float-right' : 'float-left'}} p-0 mt-2">{{__('text.cat.title_sum')}}</h5>
                        <a href="{{route('user.restaurant-food-categories.create')}}" class="{{session()->get('locale')=='fa'? 'float-left' : 'float-right'}} bg-primary rounded p-1 px-3 text-light">{{ __('text.add') }}</a>
                    </div>

                    <div class="row text-center m-0">
                        <div class="col p-0 border">
                            {{ __('text.cat.cat_name') }}
                        </div>
                        <div class="col p-0 border">
                            {{ __('text.cat.status') }}
                        </div>
                        <div class="col p-0 border">
                            {{ __('text.cat.actions') }}
                        </div>
                    </div>
                    @foreach($categories as $cat)
                        <div class="row mb-0 py-2 text-center border-bottom">
                            <div class="col-4">
                                {{$cat->title}}
                            </div>
                            <div class="col-4 my-auto">
                                @if ($cat->status=="active")
                                    <i class="fa fa-eye text-success" style="font-size: 16px;"></i>
                                @else
                                    <i class="fa fa-eye-slash" style="font-size: 16px;"></i>
                                @endif
                            </div>
                            <div class="col-4">
                                <a href="{{route('user.restaurant-food-categories.edit', $cat->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                <a href="#" data-toggle="modal" data-target="#deleteCategory{{$cat->id}}" class="badge bg-danger mx-1" title="حذف"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pag_ul">
                    {{-- {{ $categories->count()? $categories->appends(request()->query())->links(): '' }} --}}
                </div>
            </div>
        </div>
    </section>

    @foreach($categories as $cat)
        {{-- edit category --}}
        <div class="modal" id="deleteCategory{{$cat->id}}">
            <div class="modal-dialog mt-5 pt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-danger">{{__('cat.modal_title')}}</h6>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{ Form::open(array('route' => array('user.restaurant-food-categories.destroy', $cat->id), 'method' => 'DELETE', 'files' => true)) }}
                            <h6>{{__('cat.modal_body').' '.$cat->title}}</h6>
                            {{ Form::button(__('cat.modal_btn'), array('type' => 'submit', 'class' => 'btn btn-outline-danger mt-3')) }}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cat.modal_btn2')}}</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- end edit category --}}
    @endforeach

@endsection
