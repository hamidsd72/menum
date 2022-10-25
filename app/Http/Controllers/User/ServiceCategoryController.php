<?php

namespace App\Http\Controllers\User;

use App\User; 
use Carbon\Carbon;
use App\Model\Setting;
use App\Model\ServiceCat;
use App\Model\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class ServiceCategoryController extends Controller 
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'فروشگاه ها';
        } elseif ('single') {
            return 'فروشگاه';
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
        $items = ServiceCat::where('type','service')->paginate($this->controller_paginate());
        foreach ($items as $item) {
            if ($item->updated_at && Carbon::now()->diffInDays($item->updated_at, false) > 0) {
                $item->slug = Carbon::now()->diffInDays($item->updated_at, false).' روز اشتراک دارد';
            } else {
                $item->slug = 'اشتراک ندارد';
            }
        }
        
        return view('admin.service.category.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        return view('admin.service.category.create', ['title1' => $this->controller_title('single'), 'title2' => ' افزودن '.$this->controller_title('single')]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats',
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
            ]);
        try {
            $item = new ServiceCat();
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->address = $request->address;
            $item->email = $request->email;
            $item->user_id = auth()->user()->id;

            if ($request->hasFile('banner')) {
                $item->banner = file_store($request->banner, 'source/asset/uploads/banner/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            }
            $item->save();
            return redirect()->route('user.index')->with('flash_message', 'دسته بندی خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message', 'مشکلی در ایجاد دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($restaurant)
    {
        $res = ServiceCat::where('user_id', auth()->user()->id)->first();
        // $res = ServiceCat::where('user_id', auth()->user()->id)->findOrFail($id);
        $url = url('/').'/'.'store/'.$res->slug.'/'.auth()->user()->id;
        if ($res->updated_at && Carbon::now()->diffInDays($res->updated_at, false) > 0) {
            $res->slug = Carbon::now()->diffInDays($res->updated_at, false).' روز اشتراک دارد';
        } else {
            $res->slug = 'اشتراک ندارد';
        }

        return view('user.restaurant.edit', compact('res','url'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function update(Request $request, $restaurant)
    {
        $this->validate($request, [
            // 'title' => 'required|max:240',
            // 'slug' => 'required|max:250|unique:service_cats,slug,'.$id,
        ],
            [
                // 'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                // 'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                // 'slug.required' => 'لطفا نامک را وارد کنید',
                // 'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                // 'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
            ]);
        $item = ServiceCat::where('user_id', auth()->user()->id)->first();
        try {
            if ($request->title) {
                $item->title = $request->title;
            }
            if ($request->email) {
                $item->email = $request->email;
            }
            if ($request->address) {
                $item->address = $request->address;
            }
            if ($request->dial) {
                $item->dial = $request->dial;
            }
            if ($request->whatsapp) {
                $item->whatsapp = $request->whatsapp;
            }
            if ($request->instagram) {
                $item->instagram = $request->instagram;
            }
            if ($request->hasFile('banner')) {
                $item->banner = file_store($request->banner, 'source/asset/uploads/banner/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            }

            $item->update();
            return redirect()->route('user.index')->with('flash_message','فروشگاه با موفقیت بروزرسانی شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message', 'مشکلی در ویرایش دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($restaurant)
    {
        $item = ServiceCat::where('user_id', auth()->user()->id)->find($id);
        $item->banner = '';
        $item->save();
        return back()->with('flash_message','بنر فروشگاه با موفقیت حذف شد');;
    }
}


