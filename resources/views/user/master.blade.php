<!DOCTYPE HTML>

<html lang="en" dir="{{app()->getLocale()=='fa'?'rtl':'ltr'}}">

@include('includes.head')

<style>
    body , .footer-bar-1, .header-fixed {
        max-width: 540px;
        margin: auto;
    }
    .p-custome-1 {
        padding: 8px 12px;
    }
</style>
@if( in_array(\Request::route()->getName(), ['login', 'user.sign-up-using-mobile.edit']) )
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
@endif

<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">

{{-- @include('includes.preLoader') --}}

<div id="page" >

    {{-- @include('includes.header') --}}

    @include('includes.bottomNavigationBar')

    <div class="page-content header-clear-medium" style="padding-top: 0px !important;padding-bottom: 52px !important;">
        {{-- @if (auth()->user())
            @unless (\Request::route()->getName() == 'user.index' || \Request::route()->getName() == 'user.find-store')
                <div class="my-1">
                    <a href="/app" class="mx-2">
                        <img src="{{url('/source/asset/assets/images/menum-orange-new.png')}}" alt="welcome" style="width: 60px">
                    </a>
                    <a class="bg-secondary text-light p-1 pt-2 px-3 rounded mx-1" href="{{url()->previous()}}">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            @endif
        @endif --}}
        @if (session()->has('flash_message'))
            <div class="alert alert-secondary alert-dismissible fade show m-0 p-1" role="alert">
                <p class="text-dark text-center m-0">{!! session()->get('flash_message') !!}</p>
            </div>
            <script>
                setTimeout(function() { $(".alert").alert('close') }, 5000);
            </script>
        @endif

        <script>screen.orientation.lock(orientation);</script>
        @yield('content')
    </div>
</div>  
    @include('includes.js')
</body>
 