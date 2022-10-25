<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Model\About;
use App\Model\AboutJoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function show()
    {
        $item=About::find(1);
        $items=AboutJoin::where('type','about')->get();
        return view('user.about.show',compact('item','items'));
    }

}
