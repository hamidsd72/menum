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
                            <form action="{{route('admin.food-category.update', $item->id)}}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="user_id" >نام رستوران</label>
                                        <select id="user_id" name="user_id" class="form-control">
                                            @foreach ($items as $key)
                                                <option value={{$key->id}} @if ($key->id == $item->id) selected @endif>{{$key->title}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">* نام دسته</label>
                                            <input type="text" name="title" id="title" value="{{$item->title}}" class="form-control" placeholder="سوپ - نوشیدنی - دسر">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">* نامک</label>
                                            <input type="text" name="slug" id="slug" value="{{$item->slug}}" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">* وضعیت</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="active" @if ($item->status == 'active') selected @endif>نمایش</option>
                                                <option value="deactivate" @if ($item->status == 'deactivate') selected @endif >عدم نمایش</option>
                                            </select>
                                        </div>
                                    </div>
    
                                </div>
                                <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning "><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
                                <button type="submit" class="btn btn-outline-success mr-3">ویرایش</button>
                            </form>
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
