<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;
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
    public function destroy(string $id)
    {
        //
    }
    public function share($url)
    {
        return view('FileManager.folder',['url'=>$url]);
    }
}
