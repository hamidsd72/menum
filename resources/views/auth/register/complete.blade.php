@extends('layouts.user')

@section('content')
    <div class="login_page_head"></div>
    <div class="login_pag" style="margin-top: 200px;margin-bottom: 100px;">
        <div class="container">
            <div class="row" dir="rtl">
                <div class="col-md-10 carding m-auto">
                    <div class="col-md-6 ">
                        <h3 class="text-right"> تکمیل ثبت نام4</h3>
                    </div>
                    <div class="col-md-6">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <hr>
                    <form method="POST" action="{{route('user.complete.post') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>* نام</label>

                                <input id="first_name" type="text"
                                       class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                       value="{{ old('first_name') }}" required>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* نام خانوادگی</label>
                                <input id="last_name" type="text"
                                       class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                       value="{{ old('last_name') }}" required>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* شماره واتسپ فعال</label>
                                <input id="whatsapp" type="text"
                                       class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp"
                                       value="{{ old('whatsapp', session('mobile_num')) }}" required>

                                @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* استان</label>
                                <select id="state_id" type="text"
                                        class="form-control py-0 @error('state_id') is-invalid @enderror" name="state_id"
                                        required>
                                    <option value="">انتخاب کنید</option>
                                    @foreach($states as $key=>$state )
                                        <option
                                            value="{{$state->id}}" {{old('state_id')==$state->id?'selected':''}}>{{$state->name}}</option>
                                    @endforeach

                                </select>

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* شهر</label>
                                <select id="city_id" type="text"
                                        class="form-control py-0 @error('city_id') is-invalid @enderror" name="city_id"
                                        required>
                                    <option value="">ابتدا استان را انتخاب کنید</option>

                                </select>

                                @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* منطقه</label>
                                <input id="locate" type="text"
                                       class="form-control @error('locate') is-invalid @enderror" name="locate"
                                       value="{{ old('locate') }}" required>

                                @error('locate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-8">
                                <label>* آدرس</label>
                                <input id="address" type="text"
                                       class=" form-control @error('address') is-invalid @enderror" name="address"
                                       value="{{ old('address') }}" required>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* تاریخ تولد</label>
                                <input id="date_birth" type="text"
                                       class=" input_date form-control @error('date_birth') is-invalid @enderror"
                                       name="date_birth"
                                       value="{{ old('date_birth') }}" readonly required>

                                @error('date_birth')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* تحصیلات</label>
                                <input id="education" type="text"
                                       class="form-control @error('education') is-invalid @enderror" name="education"
                                       value="{{ old('education') }}" required>

                                @error('education')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                          {{--  <div class="form-group col-md-2">
                                <label>کد معرف</label>
                                <input id="referrer" type="text"
                                       class="form-control @error('referrer') is-invalid @enderror" name="referrer" required
                                       value="{{ old('referrer',session()->has('reagent_code')?session('reagent_code'):'') }}" @if (session()->has('reagent_code')) readonly @endif>

                                @error('referrer')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>--}}
                        {{--    <div class="form-group col-md-2">
                                <label>معرف ندارم</label>
                                <input id="no_referrer" type="checkbox"
                                       class="form-control @error('referrer') is-invalid @enderror" name="no_referrer">

                                @error('referrer')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>--}}

                            <div class="form-group col-md-4">
                                <label>ایمیل</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* رمز عبور</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label>* تکرار رمز</label>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-info"> تکمیل ثبت نام</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="login_page_footer"></div>

@endsection

