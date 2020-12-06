<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function genderIndex()
    {
        return view('fillGender');
    }

    public function genderUpdate(Request $request)
    {
        $user = Auth::user();
        if($request->has('gender')){
            if($request->gender == 'male' || $request->gender == 'female'){
                $user->gender = $request->gender;
            }
        }else{
            return back()->withErrors(['gender' => ['Please select a gender!']]);
        }

        if($user->save()){
            return redirect('home');
        }else{
            return back()->withErrors(['gender' => ['Something went wrong!! ']]);
        }
    }

}
