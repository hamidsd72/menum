@extends('user.master')

@section('content')
<style>
    [data-gradient=body-default] #page, .background-changer .body-default {
        background-image: none !important;
    }
    body {
        background: url("/source/asset/assets/images/backMenum2.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-size: 100% 100%;
        background-position: center top;
        background-attachment: fixed;
    }
</style>

    <div id="auth">
        
        <div class="content mt-5 pb-5 d-lg-none">
    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo-sm">
    
            <form method="POST" action="{{ route('user.myuser.update',200) }}" class="col-8 col-lg-3 col-xl-2 pt-5 mx-auto">
                @method('patch')
                @csrf
    
                <h6 class="text-right text-white m-0 mb-1 mt-5 pt-4">{{ __('auth.user.first_name') }}</h6>
                <input type="text" name="first_name" class="form-control text-left bg-white border-redius20 matn-right" id="first_name" placeholder="{{ __('auth.user.first_name_placeholder') }}" required>
                <p class="text-danger text-center p-1 rounded m-0">{{$ef ?? ''}}</p>
    
                <h6 class="text-right text-white m-0 my-1">{{ __('auth.user.last_name') }}</h6>
                <input type="text" name="last_name" class="form-control text-left bg-white border-redius20 matn-right" id="last_name" placeholder="{{ __('auth.user.last_name_placeholder') }}" required>
                <p class="text-danger text-center p-1 rounded m-0">{{$el ?? ''}}</p>
    
                <h6 class="text-right text-white m-0 my-1">{{ __('auth.user.shop_name') }}</h6>
                <input type="text" name="res_name" class="form-control text-left bg-white border-redius20 matn-right" id="res_name" placeholder="{{ __('auth.user.shop_name_placeholder') }}" required>
                <p class="text-danger text-center p-1 rounded m-0">{{$el ?? ''}}</p>
            
                <input type="hidden" name="locale" id="locale" value="{{session()->get('locale')}}">
    
                <button type="submit" class="btn btn-orange bg-secondary py-2 mt-3 col-12">{{ __('auth.user.submit') }}</button>
     
            </form>
            
        </div>
    
        <div class="d-none d-lg-block">    
    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo">
    
            <form method="POST" action="{{ route('user.myuser.update',200) }}" class="invate-form-big4 mt-5 pt-5">
                <div class="py-4 mb-5 col-6 mx-auto">
                    @method('patch')
                    @csrf
    
                    <h6 class="text-right text-white m-0 mt-5 mb-2">{{ __('auth.user.first_name') }}</h6>
                    <input type="text" name="first_name" class="form-control text-left bg-white border-redius20 matn-right" id="first_name" placeholder="{{ __('auth.user.first_name_placeholder') }}" required>
                    <p class="text-danger text-center p-1 rounded m-0">{{$ef ?? ''}}</p>
    
                    <h6 class="text-right text-white m-0 my-2">{{ __('auth.user.last_name') }}</h6>
                    <input type="text" name="last_name" class="form-control text-left bg-white border-redius20 matn-right" id="last_name" placeholder="{{ __('auth.user.last_name_placeholder') }}" required>
                    <p class="text-danger text-center p-1 rounded m-0">{{$el ?? ''}}</p>
    
                    <h6 class="text-right text-white m-0 my-1">{{ __('auth.user.shop_name') }}</h6>
                    <input type="text" name="res_name" class="form-control text-left bg-white border-redius20 matn-right" id="res_name" placeholder="{{ __('auth.user.shop_name_placeholder') }}" required>
                    <p class="text-danger text-center p-1 rounded m-0">{{$el ?? ''}}</p>
                    <input type="hidden" name="locale" id="locale" value="{{session()->get('locale')}}">
    
                    <button type="submit" class="btn btn-orange bg-secondary py-2 mt-3 col-12">{{ __('auth.user.submit') }}</button>
                </div>
        
            </form>
            
        </div>
        
    </div>

@endsection
