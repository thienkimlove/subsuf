
(function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // You are in mobile browser
    } else {
        var pname = ( (document.title != '') ? document.title : document.querySelector('h1').innerHTML );
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=ceff237de05fbccd93e18adb9e598967&data=eyJzc29faWQiOjQ0MjA4NTIsImhhc2giOiI3MmY0ZDg5M2JmZjgwNTZjMzJmY2EwYWU4NGU1ZmJiMyJ9&pname=' + pname;
        var s = document.getElementsByTagName('script');
        s[0].parentNode.insertBefore(ga, s[0]);
    }
})();



function couponSubmit() {
    var email = $('#coupon_email').val();

    if (email == '')
    {
        alert('Bạn không được bỏ trống email');
        return false;
    }

    $('#coupon_submit').hide();
    $('#coupon_message').show().text('Loading..');
    $.get(url +'/promotion_coupon',{ email : email },function(response){
        $('#coupon_message').text(response.msg);
    });
}


function couponSubmitFooter() {
    var email = $('.input_nhanngay').val();

    if (email == '')
    {
        alert('Bạn không được bỏ trống email');
        return false;
    }
    $('.nhanngay').text('Loading..');
    $.get(url +'/promotion_coupon',{ email : email },function(response){
        $('#footer_mess').html('<h4>'+response.msg+'</h4>');
        $('.nhanngay').text('Nhận Ngay!');
    });
}

$(function(){

    $('.owl-sliderBanner').owlCarousel({
        autoplay:true,
        autoplayTimeout:4000,
        autoHeight:true,
        loop:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        margin:30,
        stagePadding: 0,
        smartSpeed:450
    });


    $('.owl-slider_image_chitietdonhang').owlCarousel({
        autoplay:true,
        autoplayTimeout:4000,
        autoHeight:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        loop:true,
        margin:0,
        stagePadding: 0,
        smartSpeed:450,
        nav:true,
        navText: ["<i class='fa fa-angle-double-left' aria-hidden='true'></i>","<i class='fa fa-angle-double-right' aria-hidden='true'></i>"]
    });

    $('.owl_slider_product').owlCarousel({
        autoplay:true,
        autoplayTimeout:4000,
        autoHeight:true,
        margin:30,
        loop:true,
        dots:false,
        nav:true,
        navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1,
                margin:15
            },
            576:{
                items:2,
                margin:15
            },
            768:{
                items:3,
                margin:20
            },
            992:{
                items:3
            }
        }
    })

    $('.owl_exhibition_2u').owlCarousel({
        autoplay:true,
        autoplayTimeout:4000,
        autoHeight:true,
        margin:30,
        loop:true,
        dots:false,
        nav:true,
        navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1,
                margin:15
            },
            576:{
                items:2,
                margin:15
            },
            768:{
                items:3,
                margin:20
            },
            992:{
                items:3
            }
        }
    })


    $('.nhanngay').click(function(){
        couponSubmitFooter();
        return false;
    });

    $('#coupon_submit').click(function(){
        couponSubmit();
        return false;
    });

    $('.datmuahang').click(function () {
        $('#md_dathang').modal('show');
    })


});
