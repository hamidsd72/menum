<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$setting->title}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{url($setting->icon_site)}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/select2/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap-rtl.min.css')}}">

    <!-- template rtl version -->
    <link rel="stylesheet" href="{{asset('admin/css/custom-style.css')}}">
    <!-- Persian Data Picker -->
    <link rel="stylesheet" href="{{asset('admin/css/persian-datepicker.min.css')}}">

    @yield('css')
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('user.index')}}" target="_blank" class="nav-link">@item($setting->title)</a>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown has-treeview">
                <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-user ml-1"></i>
                        @item(Auth::user()->first_name) @item(auth()->user()->last_name)
                        <i class="right fa fa-angle-down mr-1"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-sm">
                    <a href="{{route('admin.profile.show')}}" class="dropdown-item">
                        <i class="fa fa-user ml-1"></i>
                        پروفایل
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off ml-1"></i>
                        خروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="javascript:void(0);" class="brand-link">
            <img src="{{url($setting->logo_site)}}" alt="AdminLTE Logo" class="brand-image">
            @role('مدیر')
            <span class="brand-text font-weight-light">پنل مدیریت</span>
            @endrole
            @role('نماینده')
            <span class="brand-text font-weight-light">پنل نماینده</span>
            @endrole
            @role('بازاریاب')
            <span class="brand-text font-weight-light">پنل بازاریاب</span>
            @endrole
            @role('کاربر')
            <span class="brand-text font-weight-light">پنل کاربری</span>
            @endrole
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="direction: ltr">
            <div style="direction: rtl">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{Auth::user()->photo? url(Auth::user()->photo->path) :asset('admin/img/user.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{route('admin.profile.show')}}" title="نمایش پروفایل" class="d-block">@item(Auth::user()->first_name) @item(auth()->user()->last_name)</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        @hasanyrole('مدیر|کاربر|نماینده|بازاریاب')
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    داشبورد
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.profile.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>ویرایش پروفایل</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.password.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>ویرایش رمز عبور</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endhasanyrole
                        @role('نماینده')
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.user.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        @role('بازاریاب')
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.user.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        @role('مدیر')
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.user.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.marketer.list')}}" class="nav-link">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>لیست بازاریاب ها</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.agent.list')}}" class="nav-link">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>لیست نمایندگان</p>--}}
                                        {{--@if($agent>0)--}}
                                            {{--<span class="right badge badge-danger">جدید</span>--}}
                                        {{--@endif--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.agent.request.list')}}" class="nav-link">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>درخواست نمایندگی</p>--}}
                                        {{--@if($agent_request>0)--}}
                                            {{--<span class="right badge badge-danger">جدید</span>--}}
                                        {{--@endif--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>
                                    محتوا اپلیکیشن
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.slider.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>موارد ویژه</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{route('admin.customer.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>مشتریان</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{route('admin.contact.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>تیکت مشاوره</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.about.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>درباره ما</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{route('admin.guide.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>راهنمای نحوه خرید</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{route('admin.rule.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>قوانین سدارکارت</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.off.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>کد های تخفیف</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-th"></i>
                                <p>
                                    خدمات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.service.category.list')}}" class="nav-link ">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>رستوران ها</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.food-category.index')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>دسته خدمات رستوران ها</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.service.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>غذا های رستوران ها</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{route('admin.service.package.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نوع سرویس رستوران</p>
                                    </a>
                                </li> --}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.service.learn.list')}}" class="nav-link">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>لیست خدمات آموزشگاهی</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.learn.package.category.list')}}" class="nav-link ">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>دسته بندی پکیج ها</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="{{route('admin.service.learn.package.list')}}" class="nav-link">--}}
                                        {{--<i class="fa fa-circle-o nav-icon"></i>--}}
                                        {{--<p>پکیج آموزشگاهی</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                <li class="nav-item">
                                    <a href="{{route('admin.service.buy.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>
                                             لیست خرید
{{--                                            @if($order>0)--}}
{{--                                            <span class="right badge badge-danger">جدید</span>--}}
{{--                                            @endif--}}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-pie-chart"></i>
                                <p>
                                    گزارشات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.report.transaction.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p> تراکنش ها</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>
                                    تنظیمات سایت
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">
                                <li class="nav-item">
                                    <a href="{{route('admin.setting.edit')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>تنظیمات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.meta.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Meta</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @endrole


                        @role('کاربر')

                        <li class="nav-item has-treeview">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-icon fa fa-th"></i>
                                <p>
                                    خدمات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview border-bottom">

                                <li class="nav-item">
                                    <a href="{{route('admin.service.buy.list')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>
                                            لیست خرید پکیج ها
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$title1}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item active">{{$title2}}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <hr class="mt-0">
        <!-- /.content-header -->

        <!-- Content Header (Page header) -->
        @yield('content')
    </div>

    <footer class="main-footer text-left">
        <strong>copyright &copy; 2021 <a href="https://adib-it.com/">Adib Groupe</a>.</strong>
    </footer>
</div>

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>--}}
{{--<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->--}}
{{--<script>--}}
{{--    $.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{--<!-- Morris.js charts -->--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>--}}
{{--<script src="{{asset('admin/plugins/morris/morris.min.js')}}"></script>--}}
{{--<!-- Sparkline -->--}}
{{--<script src="{{asset('admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
{{--<!-- jvectormap -->--}}
{{--<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>--}}
{{--<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<!-- jQuery Knob Chart -->--}}
{{--<script src="{{asset('admin/plugins/knob/jquery.knob.js')}}"></script>--}}
{{--<!-- daterangepicker -->--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>--}}
{{--<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>--}}
{{--<!-- datepicker -->--}}
{{--<script src="{{asset('admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>--}}

{{--<!-- Slimscroll -->--}}
{{--<script src="{{asset('admin/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
<!-- FastClick -->
{{--<script src="{{asset('admin/plugins/fastclick/fastclick.js')}}"></script>--}}
<!-- AdminLTE App -->
<script src="{{asset('admin/js/adminlte.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/js/demo.js')}}"></script>
<!-- Persian Data Picker -->
<script src="{{asset('admin/js/persian-date.min.js')}}"></script>
<script src="{{asset('admin/js/persian-datepicker.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('admin/plugins/select2/select2.full.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>

<script>
    new ClipboardJS('.copy_btn');
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    @if(session()->has('err_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            text: "{{ session('err_message') }}",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    });
    @endif
    @if(session()->has('err_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            text: "{{ session('err_message') }}",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    });
    @endif
    @if(session()->has('flash_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "موفق",
            text: "{{ session('flash_message') }}",
            icon: "success",
            timer: 6000,
            timerProgressBar: true,
        })
    })
    ;@endif
    @if (count($errors) > 0)
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            icon: "warning",
            html:
                @foreach ($errors->all() as $key => $error)
                '<p class="text-right mt-2 ml-5" dir="rtl"> {{$key+1}} : '  +
                    '{{ $error }}'+
                '</p>'+
                @endforeach
                '<p class="text-right mt-2 ml-5" dir="rtl">' +
                    '</p>',
            timer:  @if(count($errors)>3)parseInt('{{count($errors)}}') * 1500 @else 6000 @endif,
            timerProgressBar: true,
        })
    });
    @endif


    $(document).ready(function () {
        $('.numberPrice').text(function (index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
</script>
@yield('js')
</body>
</html>
