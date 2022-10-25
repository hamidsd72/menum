@extends('layouts.user')
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
@endsection
 
@section('content')
    <section class="main-banner-in">
    <span class="shape-1 animate-this" style="transform: translateX(-17.5782px) translateY(-9.99425px);">
        <img src="{{url('source/asset/user/images/shape-1.png')}}" alt="shape">
    </span>
        <span class="shape-2 animate-this" style="transform: translateX(-17.5782px) translateY(-9.99425px);">
        <img src="{{url('source/asset/user/images/shape-2.png')}}" alt="shape">
    </span>
        <span class="shape-3 animate-this" style="transform: translateX(-17.5782px) translateY(-9.99425px);">
        <img src="{{url('source/asset/user/images/shape-3.png')}}" alt="shape">
    </span>
        <span class="shape-4 animate-this" style="transform: translateX(-17.5782px) translateY(-9.99425px);">
        <img src="{{url('source/asset/user/images/shape-4.png')}}" alt="shape">
    </span>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="h1-title">مشخصات خدمات</h1>
                </div>
            </div>
        </div>
    </section>
    <!--Banner End-->

    <!--Banner Breadcrum Start-->
    <div class="main-banner-breadcrum">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-breadcrum">
                        <ul>
                            <li><a href="{{url("/")}}">خانه</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="#">خدمات</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Banner Breadcrum End-->

    <?php
    $admin = App\User::where('id',1)->first();
    ?>
    <!--Course Detail Start-->
    <section class="main-course-detail-in">
        <div class="container" dir="rtl">
            <div class="row">
                <!--Course Detail Info Start-->
                <div class="col-xl-8 col-lg-7">
                    <div class="course-detail-box">
                        <h2 class="h2-title">{{$item->title}}</h2>
                        <div class="course-detail-user-box">
                            <div class="row align-items-center">
                                <div class="col-xxl-5 col-xl-12 col-lg-12">
                                    <div class="course-detail-instructor-date-box">
                                        <div class="course-detail-instructor">
                                            <div class="course-detail-instructor-img">
                                                <img style="width: 50px;" src="{{$admin->photo? url($admin->photo->path) :asset('admin/img/user.png')}}" class="rounded-circle" alt="instructor">
                                            </div>
                                            <div class="course-detail-instructor-text">

                                            </div>
                                        </div>
                                        <div class="course-detail-date">
                                            <a href="javascript:void(0);"><p dir="ltr">{{date('d M, Y',
                                                strtotime($item->created_at))}}</p></a>
                                            <span>آخرین اپدیت</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-7 col-xl-12 col-lg-12">
                                    <div class="course-detail-rating-tag-box">
                                        <div class="course-detail-rating-box">
                                            <a href="javascript:void(0);">
                                                <div class="course-detail-rating-star">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <p>5.00(2k)</p>
                                                </div>
                                            </a>
                                            <span></span>
                                        </div>
                                        <div class="course-detail-tag-box">
                                            <ul>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-detail-img wow fadeInUp animated" data-wow-delay=".4s">

                                <img src="{{$item->photo!=null?url($item->photo->path):''}}" alt="course">

                        </div>
                        <h3 class="h3-title">توضیحات</h3>
                        {!! $item->text !!}
                        <div class="course-detail-point">
                            @if($item->join)
                                <h3 class="h3-title">پکیج های دارای این سرویس</h3>
                                <ul>
                                    @foreach($item->join as $key=>$join_item)

                                        <li><i class="fa fa-check-circle" aria-hidden="true"></i><a class="px-2" href="{{route('user.package',$join_item->slug)}}" target="_blank"> {{$join_item->title}}</a></li>

                                    @endforeach
                                </ul>
                            @endif
                                @if (Auth::check())
                                    @if(count($item->join))

                                        @if(App\Model\Basket::where('user_id',auth()->user()->id)->whereIn('sale_id',$item->join_id($item->id))->where('status','active')->where('type','package')->exists())
                                            <p> ویدیو</p>
                                            <iframe style="width: 100%; height:300px;"  allowfullscreen
                                                    src="{{$item->video_link}}">
                                            </iframe>
                                        @endif
                                    @else
                                        @if(App\Model\Basket::where('user_id',auth()->user()->id)->where('sale_id',$item->id)->where('status','active')->where('type','service')->exists())
                                            <p> ویدیو</p>
                                            <iframe style="width: 100%; height:300px;"  allowfullscreen
                                                    src="{{$item->video_link}}">
                                            </iframe>
                                        @endif
                                    @endif


                                @endif
                        </div>

                    </div>
                </div>
                <!--Course Detail Info End-->
                <!--Sidebar Start-->
                <div class="col-xl-4 col-lg-5">
                    <div class="course-detail-sidebar">
                        <div class="get-the-course">
                            <div class="courses-sidebar-title">
                                <div class="sidebar-title-line"></div>
                                <h3 class="h3-title">همین حالا سفارش دهید</h3>
                            </div>

                            <div class="get-course-line"></div>

                            <div class="get-course-price">
                                <h3 class="h3-title">{{price($item->price)}}تومان </h3>
                            </div>

                            @if (!Auth::check())
                                برای خرید باید وارد پنل کاربری خود شوید!
                                <hr/>
                            @else
                                @if(count($item->join))
                                    @if(App\Model\Basket::where('user_id',auth()->user()->id)->whereIN('sale_id',$item->join_id($item->id))->where('status','active')->where('type','package')->exists())
                                        این سرویس در پکیج خریداری شده شما موجود است.
                                    @else
                                        <a href="{{route('user.add_basket',[$item->id,'service'])}}" class="sec-btn">اضافه به سبد خرید</a>
                                    @endif
                                @else
                                    @if(App\Model\Basket::where('user_id',auth()->user()->id)->where('sale_id',$item->id)->where('status','active')->where('type','service')->exists())
                                        این سرویس توسط شما خریداری شده.
                                    @else
                                        <a href="{{route('user.add_basket',[$item->id,'service'])}}" class="sec-btn">اضافه به سبد خرید</a>
                                    @endif
                                @endif

                            @endif
                        </div>

                    </div>
                </div>
                <!--Sidebar End-->
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endsection
