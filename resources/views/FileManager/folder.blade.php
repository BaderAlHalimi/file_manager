@extends('layout.master')
@section('content')
    <div class="container h-100">
        <div class="row justify-content-center align-items-center g-2">
            <?php
            $fls = Storage::disk('app')->files('/files/' . $url);
            ?>
            <div class="container my-5">
                <div class="order-first offset-md-4">
                    <a class="btn btn-outline-danger"
                        href="{{ URL::temporarySignedRoute('download.folder', now()->addHours(1), ['url' => $fakeurl]) }}"><i
                            class="fa-solid fa-download"></i> Download all</a>
                    <h3>{{ $name }}</h3>
                </div>
            </div>
            @foreach ($fls as $value)
                <div class="col-4">
                    <div class="card bg-dark btn-container border-light d-flex">
                        <div class="card-body">
                            <h5 class="card-title" style="height: 50px; overflow: hidden;">{{ basename($value) }}</h5>
                            <p>الناشر: {{ $user }}</p>
                            <a class="btn btn-outline-info"
                                href="{{ URL::temporarySignedRoute('download', now()->addHours(1), ['url' => $fakeurl, 'file' => basename($value)]) }}"><i
                                    class="fa-solid fa-download"></i> تحميل</a>
                            <button class="btn btn-danger"
                                onclick="copy('{{ URL::temporarySignedRoute('share', now()->addHours(24), ['url' => $fakeurl]) }}')"><i
                                    class="fa-solid fa-share-from-square"></i> مشاركة</button>
                        </div>
                    </div>
                </div>
            @endforeach
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
                title: 'Link copied',
                customClass: {
                    popup: 'swal2-toast swal2-dark',
                }
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
