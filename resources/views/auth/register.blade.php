@extends('user.master')
@section('content')
<style>
    body , .footer-bar-1, .header-fixed {
        max-width: 1400px;
        margin: auto;
    }
</style>
@if (\Request::route()->getName()=='user.find-store')
    <style>
        @media only screen and (max-width: 640px) {
            #menum .menu-list .menu-name {
                margin-top: 8px;
            }
        }
    </style>
@endif
    <style>
        #menum .page-content .header-clear-medium {
            padding: 0px !important;
        }
        #menum .social-network .box a {

        }
        #menum .food-box img {
            width: 100%;
            height: 140px;
            padding: 4px;
            border-radius: 8px;
            min-height: 250px;
            max-height: 250px;
        }
        #menum .food-box-circle img {
            width: 200px;
            height: 200px;
            border-radius: 50px;
        }
        #menum .food-box button {
            background-color: #f00;
            padding: 6px 12px;
            border-radius: 4px;
        }

        #menum .banner-res-one img {
            width: 100%;
            height: 180px;
            border-radius: 4px;
        }
        #menum .banner-res-one img.banner-site {
            height: 100px;
            padding: 12px;
            max-width: 140px;
            border-radius: 16px;
            margin: 20px 0px;
        }
        #menum .btn-orange {
            background-color: #FF8C00;
            color: white;
        }

        #menum button.select-food {
            padding: 7px 24px 2px;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        #menum .food-box-circle img.custom {
            width: 100%;
            height: 240px;
            border-radius: 100px 0px 100px 100px;
        }
        #menum .menu-list {
            background-color: #FF8C00;
            border-radius: 50px 0px 0px 0px
        }
        #menum .menu-list .menu-name {
            text-align: center;
            margin: 8px 0px 16px;
            font-size: 18px;
            font-weight: 900;
        }
        #menum .menu-list img.menu-img {
            height: 140px;
            border: 8px solid white;
        }
        #menum .food .food-box-circle img.custom {
            border: 16px solid white;
        }
        #menum div.add_cat a {
            background: white;
            border-radius: 20px;
            padding: 8px 4px;
            color: #FF8C00;
            font-weight: bold;
        }
        #menum div.add_banner a {
            background: white;
            border-radius: 20px;
            padding: 8px 4px;
            color: #FF8C00;
            font-weight: bold;
        }
        #menum .food-box-circle .abs {
            position: relative; 
            top: -16px;
            right: 10px;
        }
        #menum .food .body h6 {
            float: right;
            padding-top: 6px;
        }
        #menum .food .body h4 {
            color: #f00;
            padding-top: 2px;
        }
        #menum .food .body {
            padding: 8px 16px;
        }
        #menum .cover {
            border-radius: 100px 100px 8px 8px;
            background: white;
        }
        #menum .fix-list-right {
            height: 100%;
            right: 0px;
            position: fixed;
            width: 30%;
        }
        @media only screen and (min-width: 992px) {
            #menum .fix-list-right {
                width: 12.5%;
            }
        }
        @media only screen and (max-width: 640px) {
            #menum .menu-list .menu-name {
                font-size: 14px;
                margin: -22px 0px 16px;
            }
            #menum .food .food-box-circle img.custom {
                height: 180px;
                border: 12px solid white;
            }
            #menum .food .food-box-circle {
                margin-left: 22px;
            }
            #menum .menu-list img.menu-img {
                height: 84px;
                border-radius: 50px 0px 50px 50px;
            }
            #menum h4 , #menum h6 {
                font-size: 14px;
            }
            #menum .banner-res-one img.banner-site {
                height: 36px;
                padding: 0px;
                margin: 10px 1px 0px;
                border-radius: 4px;
            }
        }
        .redu20 {
            border-radius: 20px
        }
    </style>
@if (session()->get('locale')=='fa')
    <style>
        #menum .menu-list {
            border-radius: 0px 50px 0px 0px;
        }
        #menum .food-box-circle img.custom {
            border-radius: 0px 100px 100px 100px;
        }
        @media only screen and (max-width: 640px) {
            #menum .food .food-box-circle {
                margin-left: 0px;
                margin-right: 22px;
            }
        }
        #menum .menu-list img.menu-img {
            height: 84px;
            border-radius: 0px 50px 50px 50px;
        }
        #menum .food-box-circle .abs {
            position: relative;
            top: -16px;right: -14px;
        }
        #menum .fix-list-right {
            left: 0px;
            right: unset;
        }
        #menum .food .body h6 {
            float: left;
        }
    </style>
@endif
    <div id="menum" class="row">
        <div class="col foods-list">
            <div class="row mb-2 mb-lg-0">
                <div class="col">
                    <div class="d-lg-none"><h4 class="text-center mt-3">{{$restaurant->title}}</h4></div>
                    <div class="d-none d-lg-block"><h1 class="text-center mt-5" style="font-weight: bold;font-size: 36px;">{{$restaurant->title}}</h1></div>
                </div>
                @if($restaurant->banner)
                    <div class="col-lg-2 col-3 banner-res-one">
                        <img class="banner-site" src="{{url($restaurant->banner)}}" alt="{{$restaurant->title}}">
                    </div>
                @else
                    <div class="add_banner col-5 mt-3">
                        <a href="#" data-toggle="modal" data-target="#editBanner">
                            {{ __('text.menum.add_banner') }}
                        </a>
                    </div>
                @endif
            </div>
            {{-- food --}}
            <div class="row mb-0">
                @foreach($items as $food)
                    <div class="col-lg-4 p-0 pb-3 food">
                        @include('user.partials.item')
                    </div>
                @endforeach
            </div>
            {{-- end food --}}
        </div>
        
        <div class="col-4 col-md-3 col-lg-2">
            <div class="list-category">
                {{-- category food --}}
                <div class="menu-list py-4 pb-5 fix-list-right overflow-auto">
                    @if ($serviceCat->count() < 1 && \Request::route()->getName()=='user.index')
                        <div class="text-lg-center add_cat py-2 px-2 px-lg-0">
                            <a href="{{ route('user.restaurant-food-categories.create') }}" >
                                {{ __('text.menum.add_category') }}
                            </a>
                        </div>
                    @endif
                    @foreach ($serviceCat as $cat)
                        @include('user.partials.cat_item')
                    @endforeach
                </div>
                {{-- end category food --}}
            </div>
        </div>

        {{-- edit banner --}}
        <div class="modal" id="editBanner">
            <div class="modal-dialog mt-5 pt-5">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title text-center mb-2">{{__('text.res.label_add')}}</h5>
                        {{ Form::open(array('route' => array('user.restaurant.update', auth()->user()->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="btn btn-file btn btn-file col-12 border mb-3">
                                {{__('text.res.button_add')}} 
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="banner" accept=".jpeg,.jpg,.png" required>
                            </div>
                        {{ Form::button(__('text.confirm'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- end edit banner --}}
    
    </div>
    
@endsection













{{-- @extends('layouts.user')
@section('content')
    <div class="login_page_head"></div>
    <div class="login_pag" style="margin-top: 200px;margin-bottom: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                </div>
                <div class="col-md-5">
                    <div class="col-md-6 ">
                        <h3 class="text-left"> ثبت نام</h3>
                    </div>
                    <div class="col-md-6">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <hr>
                    <form method="POST" action="{{isset($_GET['reagent_code'])? route('register',['reagent_code'=>$_GET['reagent_code']]):route('register') }}">
                        @csrf
                        <div class="row">
                            <label class="col-md-3 label control-label">نام</label>
                            <div class="col-md-9">
                                <input id="f_name" type="text"
                                       class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required>

                                @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">نام خانوادگی</label>
                            <div class="col-md-9">
                                <input id="l_name" type="text"
                                       class="form-control @error('l_name') is-invalid @enderror" name="l_name"
                                       value="{{ old('l_name') }}" required>

                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">موبایل</label>
                            <div class="col-md-9">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                       name="mobile" value="{{ old('mobile') }}" required>

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">شماره واتسپ فعال</label>
                            <div class="col-md-9">
                                <input id="whatsapp" type="text"
                                       class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp"
                                       value="{{ old('whatsapp') }}" required>

                                @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">استان</label>
                            <div class="col-md-9">
                                <select id="state_id" type="text"
                                        class="form-control @error('state_id') is-invalid @enderror" name="state_id"
                                        required>
                                    <option value="">انتخاب کنید</option>
                                    @foreach($states as $key=>$state )
                                        <option value="{{$state->id}}" {{old('state_id')==$state->id?'selected':''}}>{{$state->name}}</option>
                                    @endforeach

                                </select>

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">شهر</label>
                            <div class="col-md-9">
                                <select id="city_id" type="text"
                                       class="form-control @error('city_id') is-invalid @enderror" name="city_id" required>
                                    <option value="">ابتدا استان را انتخاب کنید</option>

                                </select>

                                @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">منطقه</label>
                            <div class="col-md-9">
                                <input id="locate" type="text"
                                       class="form-control @error('locate') is-invalid @enderror" name="locate"
                                       value="{{ old('locate') }}" required>

                                @error('locate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">آدرس</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class=" form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تاریخ تولد</label>
                            <div class="col-md-9">
                                <input id="date_birth" type="text"
                                       class=" input_date form-control @error('date_birth') is-invalid @enderror" name="date_birth"
                                       value="{{ old('date_birth') }}" readonly required>

                                @error('date_birth')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تحصیلات</label>
                            <div class="col-md-9">
                                <input id="education" type="text"
                                       class="form-control @error('education') is-invalid @enderror" name="education"
                                       value="{{ old('education') }}" required>

                                @error('education')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">ایمیل</label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">رمز عبور</label>
                            <div class="col-md-9">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تکرار رمز</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-info"> ثبت نام</button>
                                <a href="{{ route('login')}}" type="submit" class="btn btn-warning"> ورود</a>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="login_page_footer"></div>

@endsection --}}

