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
                                <a href="{{route('admin.service.level.create',$service->id)}}" class="float-left btn btn-primary"><i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>عنوان سطح</th>
                                        <th> سوالات</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $item)
                                    <tr>
                                        <td>@item($item->title) (@item($item->level))</td>
                                        <td class="text-center"><a href="{{route('admin.service.query.list',$item->id)}}" class="badge bg-primary py-2 px-3"> + افزودن سوال ({{count($item->questions)}})</a></td>
                                        <td class="text-center">
                                            <a href="{{route('admin.service.level.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
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
                        <div class="d-flex text-left">
                            <a href="{{route('admin.service.list')}}" class="float-left btn btn-warning w-25 mb-2 mx-auto"><i class="fa fa-circle-o mtp-1 ml-1"></i>بازگشت به لیست خدمات</a>
                        </div>
                        </div>
                        <div class="pag_ul">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
        </div>
    </section>

@endsection
@section('js')
<script>
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
                location.href = '{{url('/')}}/admin/service-level-destroy/'+id;
            }
        })
    }
</script>
@endsection
