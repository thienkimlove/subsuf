@extends('v2.template')

@section('content')
    <div class="wrap_language">
        <div class="content text-center">
            <div class="logo">
                <a href="#">
                    <img src="images/logo.png" alt="">
                </a>
            </div>
            <h1>SELECT YOUR LANGUAGE</h1>
            <div class="item_language">
                <a class="image" href="">
                    <img src="images/image_language_anh.png" alt="">
                </a>
                <a class="icon_name" href="#">
                    <img src="images/icon-lg-anh.png" alt="">
                    <span>ENGLISH</span>
                </a>
            </div>
            <div class="item_language">
                <a class="image" href="">
                    <img src="images/image_language_vietnam.png" alt="">
                </a>
                <a class="icon_name" href="#">
                    <img src="images/icon-lg-vn.png" alt="">
                    <span>VIETNAMESE</span>
                </a>
            </div>
        </div>
    </div>
@endsection