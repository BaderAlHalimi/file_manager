@extends('layout.master')
@section('content')
    <?php
    use App\Models\User;
    ?>
    <div style="min-height: 100vh" class="container">
        <div class="row justify-content-center align-items-center g-2">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <strong> {{ session('success') }}</strong>
                </div>
            @endif
            <div>
                <a href="{{ route('dashboard.create') }}" class="btn btn-danger px-5 py-2"><i
                        class="fa-solid fa-file-circle-plus"></i>
                    add file</a>
            </div>
            @isset($files)
                @foreach ($files as $file)
                    <div class="col-4">
                        <div class="card bg-dark btn-container border-light d-flex">
                            <div class="card-body">
                                <h5 class="card-title p-0 m-0" style="height: 50px; overflow: hidden;">{{ $file->name }}</h5>
                                <p class="p-0 m-0">files: {{ count(Storage::disk('app')->files("/files/$file->url")) }}</p>
                                <p>user: {{ User::where('id', session('user_id'))->first()->name }}</p>
                                <button class="btn btn-outline-info"
                                    onclick="download('{{ URL::temporarySignedRoute('download.folder', now()->addHours(1), ['url' => $file->fakeurl]) }}')"><i
                                        class="fa-solid fa-download"></i> download</button>
                                <button class="btn btn-outline-danger"
                                    onclick="copy('{{ URL::temporarySignedRoute('share', now()->addHours(24), ['url' => $file->fakeurl]) }}')"><i
                                        class="fa-solid fa-share-from-square"></i> share</button>
                                <button class="btn btn-danger"
                                    onclick="download('{{ URL::temporarySignedRoute('File.delete', now()->addMinutes(1), ['url' => $file->fakeurl]) }}')"><i
                                        class="fa-solid fa-trash-can"></i> delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <script>
        function copy(text) {
            // إنشاء عنصر textarea لوضع النص فيه للنسخ
            const textarea = document.createElement('textarea');
            textarea.value = text;

            // إضافة العنصر إلى الصفحة
            document.body.appendChild(textarea);

            // تحديد النص في العنصر
            textarea.select();

            // نسخ النص إلى الحافظة
            document.execCommand('copy');

            // إزالة العنصر من الصفحة (اختياري)
            document.body.removeChild(textarea);

            // alert('تم نسخ النص بنجاح: ' + text);
            sharemessage();
        }

        function download(url) {
            window.location.href = url;
            downloadmessage();
        }

        function sharemessage() {
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
                title: 'Link copied'
            })
        }

        function downloadmessage() {
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
                title: 'download started'
            })
        }
    </script>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ Storage::disk('public')->url('css/all.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ Storage::disk('public')->url('js/all.min.js') }}"></script>
@endpush
