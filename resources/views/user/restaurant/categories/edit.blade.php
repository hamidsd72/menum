@extends('user.master')
@section('content')

    <section class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="card res_table">
                    <div class="card-header">
                        <h5 class="card-title {{session()->get('locale')=='fa'? 'float-right' : 'float-left'}} mt-2">{{__('text.edit').' '.__('text.cat.title_single')}}</h5>
                    </div>
                    <div class="card-body res_table_in">
                        {{ Form::open(array('route' => array('user.restaurant-food-categories.update', $cat->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('title', __('text.cat.add_name') ) }}
                                        {{ Form::text('title',$cat->title, array('class' => 'form-control','required' => 'required')) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="status">{{ __('text.cat.add_status') }}</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="active" @if($cat->status == 'active') selected @endif>{{ __('text.cat.add_show') }}</option>
                                        <option value="deactivate" @if($cat->status == 'deactivate') selected @endif>{{ __('text.cat.add_dont_show') }}</option>
                                    </select>
                                </div>
                            </div>
                            {{ Form::button( __('text.add') , array('type' => 'submit', 'class' => 'btn btn-success mr-3')) }}
                            <a class="btn btn-secondary text-light mx-1" href="{{url()->previous()}}">{{ __('text.modal_btn2') }}</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
