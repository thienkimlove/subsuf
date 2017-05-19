@extends('v2.template')

@section('content')
    <div class="wrap_language">
        <div class="content text-center">
            <div class="logo">
                <a href="#">
                    <img src="/v2/images/logo.png" alt="">
                </a>
            </div>
            <h1>SELECT YOUR LANGUAGE</h1>

            <div class="item_language">
                <a class="image" href="" >
                    <img src="/v2/images/image_language_anh.png" alt="">
                </a>
                <a class="icon_name" href="#" id="eng_lang">
                    <img src="/v2/images/icon-lg-anh.png" alt="">
                    <span>English</span>
                </a>
            </div>
            <div class="item_language">
                <a class="image" href="" >
                    <img src="/v2/images/image_language_vietnam.png" alt="">
                </a>
                <a class="icon_name" href="#" id="vi_lang">
                    <img src="/v2/images/icon-lg-vn.png" alt="">
                    <span>Tiếng việt</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('frontend_script')

    <script>

        $(document).ready(function () {
            $('#eng_lang').click(function (e) {
                e.preventDefault();
                $.ajax({
                    'url': '{{ action('Frontend\IndexController@select_language') }}',
                    'type': 'post',
                    'data': {
                        "_token": "{{ csrf_token() }}",
                        'select_language': 'en'
                    },
                    success: function()
                    {
                        window.location.href = '{{ url('/') }}'
                    }
                })
            });

            $('#vi_lang').click(function (e) {
                e.preventDefault();
                $.ajax({
                    'url': '{{ action('Frontend\IndexController@select_language') }}',
                    'type': 'post',
                    'data': {
                        "_token": "{{ csrf_token() }}",
                        'select_language': 'vi'
                    },
                    success: function()
                    {
                        window.location.href = '{{ url('/') }}'
                    }
                })
            });
        });

    </script>

@endsection