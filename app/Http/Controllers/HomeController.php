<?php

namespace App\Http\Controllers;

use App\Acme\Wrapers\Utils;

class HomeController extends Controller
{
    protected $repo;

    /**
     * Create a new controller instance.
     * @param Utils $repo An instance of Utils class
     * @return void
     */
    public function __construct(Utils $repo)
    {
        $this->middleware('auth')->except(['index']);
        $this->repo = $repo;
    }

    /**
     * Render Front page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard after authentication.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $benchmarks = auth()->user()->benchmarks()->with('accounts')->get();
        return view('home', compact('benchmarks'));
    }

}
