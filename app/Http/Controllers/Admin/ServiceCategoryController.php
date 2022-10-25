<?php

namespace App\Http\Controllers\Admin;

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
            return 'رستوران ها';
        } elseif ('single') {
            return 'رستوران';
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
        $users = User::all();
        return view('admin.service.category.create', compact('users'), ['title1' => $this->controller_title('single'), 'title2' => ' افزودن '.$this->controller_title('single')]);
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
            $item->user_id = intval($request->user_id);

            if ($request->hasFile('banner')) {
                $item->banner = file_store($request->banner, 'source/asset/uploads/banner/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            }
            
            $item->save();
            return redirect()->route('admin.service.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = ServiceCat::find($id);
        $users = User::all();
        return view('admin.service.category.edit', compact('item', 'users'), ['title1' => 'خدمات', 'title2' => 'ویرایش دسته بندی خدمت']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats,slug,'.$id,
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
            ]);
        $item = ServiceCat::find($id);
        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->user_id = intval($request->user_id);

            if ($request->hasFile('banner')) {
                $item->banner = file_store($request->banner, 'source/asset/uploads/banner/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            }

            $item->update();
            return redirect()->route('admin.service.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServiceCat::find($id);
        try {
            if(count($item->service)>0)
            {
                return redirect()->back()->withInput()->with('err_message', 'دسته دارای خدمات می باشد و نمیتوان حذف کرد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'دسته بندی خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function active($id, $type)
    {
        $item = ServiceCat::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش دسته بندی خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش دسته بندی خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


