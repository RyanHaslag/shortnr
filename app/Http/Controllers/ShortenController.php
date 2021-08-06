<?php

namespace App\Http\Controllers;

//Models
use App\Models\URL;

//Return classes
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Take a provided short URL and find the
     * corresponding record in the DB to redirect the
     * user to the full URL
     *
     * @param $shortURL
     * @return Application|Factory|View|RedirectResponse
     */
    public function map($shortURL) {
        //Validate that the provided short URL is only alphanumeric
        if(!ctype_alnum($shortURL)) {
            return view('home')->with($this->viewResponseFormatter(null,'error', "Oops! It looks like something is wrong with your link. Please try again.", null));
        }

        //Search for the short URL in the database
        $foundURL = URL::where('shortcode', $shortURL)->first();
        //If a URL has been found with the provided shortcode, redirect the user
        if($foundURL) {
            //Increment the view count of the found URL for tracking the top 100 URL's
            $foundURL->increment('visit_count');

            //Check for the NSFW flag
            if($foundURL->nsfw) {
                return view('caution')->with(['fullURL' => $foundURL->full_url]);
            }

            return Redirect::to($foundURL->full_url, 302);
        }

        //Handle an incorrectly provided shortcode with errors
        return view('home')->with($this->viewResponseFormatter(null,'error', "We weren't able to find that link! Please try again.", null));
    }

    /**
     * Take a full URL and generate a shortcode to
     * be given back to the user. Store NSFW links
     * with boolean to caution future users who visit the link
     *
     * @param Request $request
     * @return string
     */
    public function shorten(Request $request): string {
        //Set the default current index to 1 to handle the first record entry into the DB
        $currentIndex = 1;

        //Validate the incoming full URL provided by the user
        $request->validate([
            'fullURL' => 'required | url',
            'nsfw' => 'boolean'
        ]);

        $fullURL = $request->input('fullURL');
        $nsfw = $request->input('nsfw');

        //Check to see if there is a URL record in the DB
        $latestURL = URL::latest()->first();
        if($latestURL) {
            $currentIndex = (int) $latestURL->id + 1;
        }

        //Create the shortcode for the URL
        $shortcode = $this->shortenService->shorten($currentIndex);

        //Check that the shortcode generated does not match already taken routes by the application
        if($shortcode == 'top' || $shortcode == 'shorten') {
            //Increment the index and generate a new shortcode
            $shortcode = $this->shortenService->shorten($currentIndex + 1);
        }

        //Save the new record to the DB
        $newURL = new URL();
        $newURL->shortcode = $shortcode;
        $newURL->full_url = $fullURL;
        $newURL->url_title = '';
        $newURL->nsfw = $nsfw;
        $newURL->visit_count = 0;
        $saved = $newURL->save();

        //Handle errors if the model was not able to be saved
        if(!$saved) {
            return view('home')->with($this->viewResponseFormatter(null,'error', "We weren't able to create that link! Please try again.", null));
        }

        return $this->apiResponseFormatter('http://localhost/' . $newURL->shortcode, 'success', '');
    }

    /**
     * Query for the "top 100" most visited links
     * and return to the view for display
     *
     * @return Application|Factory|View
     */
    public function top() {
        //Query for the top 100 URL's by view count
        $topURLs = URL::orderBy('visit_count', 'desc')->take(100)->get();

        return view('top')->with(['topURLs' => $topURLs]);
    }
}
