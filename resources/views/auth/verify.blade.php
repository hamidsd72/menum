@extends('user.master')
@section('content')
    <div id="auth">

        <div class="content body-login pb-4 mt-5 pt-5 d-lg-none">
    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo-sm">
    
            <form method="POST" action="{{ route('user.sign-up-using-mobile.update',$number) }}" class="col-8 col-lg-3 col-xl-2 mt-5 pt-5 mx-auto">
                @csrf
                @method('patch')
    
                <h6 class="text-right m-0 mt-5 py-3 text-white">{{ __('auth.verify.code_title') }}</h6>
                <input type="text" name="code" class="form-control text-left bg-white border-redius20 mb-3" id="code" placeholder="126893" required>
    
                 <h6 class="text-danger text-center">{{$error ?? ''}}</h6>
    
                <button type="submit" class="btn btn-orange bg-secondary py-1 mt-1 col-12">{{ __('auth.verify.button_title') }}</button>
            </form>
    
            <form method="POST" action="/sign-up-using-mobile" class="col-12 text-center">
                @csrf
    
                <input type="hidden" name="mobile" value="{{$number}}" id="mobile">
    
                <button type="submit" class="py-3 text-white h6">{{ __('auth.verify.resend_button_title') }}</button>
            </form>
    
        </div>
    
        <div class="d-none d-lg-block">
    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo">
    
            <form method="POST" action="{{ route('user.sign-up-using-mobile.update',$number) }}" class="invate-form-big2 mt-5 pt-5">
                <div class="pt-5 mt-5 col-6 mx-auto">
                    @csrf
                    @method('patch')
    
                    <h6 class="text-right text-white m-0 my-3 mt-5 pt-5">{{ __('auth.verify.code_title') }}</h6>
                    <input type="text" name="code" class="form-control text-left bg-white border-redius20 mb-2" id="code" placeholder="126893" required>
    
                    @if ($error ?? '')
                        <h6 class="text-danger text-center pt-3">{{$error ?? ''}}</h6>
                    @endif
                    <button type="submit" class="btn btn-orange bg-secondary py-2 mt-2 col-12">{{ __('auth.verify.button_title') }}</button>
                </div>
            </form>
    
            <form method="POST" action="/sign-up-using-mobile" class="invate-form-big3">
                <div class="col-6 mx-auto text-center">
                    @csrf
                    <input type="hidden" name="mobile" value="{{$number}}" id="mobile">
                    <button type="submit" class="pt-4 text-white h6">{{ __('auth.verify.resend_button_title') }}</button>
                </div>
            </form>
    
        </div>

    </div>

    <script>
        $(function(){
            $("input[name='mobile']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
@endsection


