@extends('layout.master')
@section('content')
    <div style="min-height: 100vh" class="container">
        <div class="row justify-content-center align-items-center g-2">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <strong> {{ session('success') }}</strong>
                </div>
            @endif
            <a href="{{ route('dashboard.create') }}" class="btn btn-danger">add file!</a>
            @isset($files)
                @foreach ($files as $file)
                    <?php
                    $fls = Storage::disk('app')->files('/files/' . $file->url);
                    ?>
                    @foreach ($fls as $value)
                        <div class="col-4">
                            <div class="card text-start bg-dark">
                                <img class="card-img-top" src="holder.js/100px180/" alt="Title">
                                <div class="card-body">
                                    <h5 class="card-title">{{ basename($value) }}</h5>
                                    <p>folder: {{ $file->url }}</p>
                                    <a class="btn btn-outline-info" href="{{URL::temporarySignedRoute('download',now()->addHours(1), ['url' => $file->fakeurl,'file'=>basename($value)]) }}"
                                        >download</a>
                                    <button class="btn btn-danger" onclick="copy('{{ URL::temporarySignedRoute('share',now()->addHours(24), ['url' => $file->fakeurl]) }}')">share!,
                                        copy Link</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

            alert('تم نسخ النص بنجاح: ' + text);
        }
    </script>
@endsection
