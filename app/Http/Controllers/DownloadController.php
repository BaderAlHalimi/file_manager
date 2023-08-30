<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\File;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    //
    function downloadFolder(Request $request, $url)
    {
        $file_ = File::where('id', Url::where('url', $url)->latest()->first()->file_id)->first();
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

        $file_->downloadsRelation()->create(['ip' => $request->ip()]);
        $file_->update(['downloads' => $file_->downloads + 1]);

        return response()->download($path)->deleteFileAfterSend(true);

        // return response()->download($path, $file);
    }
    function downloadFile(Request $request, $url, $file)
    {
        $id = Url::where('url', $url)->latest()->first()->file_id;
        $file1 = File::where('id', $id)->first();
        $url = $file1->url;
        $path = Storage::disk('app')->path('/files/' . $url . '/' . $file);
        $file1->downloadsRelation()->create(['ip' => $request->ip()]);
        $file1->update(['downloads' => $file1->downloads + 1]);
        return response()->download($path, $file);
    }
}
