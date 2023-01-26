<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

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
//        if (Auth::user()->hasRole('Admin')) {
//            return view('feedbacks.index');
//            redirect('Location - ')
//        } elseif (Auth::user()->hasRole('User')) {
//            return view('feedbacks.create');
//        } else {
        return view('home');
//        }
    }
}

