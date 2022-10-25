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
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{$item->photo? url($item->photo->path) :asset('admin/img/user.png')}}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">@item($item->first_name) @item($item->last_name)</h3>
                            <hr>
                            {{-- {{ Form::model($item,array('route' => array('admin.profile.update', $item->id), 'method' => 'POST', 'files' => true)) }} --}}
                            {{ Form::model($item,array('route' => array('admin.profile.update', $item->id), 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('first_name', '* نام') }}
                                            {{ Form::text('first_name',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('last_name', '* نام خانوادگی') }}
                                            {{ Form::text('last_name',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('mobile', '* موبایل') }}
                                            {{ Form::text('mobile',null, array('class' => 'form-control text-left','readonly')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('email', '* ایمیل') }}
                                            {{ Form::email('email',null, array('class' => 'form-control text-left' , $item->email==null?'':$item->email_status=='active'?'readonly':'')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('whatsapp', '* شماره واتساپ فعال') }}
                                            {{ Form::text('whatsapp',null, array('class' => 'form-control text-left')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('date_birth', '* تاریخ تولد') }}
                                            {{ Form::text('date_birth',null, array('class' => 'form-control text-left date_p' , 'readonly')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('state_id', '* استان') }}
                                            {{ Form::select('state_id' , Illuminate\Support\Arr::pluck($states,'name','id') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('city_id', '* شهر') }}
                                            {{ Form::select('city_id' , Illuminate\Support\Arr::pluck($citys,'name','id') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('locate', '* منطقه') }}
                                            {{ Form::text('locate',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            {{ Form::label('address', '* آدرس') }}
                                            {{ Form::text('address',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('education', '* مدرک تحصیلی') }}
                                            {{ Form::text('education',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputFile">تصویر پروفایل</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning"><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>ویرایش', array('type' => 'submit', 'class' => 'btn btn-outline-success mr-3')) }}
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
    $('.date_p').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        initialValue:false,
    });
        $(document).ready(function () {
            $('select[name=state_id]').on('change', function () {
                $.get("{{url('/')}}/city-ajax/" + $(this).val(), function (data, status) {
                    $('select[name=city_id]').empty();
                    $.each(data, function (key, value) {
                        $('select[name=city_id]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('select[name=city_id]').trigger('change');
                });
            });
        });
</script>
@endsection