<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
    data-slide-speed="200" style="padding-top: 20px">

@if(havePermission('statistics', ''))
    <!-- THỐNG KÊ -->
        <li class="heading">
            <h3 class="uppercase bold">Thống kê</h3>
        </li>

        @if(havePermission('statistics', 'users'))
            <li class="nav-item {{Request::is('admin/statistics/users*')? 'active open' : ''}}">
                <a href="{{URL::action('Admin\StatisticsController@order_by_user')}}" class="nav-link nav-toggle">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">Order theo User</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endif

        @if(havePermission('statistics', 'locations'))
            <li class="nav-item {{Request::is('admin/statistics/locations*')? 'active open' : ''}}">
                <a href="{{URL::action('Admin\StatisticsController@order_by_location')}}" class="nav-link nav-toggle">
                    <i class="fa fa-map-marker"></i>
                    <span class="title">Order theo Địa điểm</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endif

        @if(havePermission('statistics', 'traveler-revenue'))
            <li class="nav-item {{Request::is('admin/statistics/traveler-revenue*')? 'active open' : ''}}">
                <a href="{{URL::action('Admin\StatisticsController@revenue_of_traveler')}}" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title">Doanh thu Traveler</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endif

        @if(havePermission('statistics', 'revenue'))
            <li class="nav-item {{Request::is('admin/statistics/revenue*')? 'active open' : ''}}">
                <a href="{{URL::action('Admin\StatisticsController@revenue')}}" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title">Doanh thu</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endif
    @endif

    <li class="heading">
        <h3 class="uppercase bold">Quản lý</h3>
    </li>

    @if(havePermission('admin-manage', ''))
    <!-- ADMIN -->
        <li class="nav-item {{Request::is('admin/admin-manage*')? 'active open' : ''}}">
            <a role="button" class="nav-link nav-toggle">
                <i class="fa fa-users"></i>
                <span class="title">Admin</span>
                <span class="selected"></span>
                <span class="arrow {{ Request::is('admin/admin-manage*') ? 'open' : '' }}"></span>
            </a>

            <ul class="sub-menu">
                @if(havePermission('admin-manage', 'account'))
                    <li class="nav-item {{Request::is('admin/admin-manage/account*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\AdminController@index')}}" class="nav-link ">
                            <i class="fa fa-user"></i>
                            <span class="title">Tài khoản</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('admin-manage', 'role'))
                    <li class="nav-item {{Request::is('admin/admin-manage/role*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\RoleController@index')}}" class="nav-link ">
                            <i class="fa fa-check"></i>
                            <span class="title">Phân quyền</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(havePermission('front-manage', ''))
    <!-- ACCOUNT -->
        <li class="nav-item {{Request::is('admin/front-manage*')? 'active open' : ''}}">
            <a href="#" class="nav-link nav-toggle">
                <i class="fa fa-users"></i>
                <span class="title">Người dùng</span>
                <span class="selected"></span>
                <span class="arrow {{ Request::is('admin/front-manage*') ? 'open' : '' }}"></span>
            </a>

            <ul class="sub-menu">
                @if(havePermission('front-manage', 'account'))
                    <li class="nav-item {{Request::is('admin/front-manage/account*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\AccountController@index')}}" class="nav-link ">
                            <i class="fa fa-user"></i>
                            <span class="title">Tài khoản</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(havePermission('order-manage', ''))
    <!-- ORDER -->
        @if(havePermission('order-manage', 'order-manage'))
            <li class="nav-item {{Request::is('admin/order-manage*') ? 'active' : ''}}">
                <a href="{{URL::action('Admin\OrderController@index')}}" class="nav-link nav-toggle">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">Order</span>
                    <span class="selected"></span>
                    <span class="arrow {{ Request::is('admin/order-manage*') ? 'open' : '' }}"></span>
                </a>
            </li>
        @endif
    @endif

    @if(havePermission('transaction-manage', ''))
    <!-- TRADE -->
        @if(havePermission('transaction-manage', 'transaction-manage'))
            <li class="nav-item {{Request::is('admin/transaction-manage*') ? 'active' : ''}}">
                <a href="{{URL::action('Admin\TransactionController@index')}}" class="nav-link nav-toggle">
                    <i class="fa fa-trademark"></i>
                    <span class="title">Giao dịch</span>
                    <span class="selected"></span>
                    <span class="arrow {{ Request::is('admin/transaction-manage*') ? 'open' : '' }}"></span>
                </a>
            </li>
        @endif
    @endif

    @if(havePermission('coupon-manage', ''))
    <!-- COUPONS -->
        @if(havePermission('coupon-manage', 'coupon-manage'))
            <li class="nav-item  {{Request::is('admin/coupon-manage*') ? 'active' : ''}}">
                <a href="{{URL::action('Admin\CouponController@index')}}" class="nav-link nav-toggle">
                    <i class="fa fa-gift"></i>
                    <span class="title">Coupon</span>
                    <span class="selected"></span>
                    <span class="arrow {{ Request::is('admin/coupon-manage*') ? 'open' : '' }}"></span>
                </a>
            </li>
        @endif
    @endif

<!-- COLLECTION -->
    {{--<li class="nav-item">--}}
    {{--<a href="#" class="nav-link nav-toggle">--}}
    {{--<i class="fa fa-instagram"></i>--}}
    {{--<span class="title">Bộ sưu tập</span>--}}
    {{--<span class="selected"></span>--}}
    {{--<span class="arrow"></span>--}}
    {{--</a>--}}

    {{--<ul class="sub-menu">--}}
    {{--<li class="nav-item start ">--}}
    {{--<a href="#" class="nav-link ">--}}
    {{--<i class="fa fa-navicon"></i>--}}
    {{--<span class="title">Bộ sưu tập</span>--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--<li class="nav-item start ">--}}
    {{--<a href="#" class="nav-link ">--}}
    {{--<i class="fa fa-pied-piper"></i>--}}
    {{--<span class="title">Sản phẩm</span>--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--<li class="nav-item start ">--}}
    {{--<a href="#" class="nav-link ">--}}
    {{--<i class="fa fa-tag"></i>--}}
    {{--<span class="title">Thẻ tag</span>--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</li>--}}

    @if(havePermission('blog-manage', ''))
    <!-- BLOG -->
        <li class="nav-item {{Request::is('admin/blog-manage*')? 'active open' : ''}}">
            <a href="#" class="nav-link nav-toggle">
                <i class="fa fa-rss"></i>
                <span class="title">Blog</span>
                <span class="selected"></span>
                <span class="arrow {{ Request::is('admin/blog-manage*') ? 'open' : '' }}"></span>
            </a>

            <ul class="sub-menu">
                @if(havePermission('blog-manage', 'blog'))
                    <li class="nav-item start {{Request::is('admin/blog-manage/blog*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\BlogController@index')}}" class="nav-link ">
                            <i class="fa fa-rss"></i>
                            <span class="title">Bài viết</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('blog-manage', 'category'))
                    <li class="nav-item start {{Request::is('admin/blog-manage/category*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\BlogCategoryController@index')}}" class="nav-link ">
                            <i class="fa fa-tag"></i>
                            <span class="title">Thể loại</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(havePermission('system-category', ''))
    <!-- CATEGORY -->
        <li class="nav-item {{Request::is('admin/system-category*')? 'active open' : ''}}">
            <a role="button" class="nav-link nav-toggle">
                <i class="fa fa-list"></i>
                <span class="title">Danh mục</span>
                <span class="selected"></span>
                <span class="arrow {{ Request::is('admin/system-category*') ? 'open' : '' }}"></span>
            </a>

            <ul class="sub-menu">
                @if(havePermission('system-category', 'location'))
                    <li class="nav-item start {{Request::is('admin/system-category/location*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\LocationController@index')}}" class="nav-link ">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">Địa điểm</span>
                        </a>
                    </li>
                @endif
                {{--<li class="nav-item start {{Request::is('admin/system-category/country*') ? 'active' : ''}}">--}}
                {{--<a href="{{URL::action('Admin\CountryController@index')}}" class="nav-link ">--}}
                {{--<i class="fa fa-globe"></i>--}}
                {{--<span class="title">Quốc gia</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item start {{Request::is('admin/system-category/bank*') ? 'active' : ''}}">--}}
                {{--<a href="{{URL::action('Admin\BankController@index')}}" class="nav-link ">--}}
                {{--<i class="fa fa-university"></i>--}}
                {{--<span class="title">Ngân hàng</span>--}}
                {{--</a>--}}
                {{--</li>--}}

                @if(havePermission('system-category', 'language'))
                    <li class="nav-item start {{Request::is('admin/system-category/language*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\LanguageController@index')}}" class="nav-link ">
                            <i class="fa fa-language"></i>
                            <span class="title">Ngôn ngữ</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('system-category', 'category'))
                    <li class="nav-item start {{Request::is('admin/system-category/category*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\CategoryController@index')}}" class="nav-link ">
                            <i class="fa fa-barcode"></i>
                            <span class="title">Nhóm hàng hóa</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('system-category', 'item'))
                    <li class="nav-item start {{Request::is('admin/system-category/item*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\ItemController@index')}}" class="nav-link ">
                            <i class="fa fa-pied-piper"></i>
                            <span class="title">Sản phẩm</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('system-category', 'brand'))
                    <li class="nav-item start {{Request::is('admin/system-category/brand*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\BrandController@index')}}" class="nav-link ">
                            <i class="fa fa-amazon"></i>
                            <span class="title">Thương hiệu</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('system-category', 'website'))
                    <li class="nav-item start {{Request::is('admin/system-category/website*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\WebsiteController@index')}}" class="nav-link ">
                            <i class="fa fa-chrome"></i>
                            <span class="title">Website</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(havePermission('config-manage', ''))
    <!-- CONFIG -->
        <li class="nav-item {{Request::is('admin/config-manage*')? 'active open' : ''}}">
            <a href="#" class="nav-link nav-toggle">
                <i class="fa fa-gears"></i>
                <span class="title">Cấu hình</span>
                <span class="arrow {{Request::is('admin/config-manage*')? 'open' : ''}}"></span>
            </a>
            <ul class="sub-menu">
                @if(havePermission('config-manage', 'about-me'))
                    <li class="nav-item {{Request::is('admin/config-manage/about-me*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\StaticContentController@abouts')}}" class="nav-link ">
                            <i class="fa fa-info"></i>
                            <span class="title">About Me</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('config-manage', 'policy'))
                    <li class="nav-item {{Request::is('admin/config-manage/policy*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\StaticContentController@policy')}}" class="nav-link ">
                            <i class="fa fa-legal"></i>
                            <span class="title">Chính sách</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('config-manage', 'terms'))
                    <li class="nav-item {{Request::is('admin/config-manage/terms*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\StaticContentController@terms')}}" class="nav-link ">
                            <i class="fa fa-file-text-o"></i>
                            <span class="title">Điều khoản</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('config-manage', 'faq'))
                    <li class="nav-item {{Request::is('admin/config-manage/faq*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\FaqController@index')}}" class="nav-link ">
                            <i class="fa fa-question"></i>
                            <span class="title">FAQ</span>
                        </a>
                    </li>
                @endif

                @if(havePermission('config-manage', 'exchange'))
                    <li class="nav-item {{Request::is('admin/config-manage/exchange*') ? 'active' : ''}}">
                        <a href="{{URL::action('Admin\ExchangeController@index')}}" class="nav-link ">
                            <i class="fa fa-exchange"></i>
                            <span class="title">Tỷ giá</span>
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif
</ul>
