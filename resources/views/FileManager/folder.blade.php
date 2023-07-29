@extends('layout.master')
@section('content')
    <div class="container h-100">
        <div class="row justify-content-center align-items-center g-2">
            <?php
            $fls = Storage::disk('app')->files('/files/' . $url);
            ?>
            <div class="order-first offset-md-4">
                <a class="btn btn-outline-danger" href="{{ URL::temporarySignedRoute('download.folder',now()->addHours(1),['url'=>$fakeurl]) }}">Download all!</a>
                <h3>{{ $name }}</h3>
            </div>
            @foreach ($fls as $value)
                <div class="col-4">
                    <div class="card text-start bg-dark">
                        <img class="card-img-top" src="holder.js/100px180/" alt="Title">
                        <div class="card-body">
                            <h5 class="card-title">{{ basename($value) }}</h5>
                            <p>folder: {{ $url }}</p>
                            <a class="btn btn-outline-info"
                                href="{{ URL::temporarySignedRoute('download', now()->addHours(1), ['url' => $fakeurl, 'file' => basename($value)]) }}">download</a>
                            <button class="btn btn-danger"
                                onclick="copy('{{ URL::temporarySignedRoute('share', now()->addHours(24), ['url' => $fakeurl]) }}')">share!,
                                copy Link</button>
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

            alert('تم نسخ النص بنجاح: ' + text);
        }
    </script>
@endsection
