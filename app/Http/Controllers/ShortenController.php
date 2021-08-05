<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Services
use App\Services\ShortenService;

class ShortenController extends Controller
{
    protected $shortenService;

    /**
     * Create a new controller instance.
     *
     * @param ShortenService $shortenService
     */
    public function __construct(ShortenService  $shortenService)
    {
        $this->shortenService = $shortenService;
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        return view('home');
    }

    public function shorten(Request $request) {
        //Test the first 1000 sample entries into the DB
        for($i = 0; $i < 10000; $i++) {
            echo $this->shortenService->shorten($i);
            echo_newline();
        }
    }
}
