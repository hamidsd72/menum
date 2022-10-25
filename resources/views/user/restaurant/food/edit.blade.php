@extends('user.master')
@section('content')

<style>
    .res_table .add-group-plus {
        padding: 7px 12px 0px;
        margin: 1px 4px 1px 0px;
        border: 1px solid #ced4da;
        color: #ced4da;
        border-radius: 4px;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>

    <section class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card res_table">
                        <div class="card-header">
                            <h5 class="card-title {{session()->get('locale')=='fa'? 'float-right' : 'float-left'}} mt-2">{{__('text.edit').' '.__('text.food.title_single')}}</h5>
                            {{-- <a href="{{ route('user.restaurant-foods.create') }}" class="float-left btn btn-primary"><i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن دسته بندی</a> --}}
                        </div>
                        <div class="card-body res_table_in">
                            {{ Form::open(array('route' => array('user.restaurant-foods.update', $food->id), 'method' => 'PATCH', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('title',  __('text.food.add_name') ) }}
                                            {{ Form::text('title',$food->title, array('class' => 'form-control','required' => 'required')) }}
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('slug', '* نامک') }}
                                            {{ Form::text('slug',$food->slug, array('class' => 'form-control')) }}
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        {{ Form::label('food_type', __('text.food.add_type')) }}
                                        <div class="form-group" style="display: flex">
                                            <br>
                                            <select id="food_type" name="food_type" class="form-control select2" required>
                                                @foreach ($categories as $item)
                                                    <option value="{{$item->id}}" @if($categories[0]->id == $item->id) selected @endif @if($item->status=='deactivate') disabled @endif>
                                                        {{$item->title}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <a href="#" class="add-group-plus" data-toggle="modal" data-target="#addCategory">
                                                <i class="fa fa-plus mt-1 text-dark" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('info_plus', '* ارايه غذا') }}
                                            <select id="info_plus" name="info_plus" class="form-control">
                                                <option value=1 selected >غذا موجود هست</option>
                                                <option value=0 >غذا تمام شده</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('price',  __('text.food.add_price') ) }}
                                            {{ Form::number('price',$food->price, array('class' => 'form-control','required' => 'required','onkeyup'=>'number_price(this.value)')) }}
                                            <span id="price_span" class="span_p"><span id="pp_price"></span> تومان </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">{{ __('text.food.add_status') }}</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="active" @if($food->status == 'active') selected @endif>{{__('text.food.add_show')}}</option>
                                            <option value="pending" @if($food->status == 'pending') selected @endif>{{__('text.food.add_dont_show')}}</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('sale_count', '* تخفیف') }}
                                            {{ Form::number('sale_count',$food->sale_count, array('class' => 'form-control','onkeyup'=>'number_price2(this.value)')) }}
                                            <span id="sale_count_span" class="span_p"><span id="pp_sale_count"></span> تومان </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('time', '* زمان تقریبی تهیه غذا (دقیقه)') }}
                                            {{ Form::number('time',$food->time, array('class' => 'form-control text-left')) }}
                                            </div>
                                        </div> 
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('limited', '* تعداد غذا') }}
                                                {{ Form::number('limited',$food->limited, array('class' => 'form-control text-left')) }}
                                            </div>
                                        </div> --}}
                                    <div class="col-md-6">
                                        <label for="exampleInputFile">{{ __('text.food.add_img_size') }}</label>
                                        <div class="btn btn-file mt-2 col-12 border" style="color: #6c757d;">
                                            @if($food_photo && $food_photo->path)
                                                {{ __('text.food.edit_img') }}
                                            @else 
                                                {{ __('text.food.add_img') }}
                                            @endif
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png" >
                                        </div>
    
                                        @if($food_photo && $food_photo->path)
                                            <img src="{{url($food_photo->path)}}" class="mt-2" height="100" alt="{{$food->title}}">
                                        @endif
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="exampleInputFile">* تصویر(500×500)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                        @if($food_photo && $food_photo->path)
                                            <img src="{{url($food_photo->path)}}" class="mt-2" height="100" alt="{{$food->title}}">
                                        @endif
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('text', __('text.food.add_description')) }}
                                            {{ Form::textarea('text',$food->text, array('class' => 'form-control textarea','rows' => 3,'required' => 'required','onkeyup'=>'number_price(this.value)')) }}
                                        </div>
                                    </div>
                
                                </div>
                            {{ Form::button(__('text.add'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
                            <a class="btn btn-secondary text-light mx-1" href="{{url()->previous()}}">{{__('text.modal_btn2')}}</a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div> 
    </section>

    <!-- modal add category -->
    <div class="modal" id="addCategory">
        <div class="modal-dialog mt-5 pt-5">
            <div class="modal-content">
        
                <div class="modal-header">
                    <h5 class="modal-title">{{__('text.cat.add_cat')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{Form::open(array('route' => 'user.restaurant-food-categories2-create2', 'method' => 'POST', 'files' => true)) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('title', __('text.cat.cat_name') ) }}
                                    {{ Form::text('title',null, array('class' => 'form-control','required' => 'required')) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="">{{ __('text.food.add_status') }}</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="active" selected>{{__('text.food.add_show')}}</option>
                                    <option value="deactivate" >{{__('text.food.add_dont_show')}}</option>
                                </select>
                            </div>
                        </div>
                        {{ Form::button(__('text.edit'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('text.modal_btn2')}}</button>
                    {{ Form::close() }}
                </div>
        
            </div>
        </div>
    </div>

@endsection

<script>
    function number_price(a){
        $('#pp_price').text(a);
        $('#pp_price_1').text(a);
        $('#pp_price').text(function (e, n) {
            var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return lir1;
        })
    }
</script>