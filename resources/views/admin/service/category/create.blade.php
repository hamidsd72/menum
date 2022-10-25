@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::open(array('route' => 'admin.service.category.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('user_id', '* کاربر') }}
                                        {{ Form::select('user_id' , Illuminate\Support\Arr::pluck($users,'mobile','id') , null, array('class' => 'form-control select2')) }}
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('title', '* نام') }}
                                        {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('slug', '* نامک') }}
                                        {{ Form::text('slug',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('email', '* ایمیل') }}
                                        {{ Form::email('email',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('address', '* ادرس') }}
                                        {{ Form::text('address',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputFile">* تصویر(500×500)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="banner" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                    @if($item->banner)
                                        <img src="{{url($item->banner)}}" class="mt-2" height="100">
                                    @endif
                                </div>
                            </div>
                            <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning"><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن', array('type' => 'submit', 'class' => 'btn btn-outline-success mr-3')) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        slug('#title', '#slug');
    </script>
@endsection