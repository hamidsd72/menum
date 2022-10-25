@extends('user.master')
@section('content')
    <div class="card card-style" style="background: none;box-shadow: none;">
       
        <div>
            <div class="card card-style bg-white">
                <div class="card card-style m-0" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;border-radius: 20px 20px 0px 0px;">
                    <img src="{{ url('/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}" alt="{{$ServiceCat->title}}">
                    <div class="card-top m-2">
                        <a href="#">
                            <span class="badge bg-blue-dark scale-box rounded-sm px-3 py-2 font-11 text-uppercase">{{$item->title}}</span>
                        </a>
                    </div>
                </div>
                <div class="content mt-2">
                    <div class="d-flex">
                        <div class="align-self-center">
                            <h3 class="font-20 my-3">{{$item->title}}</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        {!! $item->text !!}
                    </div>
                    <hr>
                    <div class="mx-3">
                        <div class="float-left h6 pt-1" style="font-weight: bold;">
                            @if ($item->service_type == 'جلسات عمومی')
                                قیمت<del>{{$item->price}}</del>رایگان
                            @else
                                {{' قیمت '.$item->price.' '}}
                            @endif
                        </div>
                        <div class="text-right">
                            @item(count($ServiceCat->service)) قسمت
                        </div>
                    </div>
                    <div class="col-8 mx-auto pt-3">
                        @if(auth()->check() && App\Model\Basket::where('user_id',auth()->user()->id)->where('sale_id',$item->id)->where('type','package')->where('status','active')->exists())
                            این پکیج در لیست خرید های شما موجود است.
                        @else
                            <a href="{{route('user.add_basket',[$item->id,'package'])}}" class="btn btn-full btn-s font-900 text-uppercase rounded-sm shadow-l bg-blue-dark ms-3">افزودن به سبد</a>
                        @endif
                    </div>

                </div>
            </div>
                
        </div>

    </div>
@endsection
