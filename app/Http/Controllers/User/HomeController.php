<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Slider;
use App\Model\Category;
use App\Model\ServiceCat;
use App\Model\Photo;
use App\Model\Custom;
use App\Model\About;
use App\Model\Service;
use App\Model\OffCode;
use App\Model\ServicePackage;
use App\Model\ServiceBuy;
use App\Model\ServiceFactor;
use App\Model\ServicePlus;
use App\Model\ServicePlusBuy;
use App\Model\ServicePackagePrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->first_name && Auth::user()->last_name) {
            \App::setLocale(auth()->user()->locale);
            session()->put('locale', auth()->user()->locale);
            
            function fa_number($number) {
                $arr = array();
                for ($i=0; $i < strlen($number); $i++) { 
                    switch ($number) {
                        case $number[$i] == "0":
                            array_push($arr, "۰" );
                        break;
                        case $number[$i] == "1":
                            array_push($arr, "۱" );
                        break;
                        case $number[$i] == "2":
                            array_push($arr, "۲" );
                        break;
                        case $number[$i] == "3":
                            array_push($arr, "۳" );
                        break;
                        case $number[$i] == "4":
                            array_push($arr, "۴" );
                        break;
                        case $number[$i] == "5":
                            array_push($arr, "۵" );
                        break;
                        case $number[$i] == "6":
                            array_push($arr, "۶" );
                        break;
                        case $number[$i] == "7":
                            array_push($arr, "۷" );
                        break;
                        case $number[$i] == "8":
                            array_push($arr, "۸" );
                        break;
                        case $number[$i] == "9":
                            array_push($arr, "۹" );
                        break;
                    
                        default:
                            array_push($arr, $number[$i] );
                    } 
                }
                return implode("",$arr);
            }
            $sliders = Slider::all(); 
            $slidersPhotos = Photo::where('pictures_type', 'App\Model\Slider')->whereIn('pictures_id', $sliders->pluck('id'))->get();
            $about = About::find(1);
            // $service_custom = Service::where('category_id', '!=', 4)->whereNotIn('id', $gold_package->joins->pluck('service_id'))->get();
            $customers = Custom::where('status','active')->get();
            // $serviceCat = ServiceCat::where('status', 'active')->get();
            $packages = ServicePackage::where('type', 'sample')->orderBy('sort_by', 'ASC')->where('status', 'active')->where('home_view', 1)->take(6)->get();
            $gold_package = ServicePackage::where('status', 'active')->where('custom', 1)->first();
            $service_custom = Service::where('category_id', '!=', 4)->get();
            foreach ($packages as $package) {
                if(!empty($package->price)) {
                    $package->price = fa_number($package->price);
                }
            }

            // resturan 
            $restaurant = ServiceCat::where('user_id', auth()->user()->id)->first();
            // cat food
            $serviceCat = Category::where('status', 'active')->where('user_id', auth()->user()->id)->get();
            //food
            // $items = Service::where('status', 'active')->whereIn('food_type', $serviceCat->pluck('id'))->get();
            $items = Service::whereIn('food_type', $serviceCat->pluck('id'))->get();
            foreach ($items as $item) {
                if(!empty($item->price)) {
                    $item->price = fa_number( number_format($item->price) ).' تومان ';
                }
            }
            //food photo
            $food_photo = Photo::where('pictures_type', 'App\Model\Service')->whereIn('pictures_id', $items->pluck('id'))->get();
            return view('auth.register', compact('serviceCat','sliders', 'about', 'packages', 'customers', 'service_custom','gold_package','slidersPhotos','items','food_photo','restaurant'));
            // return view('user.index', compact('serviceCat','sliders', 'about', 'packages', 'customers', 'service_custom','gold_package','slidersPhotos','items','food_photo','restaurant'));
        
        }

        return view('auth.login2' );
    }
    
    public function tickets() 
    {
        $items = Contact::where('user_id', Auth::user()->id )->where('belongs_to_item', '=', 0)->orderBy('id','desc')->paginate(10);
        $sub_items = Contact::whereIn('belongs_to_item', $items->pluck('id') )->get();
        return view('user.ticket.index', compact('items', 'sub_items')); 
    }

    public function services($cat_id) 
    {
        $ServiceCat = ServiceCat::where('id', $cat_id)->first();
        $items = Service::where('status', 'active')->where('category_id', $cat_id)->orderBy('order')->get();
        // return view('user.service.index', compact('items','ServiceCat'));
        return view('user.services', compact('items','ServiceCat'));
    }

    public function service($id,$slug)
    {
        // $item = Service::where('slug', $slug)->where('id',$id)->first();
        $item = Service::findOrFail($id);
        $ServiceCat = ServiceCat::where('id', $item->category_id)->first();
        // dd($item, $ServiceCat);
        return view('user.sevices.show', compact('item', 'ServiceCat'));
    }

    public function packages_category()
    {
        $items = ServiceCat::where('type', 'package')->orderBy('id', 'ASC')->where('id', '!=', 4)->get();
        return view('user.package.category', compact('items'));
    }

    public function packages()
    {
        $items = ServicePackage::where('status', 'active')->get();

        return view('user.package.index', compact('items'));
    }

    public function package($slug)
    {
        $item = ServicePackage::where('slug', $slug)->first();
        return view('user.package.show', compact('item'));

    /*    if($item->type=='learning')
        {
        }
        elseif($item->type=='sample')
        {
            $gold_package = ServicePackage::where('status', 'active')->where('custom', 1)->first();
            $service_custom = Service::where('category_id', '!=', 4)->whereNotIn('id', $gold_package->joins->pluck('service_id'))->get();
            return view('user.package.show', compact('item','service_custom'));
        }*/
    }

    public function reserve($type, $slug)
    {
        if ($type == "package") {
            $item = ServicePackage::where('slug', $slug)->first();
        } elseif ($type == 'service') {
            $item = Service::where('slug', $slug)->first();
        }
        if (isset($item)) {
            try {

                $service_buy = new ServiceBuy();
                $service_buy->buy_id = $item->id;
                $service_buy->buy_type = $type;
                $service_buy->buy_id = $item->id;
            } catch (\Exception $error) {
                return redirect()->back()->withInput()->with('err_message', 'مشکلی به وجود آمده، لطفا با پشتیبانی تماس بگیرید.');
            }

        } else {
            return redirect()->back()->withInput()->with('err_message', 'سرویس مورد نظر یافت نشد لطفا مجدد تلاش فرمائید');

        }

    }

    public function validation_email(Request $request)
    {
        $p_id = $request->get('p_id');
        $star = $request->get('value_star');
        return response()->json(['success1' => true, 'p' => $p_id]);

    }

    public function login_package_buy(Request $request, $slug, $price_id = null)
    {
        if (!is_null($price_id)) {
            session(['price_id' => $price_id]);
        }
        session(['package_slug' => $slug]);
        if (isset($request->service)) {
            session(['service_gold' => $request->service]);
        }

        if (isset($request->plus)) {
            session(['plus' => $request->plus]);
        }
        if (Auth::check()) {
            $off_code=OffCode::where('code',$request->off_code)->where('status','active')->first();
            //isset code
            if($off_code)
            {
                // not used code
                if($off_code->used=='no')
                {
                    // used code all user
                    if($off_code->user_id==0)
                    {
                        $factor=ServiceFactor::where('user_id',Auth::user()->id)->where('off_code',$request->off_code)->wherein('pay_status',['paid','credit'])->first();
                        //used user code all user
                        if(!$factor)
                        {
                            session(['off_id' => $off_code->id]);
                        }

                    }
                    // used code personal user
                    else {
                        if($off_code->user_id==Auth::user()->id) {
                            session(['off_id' => $off_code->id]);
                        }
                    }
                }
            }
            return redirect()->route('user.package.buy');
        }
        if ($request->type == "login") {
            return redirect()->route('login');
        } else {
            return redirect()->route('user.mobile');
        }
    }

    public function package_buy()
    {
        $order_code = 10001;
        $slug = '';
        $service_gold = '';
        $plus = "";
        $plus_price = 0;

        if (session()->has('package_slug')) {
            $slug = session('package_slug');
            if (session()->has('plus')) {
                $plus = session('plus');
            }
            if (session()->has('service_gold')) {
                $service_gold = session('service_gold');
            }
            $package = ServicePackage::where('slug', $slug)->first();
            if ($service_gold != "") {
                if ($package->custom_service_count < count($service_gold)) {
                    return redirect()->route('user.index')->with('err_message', 'دوست عزیز ; موردی مشکوک به ساختارشکنی مشاهده شده ، لطفا مجدد و با شرایط درست اقدام فرمائید ');
                }
            }
            if (session()->has('price_id')) {
                $package_price = ServicePackagePrice::find(session('price_id'));
            }
            try {
                $item = ServiceFactor::latest()->first();
                if ($item) {
                    $order_code = intval($item->order_code) + intval(rand(10, 100));
                }
                $factor = new ServiceFactor();
                $factor->order_code = $order_code;
                $factor->user_id = Auth()->user()->id;
                if (isset($package_price)) {
                    $factor->all_price = $package_price->price;
                    $factor->month_time = $package_price->month_time;
                } else {
                    $factor->all_price = $package->price;
                }
                $factor->package_id = $package->id;
                $factor->type = 'package';
                if ($package->custom == 1) {
                    $factor->custom = 1;
                }
                $factor->save();
                foreach ($package->join as $service) {
                    $servide_buy = new ServiceBuy();
                    $servide_buy->factor_id = $factor->id;
                    $servide_buy->price = $service->price;
                    $servide_buy->buy_id = $service->id;
                    $servide_buy->save();
                    if ($plus != "" and count($plus) > 0) {
                        foreach ($plus as $plu) {
                            $item_plus = ServicePlus::find($plu);
                            if (isset($item_plus) and $item_plus->service->id == $service->id) {
                                $new_plus = new ServicePlusBuy ();
                                $new_plus->service_id = $service->id;
                                $new_plus->plus_id = $item_plus->id;
                                $new_plus->price = $item_plus->price;
                                $new_plus->factor_id = $factor->id;
                                $new_plus->buy_id = $servide_buy->id;
                                $new_plus->user_id = auth()->user()->id;
                                $new_plus->save();
                                $plus_price += $item_plus->price;
                            }
                        }
                    }
                }

                if ($package->custom == 1) {
                    if ($service_gold != null) {
                        $service_arry = [];
                        foreach ($service_gold as $serv) {
                            array_push($service_arry, $serv);
                            $service_golds = Service::whereIn('id', $service_arry)->get();
                        }
                        foreach ($service_golds as $service) {
                            $servide_buy = new ServiceBuy();
                            $servide_buy->factor_id = $factor->id;
                            $servide_buy->price = $service->price;
                            $servide_buy->buy_id = $service->id;
                            $servide_buy->type = 1;
                            $servide_buy->save();
                            if ($plus != '' and count($plus) > 0) {
                                foreach ($plus as $plu) {
                                    $item_plus = ServicePlus::find($plu);
                                    if (isset($item_plus) and $item_plus->service->id == $service->id) {
                                        $new_plus = new ServicePlusBuy ();
                                        $new_plus->service_id = $service->id;
                                        $new_plus->plus_id = $item_plus->id;
                                        $new_plus->price = $item_plus->price;
                                        $new_plus->factor_id = $factor->id;
                                        $new_plus->buy_id = $servide_buy->id;
                                        $new_plus->user_id = auth()->user()->id;
                                        $new_plus->save();
                                        $plus_price += $item_plus->price;
                                    }
                                }
                            }
                        }
                    }
                }
                $factor->all_price += $plus_price;
                $factor->save();
                //off code set
                if (session()->has('off_id')) {
                    $off_code=OffCode::where('id',session('off_id'))->where('used','no')->where('status','active')->first();
                    if($off_code)
                    {
                        if($off_code->user_id==0)
                        {
                            $factor_set=ServiceFactor::where('user_id',Auth::user()->id)->where('off_code',$off_code->code)->wherein('pay_status',['paid','credit'])->first();
                            if(!$factor_set)
                            {
                                $total=$factor->all_price-($factor->all_price*$off_code->percent)/100;
                                $factor->off_code=$off_code->code;
                                $factor->off_percent=$off_code->percent;
                                $factor->total=$total;
                                $factor->save();
                            }
                        }
                        else {
                            if($off_code->user_id==Auth::user()->id)
                            {
                                $total=$factor->all_price-($factor->all_price*$off_code->percent)/100;
                                $factor->off_code=$off_code->code;
                                $factor->off_percent=$off_code->percent;
                                $factor->total=$total;
                                $factor->save();
                            }
                        }
                    }
                }
                session()->forget('package_slug');
                session()->forget('service_gold');
                session()->forget('plus');
                if (session()->has('price_id')) {
                    session()->forget('price_id');
                }
                if (session()->has('off_id')) {
                    session()->forget('off_id');
                }
                if (auth()->user()->reagent_code == 'rytl_user' || auth()->user()->sim == 'rightel') {
                    return redirect()->route('user.refah.pay', [$factor->id, "package"]);
                }
                if(!is_null($factor->total))
                {
                    return redirect()->route('user.zarinpal-pay-user', [$factor->id, $factor->total, Auth()->user()->id, "package"]);
                }
                else {
                    return redirect()->route('user.zarinpal-pay-user', [$factor->id, $factor->all_price, Auth()->user()->id, "package"]);
                }
            } catch (\Exception $e) {
                session()->forget('package_slug');
                session()->forget('service_gold');
                session()->forget('plus');
                if (session()->has('price_id')) {
                    session()->forget('price_id');
                }
                if (session()->has('off_id')) {
                    session()->forget('off_id');
                }
                return redirect()->back()->with('err_message','عملیات با مشکل مواجه شد، مجددا تلاش بفرمایید(catch)');
            }

        }
        session()->forget('package_slug');
        session()->forget('service_gold');
        session()->forget('plus');
        if (session()->has('price_id')) {
            session()->forget('price_id');
        }
        if (session()->has('off_id')) {
            session()->forget('off_id');
        }
        return redirect()->back()->with('err_message','عملیات با مشکل مواجه شد، مجددا تلاش بفرمایید(session)');
    }

    public function off_check($code,$price,Request $request)
    {
        $off_code=OffCode::where('code',$code)->where('status','active')->first();
        //isset code
        if($off_code)
        {
            // not used code
            if($off_code->used=='no')
            {
                // used code all user
                if($off_code->user_id==0)
                {
                    $factor=ServiceFactor::where('user_id',Auth::user()->id)->where('off_code',$code)->wherein('pay_status',['paid','credit'])->first();
                    //used user code all user
                    if($factor)
                    {
                        return
                            [
                                'type'=>'danger',
                                'msg'=>'کد تخفیف توسط شما استفاده شده',
                            ];
                    }
                    $total=$price-($price*$off_code->percent)/100;
                    return
                        [
                            'type'=>'success',
                            'percent'=>$off_code->percent,
                            'total'=>$total,
                            'msg'=>'کد تخفیف اعمال شد',
                        ];
                }
                // used code personal user
                else {
                    if($off_code->user_id==Auth::user()->id) {
                        $total=$price-($price*$off_code->percent)/100;
                        return
                            [
                                'type'=>'success',
                                'percent'=>$off_code->percent,
                                'total'=>$total,
                                'msg'=>'کد تخفیف اعمال شد',
                            ];
                    }
                    else {
                        return
                            [
                                'type'=>'danger',
                                'msg'=>'کد تخفیف اشتباه می باشد',
                            ];
                    }
                }
            }
            // used code Check out the credit
            else {
                return
                    [
                        'type'=>'danger',
                        'msg'=>'اعتبار کد تخفیف به اتمام رسیده',
                    ];
            }
        }
        // not code
        else {
            return
            [
                'type'=>'danger',
                'msg'=>'کد تخفیف اشتباه می باشد',
            ];
        }
    }
}
