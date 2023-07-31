<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    //
    function downloadFolder($url)
    {
        $file_ = File::where('id',Url::where('url', $url)->latest()->first()->file_id)->first();
        $url = $file_->url;
        $name = $file_->name;
        
        $path = Storage::disk('app')->path('/files/' . $url);
        $zipFileName = $name . '.zip';
        $zip = new \ZipArchive;
        $zip->open($path . '/' . $zipFileName, \ZipArchive::CREATE);
        
        
        $files = Storage::disk('app')->files('/files/' . $url);
        foreach ($files as $file) {
            # code...
            $zip->addFile($path . '/' . basename($file), basename($file));
        }
        $path = $zip->filename;
        $zip->close();
        // dd($path);
        session()->flash('downloadsuccess', 'true');
        
        return response()->download($path)->deleteFileAfterSend(true);

        // return response()->download($path, $file);
    }
    function downloadFile ($url, $file) {
        $url = File::find(Url::where('url', $url)->latest()->first()->file_id)->first()->url;
        $path = Storage::disk('app')->path('/files/' . $url . '/' . $file);
        return response()->download($path, $file);
    }
}
