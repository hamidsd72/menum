@extends('layouts.admin')
@section('css')

@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @role('مدیر')
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{App\Model\BasketFactor::where('status','active')->count()}}</h3>

                            <p>سفارشات موفق</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('admin.service.buy.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{App\Model\BasketFactor::where('status','!=','active')->count()}}</h3>

                            <p>سفارشات ناموفق</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('admin.service.buy.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{App\User::count()}}</h3>

                            <p>کاربران ثبت شده</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('admin.user.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{App\Model\Visit::whereDate('created_at',date('Y-m-d'))->sum('view')}}</h3>

                            <p>بازدید روز</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="" class="small-box-footer"> <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        @endrole
        @include('includes.head')
        
        @include('includes.bottomNavigationBar')
        
        <div class="">
            <div class="col-12 user-profile-box-border my-3 text-center">
                <img style="max-width: 70px;border-radius: 50px;" src="{{$item->photo? url($item->photo->path) :asset('admin/img/user.png')}}" alt="User profile picture">
                <div> @item($item->first_name) @item($item->last_name)</div>
            </div>

            <p class="text-muted text-center">@item($item->education)</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-at ml-1"></i> آدرس صفحه شما </strong>
                        <p class="text-muted">
                            <textarea name="url" id="url" rows="6" class="form-control">{{$url}}</textarea>
                            <input type="text" name="myText" id="myText" value="{{$url}}" class="d-none" >
                            <button class="btn btn-outline-success mt-4" onclick="generateQR()" >برای ایحاد qrCode کلیک کنید</button>
                            <a href="#" onclick="urlCopy()" class="btn btn-outline-secondary mt-4 mr-3">کپی آدرس</a>
                        </p>
                    </div>
                    
                    <div class="col-sm-6">
                        <strong><i class="fa fa-mobile ml-1"></i>کیو آر کد صفحه شما</strong>
                        <div class="mx-auto text-center" id="qrcode"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-at ml-1"></i> ایمیل </strong>
                        <p class="text-muted">
                            @if($item->email!=null) @item($item->email)
                            @if($item->email_status=='pending')
                                <span class="right badge badge-danger">تایید نشده</span>
                            @elseif($item->email_status=='active')
                                <span class="right badge badge-success">تایید شده</span>
                            @endif
                            @else
                                ثبت نشده
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-sm-6">
                        <strong><i class="fa fa-mobile ml-1"></i> موبایل</strong>
                        <p class="text-muted">
                            @if($item->mobile!=null) @item($item->mobile) @else ثبت نشده @endif
                            @if($item->mobile_status=='pending')
                                <span class="right badge badge-danger">تایید نشده</span>
                            @elseif($item->mobile_status=='active')
                                    <span class="right badge badge-success">تایید شده</span>
                            @endif
                        </p>
                    </div>
                </div>
                {{-- <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-whatsapp ml-1"></i> شماره واتساپ فعال</strong>
                        <p class="text-muted">
                            @if($item->whatsapp!=null) @item($item->whatsapp) @else ثبت نشده @endif
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <strong><i class="fa fa-book ml-1"></i> تحصیلات</strong>
                        <p class="text-muted">
                            @if($item->education!=null) @item($item->education) @else ثبت نشده @endif
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-map-marker ml-1"></i> موقعیت</strong>
                        <p class="text-muted">
                            @if($item->state) @item($item->state->name) - @endif
                            @if($item->city) @item($item->city->name) - @endif
                            @if($item->locate!=null) @item($item->locate) - @endif
                            @if($item->address!=null) @item($item->address)  @endif
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-whatsapp ml-1"></i> تاریخ تولد</strong>
                        <p class="text-muted">
                            @if($item->date_birth!=null) @item($item->date_birth) @else ثبت نشده @endif
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <strong><i class="fa fa-registered ml-1"></i> معرف</strong>
                        <p class="text-muted">
                            @if($item->reagent_code!=null and $item->reagent_code=='rytl_user')
                                رایتل (کد : @item($item->reagent_code))
                            @elseif($item->reagent_code!=null and $item->reagent)
                                @item($item->reagent->first_name) @item($item->reagent->last_name) (کد : @item($item->reagent_code))
                            @else ثبت نشده @endif
                        </p>
                    </div>
                </div>
                <hr>
                @if($item->reagent_id!=null)
                <div class="row">
                    <div class="col-sm-12">
                        <strong><i class="fa fa-link ml-1"></i> لینک دعوت</strong>
                        <p class="text-muted text-left">
                            <a title="برای کپی لینک دعوت کلیک کنید" href="javascript:void(0);" class="copy_btn" onclick="return alert('لینک کپی شد')" data-clipboard-text="{{route('user.register',$item->reagent_id)}}">{{route('user.register',$item->reagent_id)}}</a>
                        </p>
                    </div>
                </div>
                <hr>
                @endif --}}
                <div class="row">
                    <div class="col-sm-6">
                        <strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت</strong>
                        <p class="text-muted">
                            {{my_jdate($item->create,'d F Y')}}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <strong><i class="fa fa-toggle-on ml-1"></i> وضعیت</strong>
                        <p class="text-muted">
                            @if($item->user_status=='pending')
                                <span class="right badge badge-warning">بررسی</span>
                            @elseif($item->user_status=='blocked')
                                <span class="right badge badge-danger">مسدود</span>
                            @elseif($item->user_status=='active')
                                <span class="right badge badge-success">تایید شده</span>
                            @endif
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <a href="{{route('admin.profile.edit')}}" class="btn btn-block btn-outline-primary"><b>ویرایش پروفایل</b></a>
                    </div>
                    <div class="col">
                        {{-- <a href="{{route('admin.password.edit')}}" class="btn btn-block btn-outline-secondary"><b>ویرایش رمز عبور</b></a> --}}
                        <a href="{{route('user.restaurant.edit',$restaurant->id)}}" class="btn btn-block btn-outline-success"><b>ویرایش فروشگاه</b></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    function urlCopy() {
        var copyText = document.getElementById("url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert(`آدرس ${copyText.value} در کلیپبورد ذخیره شد`);
    }
</script>
<script type="text/javascript" src="{{ asset('assets/scripts/qrcode.min.js') }}"></script>
<script>
    var qrdata = document.getElementById('qr-data');
    var qrcode = new QRCode(document.getElementById('qrcode'));

    function generateQR() {
        // var data = qrdata.value;
        console.log(document.getElementById("myText").value);
        qrcode.makeCode(document.getElementById("myText").value)
    }
</script>
@endsection
@section('js')

@endsection