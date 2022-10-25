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
                            {{ Form::open(array('route' => 'admin.food-category.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type" >نوع خدمت</label>
                                        <select id="service_type" name="service_type" class="form-control">
                                            <option value="جلسات عمومی"  selected>(رایگان) جلسات عمومی</option>
                                            <option value="مشاوره اختصاصی" >مشاوره اختصاصی</option>
                                            <option value="عریضه نویسی" >عریضه نویسی</option>
                                        </select>
                                    </div>
                                </div>  --}}
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('user_id', '* نام رستوران') }}
                                        {{ Form::select('user_id' , Illuminate\Support\Arr::pluck($items,'title','id') , null, array('class' => 'form-control select2')) }}
                                    </div> 
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('title', '* نام دسته') }}
                                        <input type="text" name="title" id="title" class="form-control" placeholder="سوپ - نوشیدنی - دسر">
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
                                        {{ Form::label('status', '* وضعیت') }}
                                        <select id="status" name="status" class="form-control">
                                            <option value="active" selected>نمایش</option>
                                            <option value="deactivate" >عدم نمایش</option>
                                        </select>
                                    </div>
                                </div>
{{--                                <div class="col-sm-6 mb-2">--}}
{{--                                    <label for="exampleInputFile"> فایل pdf(حداکثر 30 مگابایت)</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="file" accept=".pdf">--}}
{{--                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6 mb-2">--}}
{{--                                    <label for="exampleInputFile">ویدئو mp4(حداکثر 50 مگابایت)</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="video" accept=".mp4">--}}
{{--                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('video_link', '* لینک ویدیو') }}
                                        {{ Form::text('video_link',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)')) }}
                                    </div>
                                </div> --}}

                            </div>
                            <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning "><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
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
    <script src="{{ asset('editor/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('editor/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>
        var textareaOptions = {
            filebrowserImageBrowseUrl: '{{ url('filemanager?type=Images') }}',
            filebrowserImageUploadUrl: '{{ url('filemanager/upload?type=Images&_token=') }}',
            filebrowserBrowseUrl: '{{ url('filemanager?type=Files') }}',
            filebrowserUploadUrl: '{{ url('filemanager/upload?type=Files&_token=') }}',
            language: 'fa'
        };
        $('.textarea').ckeditor(textareaOptions);
        slug('#title', '#slug');
        function number_price(a){
            $('#pp_price').text(a);
            $('#pp_price_1').text(a);
            $('#pp_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        }
        function number_price2(a){
            $('#pp_sale_count').text(a);
            $('#pp_sale_count_1').text(a);
            $('#pp_sale_count').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        }
        $(document).ready(function () {
            var a=$('#price').val();
            $('#pp_price').text(a);
            $('#pp_price_1').text(a);
            $('#pp_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        });
    </script>
@endsection
