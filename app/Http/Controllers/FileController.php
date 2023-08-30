<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\Url;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (!session('user_id')) {
            return redirect()->route('User.login');
        }
        $files = array();
        foreach (File::where('user_id', session('user_id'))->get() as $file) {
            $file['fakeurl'] = Url::where('file_id', $file->id)->latest()->first()->url;
            $files[] = $file;
        }
        return view('FileManager.admin.index', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (!session('user_id')) {
            return redirect()->route('User.login');
        }
        return view('FileManager.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request)
    {
        // dd($request->all());
        // exit;
        //
        $validated = $request->validated();
        $files = $request->file('file');
        $path = Str::random(20);
        foreach ($files as $file) {
            $file->storeAs('/files/' . $path, $file->getClientOriginalName(), File::disk);
        }
        $validated['url'] = $path;
        $validated['user_id'] = session('user_id');
        File::create($validated);
        Url::create(['file_id' => File::where('url', $path)->latest()->first()->id, 'url' => Str::random(20)]);
        return redirect()->route('dashboard.index')->with('success', 'Upload successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($url)
    {
        //
        $file = File::where('id', Url::where('url', $url)->latest()->first()->file_id)->first();
        $filePath = '/files/' . $file->url;
        Storage::disk('app')->deleteDirectory($filePath);
        $file->delete();
        return redirect()->back()->with(['delete' => 'deleted successfully']);
    }
    public function share($url)
    {
        $file = File::where('id', Url::where('url', '=', $url)->latest()->first()->file_id)->first();
        $user = User::where('id',$file->user_id)->first();
        return view('FileManager.folder', ['url' => $file->url, 'fakeurl' => $url, 'name' => $file->name,'user'=>$user->name]);
    }
}
