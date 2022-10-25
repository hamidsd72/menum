@extends('user.master')
@section('content')
<style>
    body , .footer-bar-1, .header-fixed {
        max-width: 1400px;
        margin: auto;
    }
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
        border-radius: 0px 100px 100px;
    }
    #menum .menu-list {
        background-color: #FF8C00;
        border-radius: 0px 50px 50px 0px
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
    @media only screen and (max-width: 640px) {
        #menum .menu-list .menu-name {
            font-size: 14px;
        }
        #menum .food .food-box-circle img.custom {
            height: 180px;
            border: 12px solid white;
        }
        #menum .food .food-box-circle {
            margin-right: 22px;
        }
        #menum .menu-list img.menu-img {
            height: 100px;
            border-radius: 0px 50px 50px;
        }
        #menum h4 , #menum h6 {
            font-size: 14px;
        }
        #menum .banner-res-one img.banner-site {
            height: 70px;
            padding: 10px;
            margin: 0px 0px;
        }
        #menum .food .body h6 {
            float: left;
            padding-top: 6px;
        }
        #menum .food .body h4 {
            color: #f00;
            padding-top: 2px;
        }
    }
    #menum .food .body h6 {
        float: left;
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
        border-radius: 4px;
        border-top-right-radius: 100px;
        background: white;
    }
</style>
    <div id="menum" class="row">

        <div class="col foods-list">

            <div class="d-lg-none"><h1 class="text-center my-4">{{$restaurant->title}}</h1></div>
            <div class="d-none d-lg-block"><h1 class="text-center display-4 my-5">{{$restaurant->title}}</h1></div>
            {{-- food --}}
            <div class="row">
                @foreach($items as $food)
                    <div class="col-lg-4 p-0 pb-3 food">
                        @include('user.partials.item')
                    </div>
                @endforeach
            </div>
            {{-- end food --}}
        </div>
        
        <div class="col-4 col-lg-2">
            <div class="list-category">
                {{-- banner --}}
                <div class="banner-res-one" style="position: fixed;">
                    @if($restaurant->banner)
                        <img class="banner-site" src="{{url($restaurant->banner)}}" alt="{{$restaurant->title}}">
                    @endif
                </div>
                {{-- end banner --}}
                {{-- category food --}}
                <div class="menu-list py-4 overflow-auto" style="max-height: 88%;position: fixed;top: 70px;">
                    @foreach ($serviceCat as $cat)
                        @include('user.partials.cat_item')
                    @endforeach
                </div>
                {{-- end category food --}}
            </div>
        </div>

    </div>

    {{-- @if ($serviceCat->count())
        
        @foreach ($serviceCat as $cat)
                
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
    </section> --}}
    
@endsection

