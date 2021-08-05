<?php

namespace App\Http\Controllers;
use App\Models\URL;
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

        return json_encode([
            'saved' => $saved,
            'url' => 'http://localhost/' . $newURL->shortcode
        ]);
    }

    private function test() {
        //Test the first 1000 sample entries into the DB
        for($i = 0; $i < 10000; $i++) {
            echo $this->shortenService->shorten($i);
            echo_newline();
        }
    }
}
