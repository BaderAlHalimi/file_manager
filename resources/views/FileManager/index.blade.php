@extends('layout.master')

@section('content')
    <link rel="stylesheet" href="{{ Storage::disk('public')->url('css/index.css') }}">
    <div class="container my-5">
        <div class="row justify-content-center align-items-top g-2">
            <div class="col">
                <h2 class="mt-5">نظام مشاركة الملفات</h2>
                <p>يتيح نظام تخزين الملفات ومشاركتها التخزين الآمن والمشاركة السهلة للملفات الشخصية عبر الإنترنت ،
                    تعزيز التنظيم والتعاون والإنتاجية. يمكن للمستخدمين تحميل ملفات مختلفة وإنشاء روابط
                    للمشاركة وضبط إعدادات الخصوصية للتحكم في الوصول. تضمن الواجهة سهلة الاستخدام السلاسة
                    إدارة الملفات وحماية البيانات من خلال التشفير.<br>
                    <span>طوِّر بواسطة: <a href="https://mostaql.com/u/BaderHalimi">Bader Al-Din
                            Al-Halimi</a></span>
                </p>
                @if (!session('user_id'))
                    <a id="joinButton" href="{{ route('signup') }}">إنضم الآن!</a>
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
