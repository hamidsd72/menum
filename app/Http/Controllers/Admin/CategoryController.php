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
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
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
        $items = Category::all();
        // ->paginate($this->controller_paginate());
        return view('admin.category.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $items = ServiceCat::where('type','service')->get();
        return view('admin.category.create', compact('items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    }

    public function store(Request $request)
    {
        $cat = new Category();
        $cat->user_id  = auth()->user()->id;
        $cat->title= $request->title;
        $cat->slug = $request->slug;
        $cat->status   = $request->status;
        $cat->save();

        return redirect()->route('admin.food-category.index');

    }

    public function edit($id)
    {
        $item = Category::find($id);
        $items = ServiceCat::where('type','service')->get();
        return view('admin.category.edit', compact('item', 'items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    }

    public function update(Request $request ,$id)
    {
        $item = Category::find($id);
        dd($request->all(), $item);
        $items = ServiceCat::where('type','service')->get();

        return view('admin.category.edit', compact('item', 'items'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج خدمت']);
    }

    public function delete($id) 
    {
        dd($id);
    }

}


