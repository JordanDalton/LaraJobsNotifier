<?php

namespace App\Console\Commands;

use App\Events\NewLaraJob;
use App\Http\Integrations\LaraJobs\LaraJobsConnector;
use App\Http\Integrations\LaraJobs\Requests\CheckForJobsRequest;
use App\Models\Larajobs;
use Illuminate\Console\Command;
use Native\Laravel\Notification;

class CheckForNewJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:new-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connector = new LaraJobsConnector();
        $response  = $connector->send(new CheckForJobsRequest);

        $data = [
            'title' => (string) $response->xml()->channel->item->title,
            'link' => (string) $response->xml()->channel->item->link,
            'published_at' => (string) $response->xml()->channel->item->pubDate,
        ];

        //Notification::new()->title("test")->message("test")->show();

        $job = Larajobs::updateOrCreate(['link' => $data['link']], $data);

        //event(new NewLaraJob($job));
    }
}
