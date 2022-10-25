<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceCat;
use App\Model\ServicePackage;
use App\Model\ServiceJoinPackage;
use App\Model\ServicePackagePrice;
use App\Model\Photo;  
use App\Model\Filep;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController2 extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'دسته بندی های غذاها';
        } elseif ('single') {
            return 'دسته ی غذاها';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();
        return view('user.restaurant.categories.index', compact('categories'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    // public function show($id)
    // {
    //     $ServiceCat = Category::find($id);
    //     $items = Service::where('food_type', $ServiceCat->id)->get();
    //     // $items = Service::where('category_id',$category_id)->orderByDesc('id')->paginate(50);

    //     // return view('user.category.edit', compact('item', 'items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    //     return view('user.services', compact('ServiceCat','items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    // }

    public function create()
    {
        return view('user.restaurant.categories.create', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function store(Request $request)
    {
        // TODO az resturan karbar
        $cat = new Category();
        $cat->user_id   = auth()->user()->id;
        $cat->title     = $request->title;
        // $cat->slug      = $request->slug;
        $cat->status    = $request->status;
        $cat->save();
        return back();
    }

    public function edit($id)
    {
        $cat = Category::find($id);
        return view('user.restaurant.categories.edit', compact('cat'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function update(Request $request ,$id)
    {
        $item = Category::where('user_id', auth()->user()->id)->findOrFail($id);
        $item->title   = $request->title;
        // $item->slug    = $request->slug;
        $item->status  = $request->status;
        $item->save();
        return redirect()->route('user.restaurant-food-categories.index')->with('flash_message', 'دسته با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $item = Category::where('user_id', auth()->user()->id)->findOrFail($id);
        try {
            if(Service::where('food_type', $item->id)->count())
            {
                // return redirect()->back()->with('این دسته دارای غذاهایی هست و قابل حذف نمی باشد');
                $err_message = 'این دسته دارای غذاهایی هست و قابل حذف نمی باشد';
                $categories = Category::where('user_id', auth()->user()->id)->get();
                return view('user.restaurant.categories.index', compact('categories','err_message'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'غذا با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف غذا بوجود آمده،مجددا تلاش کنید');
        }
    }
    
}


