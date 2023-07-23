<?php

use App\Http\Integrations\LaraJobs\LaraJobsConnector;
use App\Http\Integrations\LaraJobs\Requests\CheckForJobsRequest;
use Illuminate\Support\Facades\Route;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $connector = new LaraJobsConnector();
    $response  = $connector->send(new CheckForJobsRequest);
    $results   = $response->xml();
    $items     = $results->channel->item;
    $jobs      = collect();

    foreach($items as $job)
    {
        $jobs->push([
            'title' => (string) $job->title,
            'link' => (string) $job->link,
            'published_at' => (string) $job->pubDate,
        ]);
    }

    $prior       = session()->get('latest');
    $latest      = $jobs->sortByDesc('published_at')->first();
    $latest_link = $latest['link'];

    if(session()->has('latest'))
    {
        if($latest !== $prior)
        {
            Notification::new()->title('New Job')->message($latest['title'])->show();
        }
    }

    session()->put('latest', $latest_link);

    return view('welcome', [
        'jobs' => $jobs->sortByDesc('published_at')
    ]);
});

Route::get('notify', function(){
    $client = new Client();
    $notification = new Notification($client);
    $notification->title('Hello from NativeApp')
        ->message('This is a detailed message coming from your native app.')
        ->show();

    return true;
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
