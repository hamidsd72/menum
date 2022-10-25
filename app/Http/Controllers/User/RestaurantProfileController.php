<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServiceCat;
use App\Model\Photo;
use App\Model\RestaurantProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RestaurantProfileController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'پروفایل ها';
        } elseif ('single') {
            return 'پروفایل';
        }
    }
}