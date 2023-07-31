@extends('layout.master')

@section('content')
    <link rel="stylesheet" href="{{ Storage::disk('public')->url('css/index.css') }}">
    <div class="container">
        <div class="row justify-content-center align-items-top g-2">
            <div class="col">
                <h2 class="mt-5">File Manager System</h2>
                <p>A file storage and sharing system enables secure storage and easy sharing of personal files online,
                    promoting organization, collaboration, and productivity. Users can upload various files, create links
                    for sharing, and adjust privacy settings for access control. The user-friendly interface ensures smooth
                    file management and data protection through encryption.<br>
                    <span>Developed by: <a href="https://mostaql.com/u/BaderHalimi">Bader Al-Din
                            Al-Halimi</a></span>
                </p>
                @if (!session('user_id'))
                    <a id="joinButton" href="{{ route('signup') }}">Join now!</a>
                @else
                    <a class="btn btn-outline-danger" href="{{ route('dashboard.index') }}"><i
                            class="fa-solid fa-sliders"></i> Dashboard</a>
                @endif

            </div>
            <div class="col">
                <img width="100%" src="{{ Storage::disk('public')->url('file share.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ Storage::disk('public')->url('css/all.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ Storage::disk('public')->url('js/all.min.js') }}"></script>
@endpush
@push('scripts')
    <script>
        function loginmessage() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-start',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'login successfully'
            })
        }
        @if ($login_success)
            loginmessage();
        @endif
    </script>
@endpush
