@extends('user.master')

@section('content')
    <div id="auth">
        <div class="d-flex mt-3 mt-lg-4" dir="ltr">
            @unless (session()->get('locale')=='fa')
                <a style="margin-left: 16px;" href="{{ route('lang_set','fa') }}" onclick="event.preventDefault(); document.getElementById('fa-lang').submit();">
                    <img style="height: 40px;width: 40px;border-radius: 40px;" src="{{asset('/assets/app/icons/fa.jpeg')}}" alt="fa"></a>
                <form id="fa-lang" action="{{ route('lang_set','fa') }}" method="GET" class="d-none">@csrf<input type="hidden" name="locale" value="fa"></form>
            @endunless
            @unless (session()->get('locale')=='' || session()->get('locale')=='en')
                <a style="margin-left: 16px;" href="{{ route('lang_set','en') }}" onclick="event.preventDefault(); document.getElementById('en-lang').submit();">
                    <img style="height: 40px;width: 40px;border-radius: 40px;" src="{{asset('/assets/app/icons/en.jpeg')}}" alt="en"></a>
                <form id="en-lang" action="{{ route('lang_set','en') }}" method="GET" class="d-none">@csrf<input type="hidden" name="locale" value="en"></form>
            @endunless
            @unless (session()->get('locale')=='tr')
                <a style="margin-left: 16px;" href="{{ route('lang_set','tr') }}" onclick="event.preventDefault(); document.getElementById('tr-lang').submit();">
                    <img style="height: 40px;width: 40px;border-radius: 40px;" src="{{asset('/assets/app/icons/tr.jpeg')}}" alt="tr"></a>
                <form id="tr-lang" action="{{ route('lang_set','tr') }}" method="GET" class="d-none">@csrf<input type="hidden" name="locale" value="tr"></form>
            @endunless
        </div>

        <div class="content mt-5 pt-1 d-lg-none">    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo-sm">
    
            <form method="POST" action="{{ route('user.sign-up-using-mobile.store') }}" class="col-8 col-lg-3 col-xl-2 mt-5 pt-5 mx-auto">
                @csrf
    
                <h6 class="text-right text-white m-0 mt-5 pt-5 mb-2">{{ __('auth.login.mobile_title') }}</h6>
    
                <input type="text" name="mobile" class="form-control text-left bg-white border-redius20" id="mobile" placeholder="09128451364" required>
                <h6 class="text-danger text-center p-1 rounded">{{$error ?? ''}}</h6>
    
                <button type="submit" class="btn btn-orange bg-secondary py-1 mt-1 col-12">{{ __('auth.login.button_title') }}</button>
            </form>
    
        </div>
    
        <div class="d-none d-lg-block">    
    
            <img src="{{url('/source/asset/assets/images/menum.png')}}" alt="welcome" class="welcome-logo">
    
            <form method="POST" action="{{ route('user.sign-up-using-mobile.store') }}" class="invate-form-big">
                <div class="pb-5 mb-5 col-6 mx-auto">
                    @csrf
        
                    <h6 class="text-right text-white m-0 my-3">{{ __('auth.login.mobile_title') }}</h6>
                    <input type="text" name="mobile" class="form-control text-left bg-white border-redius20" id="mobile" placeholder="09121257585" required>
                    <h6 class="text-danger text-center p-1 rounded">{{$error ?? ''}}</h6>
        
                    <button type="submit" class="btn btn-orange bg-secondary py-2 mt-2 col-12">{{ __('auth.login.button_title') }}</button>
                </div>
            </form>
    
        </div>
    
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
            
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">راهنمای نصب</h4>
                        {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="Pwa">
                            <div class="head">
                                <div class="logo-custom-pwa-one rounded bg-custom-green mb-3 px2" ><img src="{{asset('assets/images/logo.png')}}" alt="imshaaver.ir"></div>
                            </div>
                            <section>
                                <img src="https://pwa.mci.ir/static/media/ios_share_black_24dp.32f1d748.svg" alt="share">
                                در نوار پایین روی دکمه Share کلیک کنید
                            </section>
                            <section>
                                <img src="https://pwa.mci.ir/static/media/add_box_black_24dp.b2e62f60.svg" alt="add">
                                در منوی باز شده در قسمت پایین صفحه گزینه
                            </section>
                            <section>
                                Add To Home Screen را انتخاب کنید
                            </section>
                            <section>
                                <span class="text-primary large float-right px-2">Add</span>
                                در مرحله بعد در قسمت بالا روی
                            </section>
                            <section>
                                کلیک کنید Add
                            </section>
                        </div>
                    </div>
            
                    <!-- Modal footer -->
                    <div class="m-2">
                        <button id="submitButton" type="button" class="d-none" data-dismiss="modal">فهمیدم</button>
                    </div>
            
                </div>
            </div>
        </div>

    </div>

    @if ($show_modal ?? '')
        <script>
            $(function(){
                $('#myModal').modal('show');
            });
        </script>
    @endif

    <script>
        $(function(){
            $("input[name='mobile']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
@endsection
