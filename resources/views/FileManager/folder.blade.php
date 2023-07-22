@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <?php
            $fls = Storage::disk('app')->files('/files/' . $url);
            ?>
            @foreach ($fls as $value)
                <div class="col-4">
                    <div class="card text-start bg-dark">
                        <img class="card-img-top" src="holder.js/100px180/" alt="Title">
                        <div class="card-body">
                            <h5 class="card-title">{{ basename($value) }}</h5>
                            <p>folder: {{ $url }}</p>
                            <a class="btn btn-outline-info" href="{{ Storage::disk('app')->url($value) }}"
                                download>download</a>
                            <button onclick="copy({{ route('share', ['url' => $url]) }})">share!, copy Link</button>
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

            console.log('تم نسخ النص بنجاح: ' + text);
        }
    </script>
@endsection
