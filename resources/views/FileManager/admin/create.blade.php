@extends('layout.master')
@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
@endpush
@push('styles')
    <style>
        /*just bg and body style*/
        body {
            background-color: #212529;
        }

        .form-floating input {
            background-color: #212529;
            color: white
        }

        .form-floating input:focus {
            background-color: #212529;
            color: white
        }

        .center {
            text-align: center;
        }

        #top {
            margin-top: 20px;
        }

        .btn-container {
            border: 1px solid #fff;
            border-radius: 5px;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .white {
            color: white;
        }

        .imgupload {
            color: white;
            padding-top: 40px;
            font-size: 7em;
        }

        #namefile {
            color: white;
        }

        h4>strong {
            color: #ff3f3f
        }

        .btn-primary {
            border-color: #ff3f3f !important;
            color: #ffffff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            background-color: #ff3f3f !important;
            border-color: #ff3f3f !important;
        }

        /*these two are set to not display at start*/
        .imgupload.ok {
            display: none;
            color: green;
        }

        .imgupload.stop {
            display: none;
            color: red;
        }


        /*this sets the actual file input to overlay our button*/
        #fileup {
            opacity: 0;
            -moz-opacity: 0;
            filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
            width: 200px;
            cursor: pointer;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 40px;
            height: 50px;
        }

        /*switch between input and not active input*/
        #submitbtn {
            padding: 5px 50px;
            display: none;
        }

        #fakebtn {
            padding: 5px 40px;
        }


        /*www.emilianocostanzo.com*/
        #sign {
            color: #1E2832;
            position: fixed;
            right: 10px;
            bottom: 10px;
            text-shadow: 0px 0px 0px #1E2832;
            transition: all.3s;
        }

        #sign:hover {
            color: #1E2832;
            text-shadow: 0px 0px 5px #1E2832;
        }
    </style>
@endpush
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

    <div class="container center">
        <div class="row">
            <div class="col-md-12">
                <h1 class="white">Custom File Upload</h1>
                <p class="white">In this example, submit is allowed only in case the user uploads a valid image file.</p>
            </div>
        </div>

        <div class="row">
            @error('file')
                <ul class="alert-danger">
                    <li class="text-danger">{{ $message }}</li>
                </ul>
            @enderror
            <div class="center">
                <div class="btn-container ms-auto md-auto">
                    <!--the three icons: default, ok file (img), error file (not an img)-->
                    <h1 class="imgupload"><i class="fa fa-file-image-o"></i></h1>
                    <h1 class="imgupload ok"><i class="fa fa-check"></i></h1>
                    <h1 class="imgupload stop"><i class="fa fa-times"></i></h1>
                    <!--this field changes dinamically displaying the filename we are trying to upload-->
                    <p id="namefile">Click to this button to add your file! <sup>it's required</sup></p>
                    <!--our custom btn which which stays under the actual one-->
                    <button id="filebtn" onclick="fileButtonClicked()" class="btn btn-primary btn-lg">Browse for your
                        pic!</button>
                    <!--this is the actual file input, is set with opacity=0 beacause we wanna see our custom one-->
                    <input type="file" class="m-0 p-0" multiple name="file[]" id="file" hidden required>
                </div>
            </div>
        </div>
        <!--additional fields-->
        <div class="row">
            <form method="post" action="{{ route('dashboard.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <!--the defauld disabled btn and the actual one shown only if the three fields are valid-->
                    <div id="files" class="form-floating mb-3">
                    </div>
                    <div class="form-floating mb-3">
                        <div class="card" hidden>
                            <div class="card-body text-dark">
                                <div id="item1" class="alert alert-dark m-0" style="text-align: left;" role="alert">
                                    <strong>Alert Heading</strong> Alert Content
                                </div>
                            </div>
                        </div>
                        <div class="card bg-dark btn-container m-0 p-0">
                            <div id="items" class="card-body text-dark m-0">
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name') }}" name="name"
                            id="name" placeholder="Name" required>
                        <label for="name" class="class="col-4 col-form-label>Name</label>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="submit" value="Submit!" class="btn btn-primary" id="submitbtn">
                    <button type="submit" class="btn btn-outline-danger" id="">Submit!</button>
                </div>
            </form>
        </div>
    </div>

    <a href="http://www.emilianocostanzo.com" target="_blank" id="sign">EMI</a>
@endsection
@push('scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
@endpush
@push('scripts')
    <script>
        // FileSelected = [];
        i = 0;
        var element;

        function fileButtonClicked() {
            document.getElementById("file").click();
        }
        document.getElementById("file").addEventListener("change", function(event) {
            // document.getElementById("filebtn").classList.add('disabled');
            var newFiles = event.target.files;
            element = document.getElementById("files").appendChild(document.getElementById("file").cloneNode(
                true));
            files = element.files;
            for (let i = 0; i < files.length; i++) {
                const name = files[i].name;
                var item = document.getElementById("item1");
                item.innerHTML = name;
                var element1 = document.getElementById("items").appendChild(item.cloneNode(true));
            }
            // `
        // <input type="file" value=${newFiles} name="file[]" id="${i}" />
        // `
            // document.getElementById("namefile").innerHTML = "<span class='text-danger'>file selected!</span>";
        });
    </script>
@endpush
