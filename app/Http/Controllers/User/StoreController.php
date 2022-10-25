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


class StoreController extends Controller
{

    public function show($name, $id)
    {
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
        
        // resturan 
        $restaurant = ServiceCat::where('slug', $name)->where('user_id', $id)->first();
        // cat food
        if (!$restaurant) {
            abort(503, 'You Access Denied');
        }
        $serviceCat = Category::where('status', 'active')->where('user_id', $id)->get(); 
        //food
        $items = Service::whereIn('food_type', $serviceCat->pluck('id'))->get();
        foreach ($items as $item) {
            if(!empty($item->price)) {
                $item->price = fa_number( number_format($item->price) ).' تومان ';
            }
        }
        //food photo 
        $food_photo = Photo::where('pictures_type', 'App\Model\Service')->whereIn('pictures_id', $items->pluck('id'))->get();

        return view('auth.register', compact('restaurant','serviceCat','items','food_photo'));
        // return view('auth.register2', compact('restaurant','serviceCat','items','food_photo'));
    
    }

}