<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//admin
Route::group(['middleware' => 'admin.login'], function () {
    Route::group(['prefix' => 'admin'], function () {
        //LOGOUT
        Route::get('logout', 'Admin\AccessController@logout');

        //HOME
        Route::get('home', 'Admin\AdminDasboardController@index');

        //MENU STATISTICS
        Route::group(['middleware' => 'module:statistics', 'prefix' => 'statistics'], function () {
            Route::get('/users', 'Admin\StatisticsController@order_by_user')->middleware('function:users')->middleware('right:is_read');
            Route::get('/locations', 'Admin\StatisticsController@order_by_location')->middleware('function:locations')->middleware('right:is_read');
            Route::get('/traveler-revenue', 'Admin\StatisticsController@revenue_of_traveler')->middleware('function:traveler-revenue')->middleware('right:is_read');
            Route::get('/revenue', 'Admin\StatisticsController@revenue')->middleware('function:revenue')->middleware('right:is_read');
//            Route::get('/users', 'Admin\StatisticsController@by_user');
        });

        //MENU ADMIN
        Route::group(['middleware' => 'module:admin-manage', 'prefix' => 'admin-manage'], function () {
            //MENU-ITEM ROLE
            Route::group(['middleware' => 'function:role', 'prefix' => 'role'], function () {
                Route::get('/', 'Admin\RoleController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\RoleController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\RoleController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\RoleController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\RoleController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\RoleController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\RoleController@info')->middleware('right:is_read');
            });

            //MENU-ITEM ACCOUNT
            Route::group(['middleware' => 'function:account', 'prefix' => 'account'], function () {
                Route::get('/', 'Admin\AdminController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\AdminController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\AdminController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\AdminController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\AdminController@update')->middleware('right:is_updated');
                Route::get('ban/{id}', 'Admin\AdminController@ban')->middleware('right:is_updated');
                Route::get('active/{id}', 'Admin\AdminController@active')->middleware('right:is_updated');
                Route::get('info/{id}', 'Admin\AdminController@info')->middleware('right:is_read');
                Route::get('change-password', 'Admin\AdminController@change_password');
                Route::post('change-password', 'Admin\AdminController@change_password');
            });
        });

        //MENU FRONT ACCOUNT
        Route::group(['middleware' => 'module:front-manage', 'prefix' => 'front-manage'], function () {
            //MENU-ITEM ACCOUNT
            Route::group(['middleware' => 'function:account', 'prefix' => 'account'], function () {
                Route::get('/', 'Admin\AccountController@index')->middleware('right:is_read');
                Route::get('info/{id}', 'Admin\AccountController@info')->middleware('right:is_read');
                Route::get('ban/{id}', 'Admin\AccountController@ban')->middleware('right:is_updated');
                Route::get('active/{id}', 'Admin\AccountController@active')->middleware('right:is_updated');
                Route::get('payment_info/{id}', 'Admin\AccountController@payment_info')->middleware('right:is_read');
            });
        });

        //MENU ORDER
        Route::group(['middleware' => 'module:order-manage', 'prefix' => 'order-manage'], function () {
            Route::get('/', 'Admin\OrderController@index')->middleware('function:order-manage')->middleware('right:is_read');
            Route::get('info/{id}', 'Admin\OrderController@info')->middleware('function:order-manage')->middleware('right:is_read');
        });

        //MENU OFFER
        Route::group(['prefix' => 'offer-manage'], function () {
            Route::get('info/{id}', 'Admin\OfferController@info');
        });

        //MENU TRANSACTION
        Route::group(['middleware' => 'module:transaction-manage', 'prefix' => 'transaction-manage'], function () {
            Route::get('/', 'Admin\TransactionController@index')->middleware('function:transaction-manage')->middleware('right:is_read');
            Route::get('info/{id}', 'Admin\TransactionController@info')->middleware('function:transaction-manage')->middleware('right:is_read');
            // Fake dữ liệu
            Route::get('/fake', 'Admin\TransactionController@fakeTransaction')->middleware('right:is_inserted');
            Route::post('/fake', 'Admin\TransactionController@doFakeTransaction')->middleware('right:is_inserted');
            Route::get('/delete/{id}', 'Admin\TransactionController@removeTransaction')->middleware('right:is_deleted');
        });

        //MENU COUPON
        Route::group(['middleware' => 'module:coupon-manage', 'prefix' => 'coupon-manage'], function () {
            Route::get('/', 'Admin\CouponController@index')->middleware('function:coupon-manage')->middleware('right:is_read');
            Route::get('insert/', 'Admin\CouponController@insert')->middleware('function:coupon-manage')->middleware('right:is_inserted');
            Route::post('insert/', 'Admin\CouponController@insert')->middleware('function:coupon-manage')->middleware('right:is_inserted');
            Route::get('update/{id}', 'Admin\CouponController@update')->middleware('function:coupon-manage')->middleware('right:is_updated');
            Route::post('update/{id}', 'Admin\CouponController@update')->middleware('function:coupon-manage')->middleware('right:is_updated');
            Route::get('delete/{id}', 'Admin\CouponController@delete')->middleware('function:coupon-manage')->middleware('right:is_deleted');
        });

        //MENU BLOG
        Route::group(['middleware' => 'module:blog-manage', 'prefix' => 'blog-manage'], function () {
            //MENU-ITEM BLOG
            Route::group(['middleware' => 'function:blog', 'prefix' => 'blog'], function () {
                Route::get('/', 'Admin\BlogController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\BlogController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\BlogController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\BlogController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\BlogController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\BlogController@delete')->middleware('right:is_deleted');
            });

            //MENU-ITEM BLOG CATEGORY
            Route::group(['middleware' => 'function:category', 'prefix' => 'category'], function () {
                Route::get('/', 'Admin\BlogCategoryController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\BlogCategoryController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\BlogCategoryController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\BlogCategoryController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\BlogCategoryController@update')->middleware('right:is_updated');
                Route::get('show/{id}', 'Admin\BlogCategoryController@show')->middleware('right:is_updated');
                Route::get('hide/{id}', 'Admin\BlogCategoryController@hide')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\BlogCategoryController@delete')->middleware('right:is_deleted');
            });
        });

        //MENU SYSTEM CATEGORY
        Route::group(['middleware' => 'module:system-category', 'prefix' => 'system-category'], function () {
            //MENU-ITEM COUNTRY
            Route::group(['middleware' => 'function:country', 'prefix' => 'country'], function () {
                Route::get('/', 'Admin\CountryController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\CountryController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\CountryController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\CountryController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\CountryController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\CountryController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\CountryController@info')->middleware('right:is_read');
            });

            //MENU-ITEM LOCATION
            Route::group(['middleware' => 'function:location', 'prefix' => 'location'], function () {
                Route::get('/', 'Admin\LocationController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\LocationController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\LocationController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\LocationController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\LocationController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\LocationController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\LocationController@info')->middleware('right:is_read');
            });

            //MENU-ITEM LANGUAGE
            Route::group(['middleware' => 'function:language', 'prefix' => 'language'], function () {
                Route::get('/', 'Admin\LanguageController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\LanguageController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\LanguageController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\LanguageController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\LanguageController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\LanguageController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\LanguageController@info')->middleware('right:is_read');
            });

            //MENU-ITEM BANK
            Route::group(['middleware' => 'function:bank', 'prefix' => 'bank'], function () {
                Route::get('/', 'Admin\BankController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\BankController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\BankController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\BankController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\BankController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\BankController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\BankController@info')->middleware('right:is_read');
            });

            //MENU-ITEM ITEM
            Route::group(['middleware' => 'function:item', 'prefix' => 'item'], function () {
                Route::get('/', 'Admin\ItemController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\ItemController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\ItemController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\ItemController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\ItemController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\ItemController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\ItemController@info')->middleware('right:is_read');
            });

            //MENU-ITEM PRODUCT CATEGORY
            Route::group(['middleware' => 'function:category', 'prefix' => 'category'], function () {
                Route::get('/', 'Admin\CategoryController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\CategoryController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\CategoryController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\CategoryController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\CategoryController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\CategoryController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\CategoryController@info')->middleware('right:is_read');
            });

            //MENU-ITEM BRAND
            Route::group(['middleware' => 'function:brand', 'prefix' => 'brand'], function () {
                Route::get('/', 'Admin\BrandController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\BrandController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\BrandController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\BrandController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\BrandController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\BrandController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\BrandController@info')->middleware('right:is_read');
            });

            //MENU-ITEM WEBSITE
            Route::group(['middleware' => 'function:website', 'prefix' => 'website'], function () {
                Route::get('/', 'Admin\WebsiteController@index')->middleware('right:is_read');
                Route::get('insert/', 'Admin\WebsiteController@insert')->middleware('right:is_inserted');
                Route::post('insert/', 'Admin\WebsiteController@insert')->middleware('right:is_inserted');
                Route::get('update/{id}', 'Admin\WebsiteController@update')->middleware('right:is_updated');
                Route::post('update/{id}', 'Admin\WebsiteController@update')->middleware('right:is_updated');
                Route::get('delete/{id}', 'Admin\WebsiteController@delete')->middleware('right:is_deleted');
                Route::get('info/{id}', 'Admin\WebsiteController@info')->middleware('right:is_read');
            });
        });

        //MENU CONFIG
        Route::group(['middleware' => 'module:config-manage', 'prefix' => 'config-manage'], function () {
            //MENU ABOUT ME
            Route::group(['middleware' => 'function:about-me', 'prefix' => 'about-me'], function () {
                Route::get('/', 'Admin\StaticContentController@abouts')->middleware('right:is_read');
                Route::get('/insert', 'Admin\StaticContentController@about_insert')->middleware('right:is_inserted');
                Route::post('/insert', 'Admin\StaticContentController@about_insert')->middleware('right:is_inserted');
                Route::get('/update/{language_code}', 'Admin\StaticContentController@about_update')->middleware('right:is_updated');
                Route::post('/update/{language_code}', 'Admin\StaticContentController@about_update')->middleware('right:is_updated');
                Route::get('/check-about-me', 'Admin\StaticContentController@check_about')->middleware('right:is_read');
            });

            //MENU POLICY
            Route::group(['middleware' => 'function:policy', 'prefix' => 'policy'], function () {
                Route::get('/', 'Admin\StaticContentController@policy')->middleware('right:is_read');
                Route::get('/insert', 'Admin\StaticContentController@policy_insert')->middleware('right:is_inserted');
                Route::post('/insert', 'Admin\StaticContentController@policy_insert')->middleware('right:is_inserted');
                Route::get('/update/{language_code}', 'Admin\StaticContentController@policy_update')->middleware('right:is_updated');
                Route::post('/update/{language_code}', 'Admin\StaticContentController@policy_update')->middleware('right:is_updated');
                Route::get('/check-policy', 'Admin\StaticContentController@check_policy')->middleware('right:is_read');
            });

            //MENU TERM
            Route::group(['middleware' => 'function:terms', 'prefix' => 'terms'], function () {
                Route::get('/', 'Admin\StaticContentController@terms')->middleware('right:is_read');
                Route::get('/insert', 'Admin\StaticContentController@terms_insert')->middleware('right:is_inserted');
                Route::post('/insert', 'Admin\StaticContentController@terms_insert')->middleware('right:is_inserted');
                Route::get('/update/{language_code}', 'Admin\StaticContentController@terms_update')->middleware('right:is_updated');
                Route::post('/update/{language_code}', 'Admin\StaticContentController@terms_update')->middleware('right:is_updated');
                Route::get('/check-policy', 'Admin\StaticContentController@check_terms')->middleware('right:is_read');
            });

            //MENU FAQ
            Route::group(['middleware' => 'function:faq', 'prefix' => 'faq'], function () {
                Route::get('/', 'Admin\FaqController@index')->middleware('right:is_read');
                Route::get('insert', 'Admin\FaqController@insert')->middleware('right:is_inserted');
                Route::post('insert', 'Admin\FaqController@insert')->middleware('right:is_inserted');
                Route::get('update/{faq_id}', 'Admin\FaqController@update')->middleware('right:is_updated');
                Route::post('update/{faq_id}', 'Admin\FaqController@update')->middleware('right:is_updated');
                Route::get('delete/{faq_id}', 'Admin\FaqController@delete')->middleware('right:is_deleted');
            });

            //MENU EXCHANGE
            Route::group(['middleware' => 'function:exchange', 'prefix' => 'exchange'], function () {
                Route::get('/', 'Admin\ExchangeController@index')->middleware('right:is_read');
                Route::get('insert', 'Admin\ExchangeController@insert')->middleware('right:is_inserted');
                Route::post('insert', 'Admin\ExchangeController@insert')->middleware('right:is_inserted');
                Route::get('update/{exchange_id}', 'Admin\ExchangeController@update')->middleware('right:is_updated');
                Route::post('update/{exchange_id}', 'Admin\ExchangeController@update')->middleware('right:is_updated');
                Route::get('delete/{exchange_id}', 'Admin\ExchangeController@delete')->middleware('right:is_deleted');
            });



        });
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('', 'Admin\AccessController@redirect');
    Route::get('login', 'Admin\AccessController@login');
    Route::post('login', 'Admin\AccessController@login');
    Route::get('denied', 'Admin\AccessController@denied');
});

//frontend
Route::get('/select-language', 'Frontend\IndexController@select_language');
Route::post('/select-language', 'Frontend\IndexController@select_language');

Route::group(['prefix' => 'shopper'], function () {
    Route::get('order/payment-order-success/{account_id}/{offer_id}/{coupon_id}', 'Frontend\ShopperController@saveAcceptOffer');
    Route::post('order/payment-order-success/{account_id}/{offer_id}/{coupon_id}', 'Frontend\ShopperController@saveAcceptOffer');
});

Route::group(['middleware' => ['language']], function () {
    Route::get('/', 'Frontend\IndexController@index');
    Route::get('/change-language', 'Frontend\IndexController@change_language');
    Route::get('/login', 'Frontend\LoginController@login');
    Route::post('/login', 'Frontend\LoginController@doLogin');
    Route::get('/forgot_password', 'Frontend\LoginController@forgotPassword');
    Route::post('/forgot_password', 'Frontend\LoginController@sendEmailForgotPassword');
    Route::get('/change-new-password', 'Frontend\LoginController@changeNewPassword');
    Route::post('/change-new-password', 'Frontend\LoginController@doChangeNewPassword');
    Route::get('/register', 'Frontend\LoginController@register');
    Route::post('/register', 'Frontend\LoginController@doRegister');
//    Route::get('/login/facebook', 'Frontend\LoginController@facebook');
//    Route::get('/login/facebook/callback', 'Frontend\LoginController@facebookCallback');
//    Route::post('/login/facebook/callback', 'Frontend\LoginController@facebookCallback');

    //Login Facebook
    Route::get('/login/facebook', 'Frontend\LoginController@login_facebook');
    Route::get('/login/facebook/callback', 'Frontend\LoginController@login_facebook_callback');
    Route::post('/login/facebook/callback', 'Frontend\LoginController@login_facebook_callback');

    //Login Google
    Route::get('/login/google', 'Frontend\LoginController@google');
    Route::post('/login/google/callback', 'Frontend\LoginController@googleCallback');
    Route::get('/login/google/callback', 'Frontend\LoginController@googleCallback');
    Route::get('/logout', 'Frontend\LoginController@logout');
    Route::get('/shopper', 'Frontend\ShopperController@index');
    Route::get('/order-detail/{id}', 'Frontend\ShopperController@orderDetail'); // chi  tiết order
    Route::get('/traveler', 'Frontend\TravelerController@index');
    Route::get('/traveler/find', 'Frontend\TravelerController@find');

    Route::get('/collections/buy-where', 'Frontend\CollectionsController@buy_where');
    Route::get('/collections/buy-where/{category_id}', 'Frontend\CollectionsController@detail_buy_where');
    Route::get('/collections/where-buy', 'Frontend\CollectionsController@where_buy');
    Route::get('/collections/where-buy/{location_id}', 'Frontend\CollectionsController@detail_where_buy');
    Route::get('/collections/famous-brands', 'Frontend\CollectionsController@famous_brand');
    Route::get('/collections/famous-brands/{brand_id}', 'Frontend\CollectionsController@detail_famous_brand');
    Route::get('/collections/featured-items', 'Frontend\CollectionsController@featured_items');
    Route::get('/collections/sale-items', 'Frontend\CollectionsController@sale_items');
    Route::get('/alert', 'Frontend\IndexController@error');

    Route::get('/shopper/order', 'Frontend\ShopperController@order');
    Route::get('/404', 'Frontend\ItemController@test');

    Route::group(['prefix' => 'item'], function () {
        Route::get('/{item_id}', 'Frontend\ItemController@item');
    });
    Route::post('shopper/order/step-2', 'Frontend\ShopperController@order2');
    Route::get('offer/{offer_id}', 'Frontend\TravelerController@offer');

    Route::group(['middleware' => 'frontend.login'], function () {

        Route::group(['prefix' => 'traveler'], function () {
            Route::post('offer/{offer_id}', 'Frontend\TravelerController@makeOffer');
            Route::get('offer/cancel/{offer_id}', 'Frontend\TravelerController@cancelOffer');

        });
        Route::group(['prefix' => 'shopper'], function () {
            Route::get('order/step-2', 'Frontend\ShopperController@order2');
            Route::get('order/step-3', 'Frontend\ShopperController@order3');
            Route::post('order/save', 'Frontend\ShopperController@saveOrder');
            Route::get('order/active/{order_id}', 'Frontend\ShopperController@activeOrder');
            Route::get('order/deactivate/{order_id}', 'Frontend\ShopperController@deactiveOrder');
            Route::get('order/accept-offer/{offer_id}', 'Frontend\ShopperController@acceptOffer');
            Route::post('order/accept-offer/{offer_id}', 'Frontend\PaymentController@payment_order');
//            Route::get('order/payment-order-success/{offer_id}/{coupon_id}', 'Frontend\ShopperController@saveAcceptOffer');
//            Route::post('order/payment-order-success/{offer_id}/{coupon_id}', 'Frontend\ShopperController@saveAcceptOffer');
            Route::get('order/finish/{order_id}', 'Frontend\ShopperController@finishOrder');
            Route::get('order/transaction/remove/{order_id}', 'Frontend\ShopperController@deleteTransaction');
            Route::get('order/edit/{order_id}', 'Frontend\ShopperController@editOrder');
            Route::post('order/edit/{order_id}', 'Frontend\ShopperController@doEditOrder');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('/ordered', 'Frontend\UserController@ordered');
            Route::get('/offered', 'Frontend\UserController@offered');
            Route::get('/profile', 'Frontend\UserController@profile');


            Route::post('/update-all-info', 'Frontend\UserController@update');
            Route::post('/update-info', 'Frontend\UserController@updateInfo');
            Route::get('/payment-info', 'Frontend\UserController@paymentInfo');
            Route::post('/payment-info', 'Frontend\UserController@updatePaymentInfo');
            Route::get('/check-verify-email', 'Frontend\UserController@checkVerifyEmail');
            Route::get('/send-verify-email', 'Frontend\UserController@sendVerifyEmail');

            Route::get('/user-payment-info', 'Frontend\UserController@user_payment_info');
            Route::get('/user-payment-info/add-card', 'Frontend\UserController@add_card');
            Route::post('/user-payment-info/add-card', 'Frontend\UserController@add_card');
            Route::get('/user-payment-info/edit-card/{id}', 'Frontend\UserController@edit_card');
            Route::post('/user-payment-info/edit-card/{id}', 'Frontend\UserController@edit_card');
            Route::get('/user-payment-info/delete-card/{id}', 'Frontend\UserController@delete_card');
            Route::get('/invite-friend', 'Frontend\UserController@inviteFriend');

            Route::get('/user-payment-info/add-paypal', 'Frontend\UserController@add_paypal');
            Route::post('/user-payment-info/add-paypal', 'Frontend\UserController@add_paypal');
            Route::get('/user-payment-info/edit-paypal/{id}', 'Frontend\UserController@edit_paypal');
            Route::post('/user-payment-info/edit-paypal/{id}', 'Frontend\UserController@edit_paypal');
            Route::get('/user-payment-info/delete-paypal/{id}', 'Frontend\UserController@delete_paypal');
            Route::get('/rate/{transaction_id}', 'Frontend\UserController@userRate');
            Route::post('/rate/{transaction_id}', 'Frontend\UserController@userRateUpdate');
            Route::post('/update-image', 'Frontend\UserController@updateImage');


        });

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/{user_id}', 'Frontend\NotificationController@user_notification');
        });

        Route::get('/add-coupon', 'Frontend\ShopperController@addCouponCode');
    });
    Route::get('/user-rate/{id}', 'Frontend\UserController@userRateDetail');

    Route::get('/test-payment-success', 'Frontend\PaymentController@success');
    Route::get('/test-payment', 'Frontend\PaymentController@payment');
    Route::post('/test-payment', 'Frontend\PaymentController@payment');

    Route::group(['prefix' => 'api'], function () {
        Route::get('url-hint', 'Admin\ApiController@url_hint');
    });

    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'Frontend\BlogController@index');
        Route::get('/categories/{category_slug}', 'Frontend\BlogController@category');
        Route::get('/{blog_slug}', 'Frontend\BlogController@blog_details');
    });

    Route::group(['middleware' => 'select.language'], function () {
        Route::get('/about', 'Admin\StaticContentController@get_about');
        Route::get('/policy', 'Admin\StaticContentController@get_policy');
        Route::get('/term', 'Admin\StaticContentController@get_term');
        Route::get('/faq', 'Admin\FaqController@get_faq');
    });
});
Route::get('/accept-verify-email', 'Frontend\UserController@acceptVerifyEmail');
Route::get('/test-send-email', 'Admin\ApiController@test_send_email');

Route::get('bonecms_captcha', ['as' => 'laravel-captcha', 'uses' => 'Frontend\CaptchaController@index']);
Route::get('bonecms_captcha/html', 'LaravelCaptcha\Controllers\CaptchaController@html');


Route::get('/testchucnang', 'Frontend\TestController@index');
Route::get('/promotion_coupon', 'Frontend\IndexController@promotion_coupon');
