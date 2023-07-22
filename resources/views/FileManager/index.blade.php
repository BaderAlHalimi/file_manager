@extends('layout.master')
@section('content')
    <link rel="stylesheet" href="{{ Storage::disk('app')->url('css/index.css') }}">
    <div class="container">
        <div class="row justify-content-center align-items-top g-2">
            <div class="col">
                <h2 class="mt-5">File Manager System</h2>
                <p>on this system you can store your files, and shre it for any person you need! <br>
                    <span>Developed by: <a href="https://mostaql.com/u/BaderHalimi">Bader Al-Din
                            Al-Halimi</a></span>
                </p>
                <a id="joinButton" href="{{ route('signup') }}">Join now!</a>

            </div>
            <div class="col">
                <img width="100%" src="{{ Storage::disk('app')->url('file share.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection
