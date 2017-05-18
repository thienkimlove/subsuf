
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

var url = '{{ url('/') }}';

function couponSubmit() {
    var email = $('#coupon_email').val();
    $('#coupon_submit').hide();
    $('#coupon_message').show().text('Loading..');
    $.get(url +'/promotion_coupon',{ email : email },function(response){
        $('#coupon_message').text(response.msg);
    });
}

$(function(){

    $('.owl-sliderBanner').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        margin:30,
        stagePadding: 0,
        smartSpeed:450
    });


    $('.owl-slider_image_chitietdonhang').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        margin:0,
        stagePadding: 0,
        smartSpeed:450,
        nav:true,
        navText: ["<i class='fa fa-angle-double-left' aria-hidden='true'></i>","<i class='fa fa-angle-double-right' aria-hidden='true'></i>"]
    });

    $('.owl_slider_product').owlCarousel({
        margin:30,
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
        margin:30,
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


    var isShowing = Cookies.get('show_popup_secure_4nd', { domain : document.domain });

    if (!isShowing || isShowing === '0') {
        $('#coupon_popup').modal();
        Cookies.set('show_popup_secure_4nd', '1', { expires: 7, domain: document.domain });

    }


    $('#coupon_submit').click(function(){
        couponSubmit();
        return false;
    });

});
