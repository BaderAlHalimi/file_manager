<?php

namespace App\Listeners;

use App\Events\DownloadEvent;
use App\Models\File;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class DownloadListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DownloadEvent $event): void
    {
        //
        $file = $event->file;
        $response = Http::get('https://api.ipgeolocation.io/ipgeo', ['apiKey' => 'e4c3bb4dc2564c67b84cc8e58eade491', 'ip' => $file->ip, 'fields' => 'city'])->json();
        $city = $response['city']??'';
        $file->downloadsRelation()->create(['ip' => $file->ip, 'city' => $city]);
        $id = $file->id;
        $file = File::find($id);
        $file->update(['downloads' => $file->downloads + 1]);
    }
}
