@extends('user.master')
@section('content')
<style>
    body , .footer-bar-1, .header-fixed {
        max-width: 1400px;
        margin: auto;
    }
    .page-content .header-clear-medium {
        padding: 0px !important;
    }
    .social-network .box a {

    }
    .food-box img {
        width: 100%;
        height: 140px;
        padding: 4px;
        border-radius: 8px;
        min-height: 250px;
        max-height: 250px;
    }
    .food-box-circle img {
        width: 200px;
        height: 200px;
        border-radius: 50px;
    }
    .food-box button {
        background-color: #f00;
        padding: 6px 12px;
        border-radius: 4px;
    }

    .banner-res-one img {
        width: 100%;
        height: 180px;
        border-radius: 4px;
    }
    .banner-res-one img.big {
        height: 600px !important;
    }
    .btn-orange {
        background-color: #FF8C00;
        color: white;
    }

    button.select-food {
        padding: 7px 24px 2px;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
</style>
    <div class="d-lg-none"><h1 class="text-center">{{$restaurant->title}}</h1></div>
    <div class="d-none d-lg-block"><h1 class="text-center display-4 pt-2">{{$restaurant->title}}</h1></div>
    

    {{-- banner --}}
    <div class="banner-res-one">
        @if($restaurant->banner)
            <div class="d-lg-none" ><img src="{{url($restaurant->banner)}}" alt="{{$restaurant->title}}"></div>
            <div class="d-none d-lg-block"><img class="big" src="{{url($restaurant->banner)}}" alt="{{$restaurant->title}}"></div>
        @endif
    </div>
    {{-- end banner --}}

    @if ($serviceCat->count())
        
        @foreach ($serviceCat as $cat)
                
            {{-- دسته غذا --}}
            <div class="d-flex p-3">
                <div class="align-self-center">
                    <a href="#">
                        <h2 class="mb-0 pb-2 border-bottom">{{$cat->title}}</h2>
                    </a>
                    <p class="mt-n1 mb-0"></p>
                </div>
                <div class="align-self-center ms-auto">
                </div>
            </div> 

            <div class="row m-0">
                @foreach($items->where('food_type',$cat->id) as $food)
                    <div class="d-none">{{$index=1}}</div>
                    <div class="col-lg-4 pb-3">
                        <div class="@if($index == 1) food-box @elseif($index > 1) food-box-circle @else food-box-circle @endif box px-3 border rounded">
                            <div class="row mb-2">
                                <div class="col p-0">
                                    <div class="body mx-2 mx-lg-3 mb-3">
                                        <h4 class="my-2" style="color: #f00;">{{$food->title}}</h4>
                                        {!! $food->text !!}
                                    </div>
                                </div>
                                <div class="col-5 p-0">
                                    @if ($food_photo->where('pictures_id',$food->id)->first())
                                    <img class="shadow" src="{{ url($food_photo->where('pictures_id',$food->id)->first()->path) }}" alt="{{$food->title}}">
                                    @endif
                                </div>
                                <div class="col-12">
                                    <button class="price">
                                        <h6 class="text-white m-0 pt-1" >{{$food->price}}</h6>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none">{{$index+=1}}</div>
                @endforeach
            </div>
            {{-- دسته غذا end --}}
            
        @endforeach
    @endif

    <section class="social-network border-top text-center">
        @if($restaurant && $restaurant->title)
            <div class="row pt-3 px-3 mb-0 rounded">
                <h1 class="col-12 text-center">{{$restaurant->title}}</h1>
                <div class="col-12 mb-3">
                    <div class="my-3">
                        @if ($restaurant && $restaurant->dial)
                            <a href="tell:{{$restaurant->dial}}" target="_blank" class="box mx-2">
                                {{-- {{$restaurant->dial}} --}}
                                <img src="{{url('/source/asset/assets/images/Call.png')}}" style="width: 50px;" alt="{{$restaurant->dial}}">
                            </a>
                        @endif
                        @if ($restaurant && $restaurant->whatsapp)
                            <a href="https://wa.me/{{$restaurant->whatsapp}}" target="_blank" class="box mx-2">
                                <img src="{{url('/source/asset/assets/images/WhatsApp.png')}}" style="width: 40px;" alt="{{$restaurant->whatsapp}}">
                            </a>
                        @endif
                        @if ($restaurant && $restaurant->instagram)
                            <a href="https://www.instagram.com/{{$restaurant->instagram}}" class="box mx-2">
                                <img src="{{url('/source/asset/assets/images/Instagram.png')}}" style="width: 40px;border-radius: 40px;" alt="{{$restaurant->instagram}}">
                            </a>
                        @endif
                    </div>
                    @if ($restaurant && $restaurant->address)
                        <a href="#" class="box mx-2 mx-lg-5 h6 text-secondary">
                            <img src="{{url('/source/asset/assets/images/Location.png')}}" style="width: 32px;" alt="{{$restaurant->address}}">
                            {{$restaurant->address}}
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </section>
    
@endsection

