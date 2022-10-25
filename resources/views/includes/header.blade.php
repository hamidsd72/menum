{{-- <div class="header header-fixed header-logo-center px-3">
    <a href="index.html" class="header-title">هولدینگ بین المللی سدار</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-right"></i></a>
    <a href="{{ route('user.questions') }}" class="header-icon header-icon-4"><i class="fas fa-bell text-danger"></i></a>
    <a href="{{ route('user.questions') }}" ><i class="fas fa-bell text-danger"></i></a>
</div> --}}


<style>
    /* start navbar */
    .sidenav {
        border-radius: 24px 0px 0px 0px;
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0;
        overflow-x: hidden;
        transition: 0.4s;
        margin-top: 54px;
        padding-top: 44px;  
    }
    .sidenav h6 {
        margin: 6% 6% 2% 0%;
    }
    .sidenav a {
        padding: 2%;
        text-decoration: none;
        color: black;
        display: block;
        font-weight: bold;
        transition: 0.3s;
    }
    .sidenav i {
        font-size: 14px;
        text-align: center;
        width: 28px;
        height: 26px;
        padding-top: 6px;
        border-radius: 9px;
        /* background: #DA4453 !important; */
        background: #ffc107 !important;
        color: white;
        text-align: center;
        width: 29px;
        height: 28px;
        padding-top: 8px;
    }
    .sidenav .close {
        position: absolute;
        top: 10px;
        right: 2px;
        font-size: large;
        color: black;
        padding: 8px 100px;
    }
    .header .navbar-brand h4 {
        font-size: 18px !important;
    }
    /* end navbar */
</style>
    
@if (Auth::user() && Auth::user()->first_name && Auth::user()->last_name)
    
    <div id="navbar1" class="nav-fixed navbar fixed-top navbar mx-auto px-3" style="max-width: 540px;padding-top: 12px;">
        <a href="index.html" class="text-dark">رستوران</a>
        <div class="float-left">
            <a href="#" data-back-button="" class="text-dark shadow bg-white mx-1"><i class="fas fa-shopping-cart"></i></a>
            <a href="#" data-back-button="" class="text-dark shadow bg-white mx-1"><i class="fas fa-bell"></i></a>
            <a href="#" href="#" onclick="toggleNav()" class="text-dark shadow bg-white"><i class="fas fa-bars"></i></a>
        </div>
    </div>

    <div id="navbar2" class="nav-fixed navbar fixed-top navbar bg-light mx-auto p-3" style="max-width: 540px;">
        <div class="float-right">
            <a href="#" data-back-button="" class="text-dark shadow bg-white mx-1"><i class="fas fa-shopping-cart"></i></a>
        </div> 
        <a href="index.html" class="text-dark" style="margin-right: 56px;">رستوران</a>
        <div class="float-left">
            <a href="#" href="#" onclick="toggleNav()" class="text-dark shadow bg-white"><i class="fas fa-bars"></i></a>
        </div>
    </div>

@endif

<div id="right" class="sidenav bg-white ">
    <div class="overflow-auto">
        
        {{-- <a href="#" onclick="closeNav()" class="close">&times;</a> --}}
        <a href="#" onclick="toggleNav()" class="close text-danger">بستن منو</a>
        
        <div>
            <h6>منو اصلی</h6>

            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-home"></i></div>
                    <div class="col">خانه</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-graduation-cap"></i></div>
                    <div class="col">لیست رستوران ها</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-users"></i></div>
                    <div class="col">لیست غذاها</div>
                </div>
            </a>
            {{-- <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-store-alt"></i></div>
                    <div class="col">فروشگاه</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-book-open"></i></div>
                    <div class="col">بلاگ آموزشی</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-calendar-check"></i></div>
                    <div class="col">تقویم مناسبت ها</div>
                </div>
            </a> --}}
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-crown"></i></div>
                    <div class="col">لیست پکیج ها</div>
                </div>
            </a>

        </div>
        
        <div>

            <h6>منو کاربری</h6>

            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-user-cog"></i></div>
                    <div class="col">حساب کاربری</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-heart"></i></div>
                    <div class="col">لیست علاقه مندی ها</div>
                </div>
            </a>
            <a href="#">
                <div class="row m-0">
                    <div class="col-2"><i class="fa fa-headset"></i></div>
                    <div class="col">درخواست پشتیبانی</div>
                </div>
            </a>

        </div>

    </div>
</div>

<script>
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
            document.getElementById("navbar1").style.display = "none";
            document.getElementById("navbar2").style.display = "block";
        } else {
            document.getElementById("navbar1").style.display = "block";
            document.getElementById("navbar2").style.display = "none";
        }
    }

    function toggleNav() {
        if (document.getElementById("right").offsetWidth > 0) {
            document.getElementById("right").style.width = "0px";
        } else {
            document.getElementById("right").style.width = "280px";
        }
    }
</script>