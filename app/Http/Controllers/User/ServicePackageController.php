<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceCat;
use App\Model\ServicePackage;
use App\Model\ServiceJoinPackage;
use App\Model\ServicePackagePrice;
use App\Model\Photo;
use App\Model\Filep; 
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServicePackageController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'پکیج خدمات';
        } elseif ('single') {
            return 'پکیج خدمت';
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
        $items = ServicePackage::where('type','sample')->orderBy('sort_by', 'ASC')->paginate($this->controller_paginate());
        return view('admin.service.package.index', compact('items'), ['title1' => 'خدمات', 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $items = Service::orderBy('title', 'asc')->get();
        return view('admin.service.package.create', compact('items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages',
            'text' => 'required',
//            'limited' => 'required',
            'price' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'required|image|mimes:jpeg,jpg,png|max:5120',
//            'file' => 'nullable|mimes:pdf|max:30720',
//            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.required' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
//                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
//                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
//                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
//                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        if ($request->home_view == "on") {
            $pakege = ServicePackage::where("custom", 1)->count();
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }
        try {
            $item = new ServicePackage();
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->text = $request->text;
            $item->sort_by = $request->sort_by;
//            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
//            $item->limited = $request->limited;
            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->save();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->service) {
                foreach ($request->service as $key => $service) {
                    $join = new ServiceJoinPackage();
                    $join->service_id = $service;
                    $join->package_id = $item[$key]->id;
                    $join->sort_by = $key;
                    $join->save();
                }
            }
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                /*img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );*/
            }
//            if ($request->hasFile('file')) {
//                $file = new Filep();
//                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
//                $item->file()->save($file);
//            }
//            if ($request->hasFile('video')) {
//                $video = new Video();
//                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
//                $item->video()->save($video);
//            }
            return redirect()->route('admin.service.package.list')->with('flash_message', 'پکیج خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد پکیج خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {

        $item = ServicePackage::find($id);
//        dd($item->join);
        $items = Service::where('category_id','!=',4)->orderBy('title', 'asc')->get();
        $service = [];
        foreach ($item->joins as $i) {
            array_push($service, $i->service_id);
        }
        return view('admin.service.package.edit', compact('item', 'items', 'service'), ['title1' => 'خدمات', 'title2' => 'ویرایش پکیج خدمت']);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages,slug,' . $id,
            'text' => 'required',
//            'limited' => 'required',
            'price' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
//            'file' => 'nullable|mimes:pdf|max:30720',
//            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
//                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
//                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
//                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
//                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        $item = ServicePackage::find($id);
        if ($request->home_view == "on") {
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->where('id', '!=', $item->id)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }

        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->text = $request->text;
            $item->sort_by = $request->sort_by;
//            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
            $item->limited = $request->limited;
            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                if ($item->pic_card != null) {
                    $old_path = $item->pic_card;
                    File::delete($old_path);
                }
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->update();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }


            if ($request->service) {


                foreach (ServiceJoinPackage::where('package_id',$item->id)->get() as $joins) {
                    if(!in_array($joins->service_id,$request->service)){
                        $joins->delete();
                    }

                }


                foreach ($request->service as $key => $service) {
                    if(!ServiceJoinPackage::where('service_id',$service)->where('package_id',$item->id)->first()){
                        $join = new ServiceJoinPackage();
                        $join->service_id = $service;
                        $join->package_id = $item[$key]->id;
                        $join->save();
                    }
                }
            }

            if ($request->hasFile('photo')) {
                if ($item->photo) {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                /*img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );*/
            }
//            if ($request->hasFile('file')) {
//                if ($item->file) {
//                    $old_path = $item->file->path;
//                    File::delete($old_path);
//                    $item->file->delete();
//                }
//                $file = new Filep();
//                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
//                $item->file()->save($file);
//            }
//            if ($request->hasFile('video')) {
//                if ($item->video) {
//                    $old_path = $item->video->path;
//                    File::delete($old_path);
//                    $item->video->delete();
//                }
//                $video = new Video();
//                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
//                $item->video()->save($video);
//            }
            return redirect()->route('admin.service.package.list')->with('flash_message', 'پکیج خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش پکیج خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServicePackage::find($id);
        $items = ServiceJoinPackage::where('package_id', $id)->get();
        $prices = ServicePackagePrice::where('package_id', $id)->get();
        try {
            if(count($items)>0)
            {
                foreach ($items as $item1) {
                    $item1->delete();
                }
            }

            if(count($prices)>0)
            {
                foreach ($prices as $price) {
                    $price->delete();
                }
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'پکیج خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف پکیج خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function active($id, $type)
    {
        $item = ServicePackage::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت پکیج خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function sort_by_join(Request $request)
    {
        try {
            foreach ($request->id_join as $key => $id) {
                $srvice_join = ServiceJoinPackage::find($id);
                $srvice_join->sort_by = $request->sort_by[$key];
                $srvice_join->save();
            }
            return redirect()->back()->with('flash_message', 'ترتیب نمایش با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی بوجود آمده لطفا دباره تلاش کنید');
        }
    }

    public function learn_index()
    {
        $items = ServicePackage::where('type','learning')->orderBy('sort_by', 'ASC')->paginate($this->controller_paginate());
        return view('admin.service.package.learn.index', compact('items'), ['title1' => 'خدمات', 'title2' => 'پکیج آموزشی']);
    }

    public function learn_create()
    {
        $cats = ServiceCat::where('type','package')->where('id','!=',4)->get();
        $items = Service::where('category_id','=',4)->orderBy('title', 'asc')->get();
        return view('admin.service.package.learn.create', compact('items','cats'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج آموزشی']);
    }

    public function learn_store(Request $request)
    {
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages',
            'text' => 'required',
//            'limited' => 'required',
//            'price' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
//            'video.*' => 'nullable|mimes:mp4|max:51200',
//            'video_sale.*' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.required' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
//                'video.*.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(رایگان)',
//                'video.*.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(رایگان)',
//                'video_sale.*.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(بعد خرید پکیج)',
//                'video_sale.*.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(بعد خرید پکیج)',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        if ($request->home_view == "on") {
            $pakege = ServicePackage::where("custom", 1)->count();
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }
        try {
            $item = new ServicePackage();
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->category_id = $request->category_id;
            $item->type = "learning";
            $item->text = $request->text;
            if ($request->sort_by!=null){
                $item->sort_by = $request->sort_by;
            }
//            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
//            $item->limited = $request->limited;
//            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->save();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->service) {
                foreach ($request->service as $key => $service) {
                    $join = new ServiceJoinPackage();
                    $join->service_id = $service;
                    $join->package_id = $item->id;
                    $join->sort_by = $key;
                    $join->save();
                }
            }
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('inner_pic')) {
                $photo = new Photo();
                $photo->path = file_store($request->inner_pic, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $photo->place="inner_page";
                $item->photo()->save($photo);
            }
            if ($request->hasFile('program')) {
                $photo = new Photo();
                $photo->path = file_store($request->program, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $photo->place="program";
                $item->photo()->save($photo);
            }

            if ($request->hasFile('file')) {
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
//            if ($request->hasFile('video')) {
//                $video = new Video();
//                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
//                $item->video()->save($video);
//            }
//            if ($request->hasFile('video_sale')) {
//                $video_sale = new Video();
//                $video_sale->path = file_store($request->video_sale, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-sale-');;
//                $video_sale->type='sale';
//                $item->video()->save($video_sale);
//            }
            return redirect()->route('admin.service.learn.package.list')->with('flash_message', 'پکیج آموزشی با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function learn_edit($id)
    {
        $cats = ServiceCat::where('type','package')->where('id','!=',4)->get();
        $item = ServicePackage::find($id);
//        dd($item->join);
        $items = Service::where('category_id','=',4)->orderBy('title', 'asc')->get();
        $service = [];
        foreach ($item->joins as $i) {
            array_push($service, $i->service_id);
        }
        return view('admin.service.package.learn.edit', compact('item','cats', 'items', 'service'), ['title1' => 'خدمات', 'title2' => 'ویرایش پکیج آموزشی']);
    }

    public function learn_update(Request $request, $id)
    {
//        dd($request->all());
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages,slug,' . $id,
            'text' => 'required',
//            'limited' => 'required',
//            'price' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
//            'video' => 'nullable|mimes:mp4|max:51200',
//            'video_sale' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
//                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(رایگان)',
//                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(رایگان)',
//                'video_sale.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(بعد خرید پکیج)',
//                'video_sale.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(بعد خرید پکیج)',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        $item = ServicePackage::find($id);
        if ($request->home_view == "on") {
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->where('id', '!=', $item->id)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }

        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->category_id = $request->category_id;
            $item->text = $request->text;
            $item->type = "learning";
            $item->sort_by = $request->sort_by;
//            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
            $item->limited = $request->limited;
//            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                if ($item->pic_card != null) {
                    $old_path = $item->pic_card;
                    File::delete($old_path);
                }
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->update();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }

            if ($request->service) {
                if (count($item->joins) > 0) {
                    foreach ($item->joins as $joins) {
                        $joins->delete();
                    }
                }
                foreach ($request->service as $key => $service) {
                    $join = new ServiceJoinPackage();
                    $join->service_id = $service;
                    $join->package_id = $item->id;
                    $join->save();
                }
            }

            if ($request->hasFile('photo')) {
                if ($item->photo) {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('inner_pic')) {
                if ($item->photo_inner_page) {
                    $old_path = $item->photo_inner_page->path;
                    File::delete($old_path);
                    $item->photo_inner_page->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->inner_pic, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-inner-');;
                $photo->place="inner_page";
                $item->photo()->save($photo);

            }
            if ($request->hasFile('program')) {
                if ($item->program) {
                    $old_path = $item->program->path;
                    File::delete($old_path);
                    $item->photo_inner_page->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->program, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-inner-');;
                $photo->place="program";
                $item->photo()->save($photo);

            }
            if ($request->hasFile('file')) {
                if ($item->file) {
                    $old_path = $item->file->path;
                    File::delete($old_path);
                    $item->file->delete();
                }
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
//            if ($request->hasFile('video')) {
//                if ($item->video) {
//                    $old_path = $item->video->path;
//                    File::delete($old_path);
//                    $item->video->delete();
//                }
//                $video = new Video();
//                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
//                $item->video()->save($video);
//            }
//            if ($request->hasFile('video_sale')) {
//                if ($item->video_sale) {
//                    $old_path = $item->video_sale->path;
//                    File::delete($old_path);
//                    $item->video_sale->delete();
//                }
//                $video_sale = new Video();
//                $video_sale->path = file_store($request->video_sale, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-sale-');;
//                $video_sale->type='sale';
//                $item->video()->save($video_sale);
//            }
            return redirect()->route('admin.service.learn.package.list')->with('flash_message', 'پکیج آموزشی با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function learn_destroy($id)
    {
        $item = ServicePackage::find($id);
        $items = ServiceJoinPackage::where('package_id', $id)->get();
        $prices = ServicePackagePrice::where('package_id', $id)->get();
        try {
            if(count($items)>0)
            {
                foreach ($items as $item1) {
                    $item1->delete();
                }
            }

            if(count($prices)>0)
            {
                foreach ($prices as $price) {
                    $price->delete();
                }
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'پکیج آموزشی با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function learn_active($id, $type)
    {
        $item = ServicePackage::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج آموزشی با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج آموزشی با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function learn_sort_by_join(Request $request)
    {
        try {
            foreach ($request->id_join as $key => $id) {
                $srvice_join = ServiceJoinPackage::find($id);
                $srvice_join->sort_by = $request->sort_by[$key];
                $srvice_join->save();
            }
            return redirect()->back()->with('flash_message', 'ترتیب نمایش با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی بوجود آمده لطفا دباره تلاش کنید');
        }
    }
}


