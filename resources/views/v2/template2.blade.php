<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{ isset($title) ? $title : 'Subsuf' }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta property="og:url" content="http://sufsub.com/register"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Get any items from overseas by travelers on the way to Vietnam."/>
    <meta property="og:description"
          content="Dịch vụ mua hàng nước ngoài tiết kiệm,mua và chuyển tới trực tiếp bởi những người sắp đến Việt Nam."/>
    <meta property="og:image" content="http://subsuf.com/images/sufsub.jpg"/>
    <meta charset="utf-8"/>

    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,500italic,700,700italic,300italic&subset=vietnamese' rel='stylesheet' type='text/css'>

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{url('v2/css/bootstrap.min.css')}}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.css">


    <!-- Optional theme -->
    <link rel="stylesheet" href="{{url('v2/css/bootstrap-theme.min.css')}}" />

    <link href='{{url('v2/css/font-awesome.min.css')}}' rel='stylesheet' type='text/css'>
    <link href='{{url('v2/css/font-awesome-animation.min.css')}}' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('v2/css/themify-icons.css')}}">

    <link rel="stylesheet" href="{{url('v2/css/dropdowns-hover.css')}}">
    <link rel="stylesheet" href="{{url('v2/css/dropdowns-menu.css')}}">

    <link rel="stylesheet" href="{{url('v2/css/animate.css')}}">
    <link rel="stylesheet" href="{{url('v2/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('v2/css/owl.theme.default.css')}}">

    <link rel="stylesheet" href="/v2/css/Multi-Step-Indicator.css">


    <link rel="stylesheet" href="{{url('v2/css/stylesheet.css')}}">

</head>

<body>

@yield('content')

<script>
    var url = '{{ url('/') }}';
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{url('v2/js/jquery.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Latest compiled and minified JavaScript -->
<script src="{{url('v2/js/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.js"></script>
<script src="{{url('v2/js/dropdownhover.min.js')}}"></script>
{{--<script src="{{url('v2/js/dropdowns-menu.js')}}"></script>--}}
<script src="{{url('v2/js/owl.carousel.min.js')}}"></script>
{{Html::script('assets/apps/scripts/cookie.js')}}
<script src="{{url('v2/js/custom.js')}}"></script>



@yield('frontend_script')

</body>

</html>