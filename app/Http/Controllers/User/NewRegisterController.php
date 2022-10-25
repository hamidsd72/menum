<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Sms;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Model\Filep; 
use App\Model\ProvinceCity;
use Illuminate\Support\Facades\Cookie;
use App\Model\Category;
use App\Model\ServiceCat;
use App\Model\Photo;
use App\Model\Service;


class NewRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ( strlen($request->mobile) == 11 ) {
            $number          = $request->mobile;
            $mobile_verified = rand(100000, 999999);
            $user            = User::where('mobile', $number)->first();
    
            if ($user) {
                $user->mobile_verified = $mobile_verified;
                $user->update();
    
            } else {
                $user = User::create([
                    'mobile'          => $number,
                    'password'        => Hash::make($number),
                    'mobile_verified' => $mobile_verified,
                ]);
                $user->assignRole('کاربر');
            }
            // Sms::SendSms( (' کد ورود به اپلیکیشن منوم : '.$user->mobile_verified) , $number);
            Sms::TurkSendSms( ('Menom%20uygulamasına%20giriş%20kodu%20:'.$user->mobile_verified) , $number);
            return redirect('/sign-up-using-mobile/'.$number.'/edit');
        }
        $error = 'شماره وارد شده نامعتبر است';
        return view('auth.login', compact('error') );
    }

    public function show($sign_up_using_mobile)
    {
    //     // resturan 
    //     $restaurant = ServiceCat::where('slug', $name)->where('user_id', $id)->first();
    //     // cat food
    //     if (!$restaurant) {
    //         abort(503, 'You Access Denied');
    //     }
    //     $serviceCat = Category::where('status', 'active')->where('user_id', $id)->get(); 
    //     //food
    //     $items = Service::whereIn('food_type', $serviceCat->pluck('id'))->get();
    //     foreach ($items as $item) {
    //         if(!empty($item->price)) {
    //             $item->price = fa_number( number_format($item->price) ).' تومان ';
    //         }
    //     }
    //     //food photo
    //     $food_photo = Photo::where('pictures_type', 'App\Model\Service')->whereIn('pictures_id', $items->pluck('id'))->get();

    //     return view('auth.register2', compact('restaurant','serviceCat','items','food_photo'));
    
    }

    public function edit($sign_up_using_mobile)
    {
        $number = $sign_up_using_mobile;
        return view('auth.verify', compact('number') );
    }

    public function update(Request $request, $sign_up_using_mobile)
    {
        
        if ( strlen($request->code) == 6 ) {
            $user = User::where('mobile',$sign_up_using_mobile)->first();
            
            if ($user->mobile_verified == $request->code  && $user->updated_at->diffInMinutes(Carbon::now(), false) < 5) {
                auth()->loginUsingId($user->id, true);
                return redirect()->route('user.index');
            }
            $error  = 'کد صحیح نیست یا تاریخ گذشته است';
        } else {
            $error = 'کد وارد شده نامعتبر است';
        }

        $number = $sign_up_using_mobile;
        return view('auth.verify', compact('number', 'error') );
    }

    public function destroy($id)
    {
        //
    }
}