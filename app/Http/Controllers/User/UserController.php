<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Model\ServiceCat;


class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
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
        //
    }

    public function show($myuser)
    {
        //
    }

    public function edit($myuser)
    {
        //
    }

    public function update(Request $request, $myuser)
    {
        $this->validate($request, [
            'first_name'        => ['string', 'max:255'],
            'last_name'         => ['string', 'max:255'],
            'email'             => ['email', 'max:255', 'unique:users'],
            'res_name'          => ['string', 'max:255'],
            'locale'            => ['string', 'max:2'],
        ]);
        $user = User::find(auth()->user()->id);

        if ($request->first_name) {
            $user->first_name   = $request->first_name;
        }

        if ($request->last_name) {
            $user->last_name    = $request->last_name;
        }

        if ($request->email) {
            $user->email        = $request->email;
        }

        if ($request->locale) {
            $user->locale        = $request->locale;
        }

        if ($request->res_name) {
            $item = new ServiceCat();
            $item->user_id      = auth()->user()->id;
            $item->title        = $request->res_name;
            $slug = str_replace("/","-",Hash::make($request->res_name));
            $item->slug         = str_replace("?","-",$slug);

            $item->save();
        }

        $user->update();
        return redirect()->route('user.index');
    }

    public function destroy($myuser)
    {
        //
    }
}