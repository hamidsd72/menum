@extends('user.master')
@section('content')
    <section id="edit-res-new" class="col-12">
        <div class="card res_table">
            <div class="card-header pt-2">
                <h5 class="card-title float-right pt-2">{{$res->title.' - '.auth()->user()->mobile}}</h5>
                <a class="float-left btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            <div class="card-body res_table_in">
                {{ Form::open(array('route' => array('user.restaurant.update', auth()->user()->id), 'method' => 'PATCH', 'files' => true)) }}
                    <div class="row mb-3">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="btn btn-file mb-1">
                                        @if($res->banner)
                                            <img src="{{url($res->banner)}}" class="logo border" alt="{{$res->title}}">
                                        @endif
                                        <div>{{$res->banner? __('text.res.edit_logo') : __('text.res.add_logo') }}</div>
                                        <input type="file" class="custom-file-input" id="exampleInputFile" onchange="processFile($event)" name="banner" accept=".jpeg,.jpg,.png" >
                                    </div>
                                </div>
                                <div class="col-6 text-center pt-1">
                                    <img src="{{asset('/assets/app/icons/'.auth()->user()->locale.'.jpeg')}}" style="margin-top: 2%;" class="logo border" alt="{{auth()->user()->locale}}">
                                    <div>
                                        <a href="#" class="btn" style="padding: 0px;" data-toggle="modal" data-target="#change_lang">{{__('text.edit_lang')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('title', __('auth.user.first_name') ) }}
                                <input type="text" name="auth-first-name" value="{{auth()->user()->first_name}}" id="auth-first-name" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('title', __('auth.user.last_name') ) }}
                                <input type="text" name="auth-first-name" value="{{auth()->user()->last_name}}" id="auth-first-name" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('title',  __('auth.user.shop_name') ) }}
                                {{ Form::text('title',$res->title, array('class' => 'form-control','required' => 'required')) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('dial', __('auth.user.dial_number') ) }}
                                {{ Form::text('dial',$res->dial, array('class' => 'form-control','required' => 'required', 'placeholder' => '09131238562')) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('whatsapp', __('auth.user.whatsapp') ) }}
                                {{ Form::text('whatsapp',$res->whatsapp, array('class' => 'form-control','required' => 'required', 'placeholder' => '9131238562')) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('instagram', __('auth.user.instagram') ) }}
                                {{ Form::text('instagram',$res->instagram, array('class' => 'form-control','required' => 'required', 'placeholder' => 'instagram_username')) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('address', __('auth.user.address') ) }}
                                {{ Form::text('address',$res->address, array('class' => 'form-control','required' => 'required', 'placeholder' => __('auth.user.shop_address_placeholder') )) }}
                            </div>
                        </div>
                    </div>
                {{ Form::button(__('text.edit'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
                {{ Form::close() }}
            </div>

            <div class="qrcode container">
                <div class="col-12 px-3">
                    <div class="row">
                        <div class="card-header">
                            <h5 class="card-title mt-2">{{__('text.res.page_address')}}</h5>
                        </div>
                        <textarea name="url" id="url" rows="3" class="form-control">{{$url}}</textarea>
                        <input type="text" name="myText" id="myText" value="{{$url}}" class="d-none" >
                        <div class="col">
                            <a href="#" onclick="urlCopy()" class="btn col-12 btn-primary my-3">{{__('text.res.qr_copy_title')}}</a>
                        </div>
                        <div class="col">
                            <button class="btn col-12 btn-primary my-3" onclick="generateQR()" >{{__('text.res.qr_create_title')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
    
    <button type="button" id="hide-btn" data-toggle="modal" data-target="#show-qr-code"></button>
    
    <div class="modal" id="show-qr-code">
        <div class="modal-dialog mt-5 pt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="font-size: 32px;color: red;">&times;</button>
                </div>
                <div class="modal-body py-5 px-lg-5">
                    <div class="mx-auto text-center" id="qrcode"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="change_lang">
        <div class="modal-dialog mt-5 pt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('text.select_lang')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" style="font-size: 32px;color: red;">&times;</button>
                </div>
                <div class="modal-body py-5 px-lg-5">
                    <form action="{{route('user.myuser.update',200)}}" method="POST">
                        @csrf
                        @method('patch')
                        <select class="form-control mb-3" name="locale" id="loacle">
                            <option value="fa" {{auth()->user()->locale=='fa'? 'selected' : '' }}>فارسی</option>
                            <option value="tr" {{auth()->user()->locale=='tr'? 'selected' : '' }}>Turkish</option>
                            <option value="en" {{auth()->user()->locale=='en'? 'selected' : '' }}>England</option>
                        </select>
                        <button type="submit" class="btn btn-success">{{__('text.edit')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('text.modal_btn2')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/scripts/qrcode.min.js') }}"></script>
    <script>
        function urlCopy() {
            var copyText = document.getElementById("url");
            var copied = "{{__('text.res.copied')}}";
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert(copied);
        }
    </script>
    <script>
        
        var qrdata = document.getElementById('qr-data');
        var qrcode = new QRCode(document.getElementById('qrcode'));
        
        function generateQR() {
            // var data = qrdata.value;
            qrcode.makeCode(document.getElementById("myText").value)
            document.getElementById("hide-btn").click();
        }
    </script>
    <script>
        processFile(event) {
            console.log( event.target.files[0] );
        },
    </script>
@endsection
