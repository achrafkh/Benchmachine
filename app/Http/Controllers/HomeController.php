<?php

namespace App\Http\Controllers;

use App\Acme\Wrapers\Utils;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;

    public function __construct(Utils $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benchmarks = auth()->user()->benchmarks()->with('accounts')->get();
        return view('home', compact('benchmarks'));
    }

}
