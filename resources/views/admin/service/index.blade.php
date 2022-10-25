@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                    <div class="col-12">
                        <div class="card res_table">
                            <div class="card-header">
                                <h3 class="card-title float-right">{{$title2}}</h3>
                                <a href="{{route('admin.service.create')}}" class="float-left btn btn-primary"><i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body res_table_in">

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if(isset($category_id)) {{App\Model\ServiceCat::where('id',$category_id)->first()->title}} @else نام رستوران @endif
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($ServiceCats as $ServiceCat)
                                            <li><a href="{{route('admin.service.list',['category_id'=>$ServiceCat->id])}}" title="Courses">{{$ServiceCat->title}}</a></li>
                                        @endforeach
                                    </div>
                                </div>

                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>نام غذا</th>
                                        <th>نام رستوران</th>
                                        <th>هزینه</th>
                                        <th>ترتیب</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $index=>$item)
                                    <tr>
                                        <td>@item($item->title)</td>
                                        <td>@item($item->category?$item->category->title:'__')</td>
                                        <td><span>@item(price($item->price))</span> تومان </td>
{{--
                                        <td class="text-center">@if($item->category and $item->category->slug=='آموزشی')<a href="{{route('admin.service.level.list',$item->id)}}" class="badge bg-primary py-2 px-3"> + افزودن  ({{count($item->levels)}})</a> @else ___ @endif </td>
--}}
{{--
                                        <td class="text-center"><a href="{{route('admin.service.plus.list',$item->id)}}" class="badge bg-info py-2 px-3"> + افزودن  ({{count($item->plus)}})</a> </td>
--}}
                                        <td class="text-center">
                                            @if($index != 0)
                                                <a href="{{route('admin.service.order',[$item->id,$items[$index-1]->id])}}" class="badge bg-primary ml-1" title=""><i class="fa fa-arrow-up"></i> </a>
                                            @endif

                                            @if(!$loop->last)
                                                    <a href="{{route('admin.service.order',[$item->id,$items[$index+1]->id])}}" class="badge bg-primary ml-1" title=""><i class="fa fa-arrow-down"></i> </a>
                                                @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin.service.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
                                            @if($item->status=='active')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','pending')" class="badge bg-success ml-1" title="نمایش فعال است غیر فعال شود؟"><i class="fa fa-check"></i> </a>
                                            @endif
                                            @if($item->status=='pending')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','active')" class="badge bg-warning ml-1" title="نمایش غیر فعال است فعال شود؟"><i class="fa fa-close"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">موردی یافت نشد</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="pag_ul">
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
        </div>
    </section>

@endsection
@section('js')
<script>
    function active_row(id,type) {
        if(type=='pending')
        {
            var text_user=' نمایش غیرفعال می شود';
        }
        if(type=='active')
        {
            var text_user=' نمایش فعال می شود';
        }
        Swal.fire({
            title: text_user ,
            text: 'برای تغییر وضعیت مطمئن هستید؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '{{url('/')}}/admin/service-active/'+id+'/'+type;
            }
        })
    }
    function del_row(id) {
        Swal.fire({
            text: 'برای حذف مطمئن هستید؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '{{url('/')}}/admin/service-destroy/'+id;
            }
        })
    }
</script>
@endsection
