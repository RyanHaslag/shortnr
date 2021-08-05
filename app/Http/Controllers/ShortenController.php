<?php

namespace App\Http\Controllers;
use App\Models\URL;
use Illuminate\Http\Request;

//Traits
use App\Traits\ResponseFormatter;

//Services
use App\Services\ShortenService;
use Illuminate\Support\Facades\Redirect;

class ShortenController extends Controller
{
    use ResponseFormatter;

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

    public function map($shortURL) {
        //Validate that the provided short URL is only alphanumeric
        if(!ctype_alnum($shortURL)) {
            return view('home')->with($this->viewResponseFormatter(null,'error', "Oops! It looks like something is wrong with your link. Please try again.", null));
        }

        //Search for the short URL in the database
        $foundURL = URL::where('shortcode', $shortURL)->first();
        //If a URL has been found with the provided shortcode, redirect the user
        if($foundURL) {
            //todo Check for the NSFW flag boolean on the bonus

            return Redirect::to($foundURL->full_url, 302);
        }

        //Handle an incorrectly provided shortcode with errors
        return view('home')->with($this->viewResponseFormatter(null,'error', "We weren't able to find that link! Please try again.", null));
    }

    public function shorten(Request $request): string {
        //Set the default current index to 1 to handle the first record entry into the DB
        $currentIndex = 1;

        //Validate the incoming full URL provided by the user
        $request->validate(['fullURL' => 'required | url']);
        $fullURL = $request->input('fullURL');

        //Check to see if there is a URL record in the DB
        $latestURL = URL::latest()->first();
        if($latestURL) {
            $currentIndex = (int) $latestURL->id + 1;
        }

        //Create the shortcode for the URL
        $shortcode = $this->shortenService->shorten($currentIndex);

        //Save the new record to the DB
        $newURL = new URL();
        $newURL->shortcode = $shortcode;
        $newURL->full_url = $fullURL;
        $newURL->url_title = '';
        $newURL->nsfw = false;
        $newURL->visit_count = 0;
        $saved = $newURL->save();

        //Handle errors if the model was not able to be saved
        if(!$saved) {
            return view('home')->with($this->viewResponseFormatter(null,'error', "We weren't able to create that link! Please try again.", null));
        }

        return $this->apiResponseFormatter('http://localhost/' . $newURL->shortcode, 'success', '');
    }
}
