<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function profile()
    {
        $user=auth()->user();
       
        return view("profile",compact("user"));
    }
    public function updateaccount()
    {
        $errors=request()->validate([
        "fname" => "required|min:3",
            "lname" => "required|min:3",

            "current_pwd" => "nullable|current_password",

            "new_pwd"=>"nullable|required_with:current_pwd|min:3",

            "confirm_pwd"=>"same:new_pwd",
        ]);
            

    auth()->user()->update(['fname'=>request()->fname,'lname'=>request()->lname]);

    if(request()->current_pwd)

    {

        auth()->user()->update(['password'=> Hash::make(request()->new_pwd)]);
        Auth::logout();
        return json_encode(["a"=>1]);

         

    }
       return  json_encode(["a"=>"profile Updated Successfully"]);
    }
    public function updateaddress()
    {
        
                $address=[
        "address1"=>request()->address1,
        "address2"=>request()->address2,
        "phone"=>request()->phone,
                 ];
                 auth()->user()->update($address);
        return 1;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
}
