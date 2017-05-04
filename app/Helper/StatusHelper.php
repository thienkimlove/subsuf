<?php

namespace App\Helper;

class StatusHelper
{
    public static function account_admin()
    {
        return [
            -1 => [
                'name' => 'Tạm dừng',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Kích hoạt',
                'class' => 'font-green'
            ],
        ];
    }

    public static function account_front()
    {
        return [
            -1 => [
                'name' => 'Tạm dừng',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Đang hoạt động',
                'class' => 'font-green'
            ],
        ];
    }

    public static function account_front_verified()
    {
        return [
            0 => [
                'name' => 'Chưa xác thực',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Đã xác thực',
                'class' => 'font-green'
            ],
        ];
    }

    public static function type_location()
    {
        return [
            1 => 'Thành phố',
            0 => 'Quốc gia',
        ];
    }

    public static function order()
    {
        return [
            -1 => [
                'name' => 'Đã dừng',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Kích hoạt',
                'class' => 'font-green'
            ],
            2 => [
                'name' => 'Đang giao dịch',
                'class' => 'font-yellow-gold'
            ],
            3 => [
                'name' => 'Hoàn thành',
                'class' => 'font-green-jungle'
            ]
        ];
    }

    public static function offer()
    {
        return [
            -1 => [
                'name' => 'Đã hủy',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Kích hoạt',
                'class' => 'font-green'
            ],
            2 => [
                'name' => 'Đang giao dịch',
                'class' => 'font-yellow-gold'
            ],
            3 => [
                'name' => 'Hoàn thành',
                'class' => 'font-green-jungle'
            ]
        ];
    }

    public static function transaction()
    {
        return [
            -1 => [
                'name' => 'Đã hủy',
                'class' => 'font-red'
            ],
            2 => [
                'name' => 'Đang giao dịch',
                'class' => 'font-yellow-gold'
            ],
            3 => [
                'name' => 'Thành công',
                'class' => 'font-green-jungle'
            ]
        ];
    }

    public static function coupon()
    {
        return [
            -1 => [
                'name' => 'Đã dùng',
                'class' => 'font-red'
            ],
            1 => [
                'name' => 'Chưa dùng',
                'class' => 'font-green'
            ],

        ];
    }

    public static function category()
    {
        return [
            1 => 'Website',
            2 => 'Sản phẩm'
        ];
    }

    public static function blog()
    {
        return [
            0 => [
                'name' => 'Riêng tư',
                'class' => 'font-yellow-gold'
            ],
            1 => [
                'name' => 'Công khai',
                'class' => 'font-green'
            ],
        ];
    }

    public static function faq()
    {
        return [
            1 => 'Người mua hàng',
            2 => 'Người mua hộ',
            3 => 'Vấn đề khác',
        ];
    }

    public static function blog_category()
    {
        return [
            0 => [
                'name' => 'Ẩn',
                'class' => 'red'
            ],
            1 => [
                'name' => 'Hiển thị',
                'class' => 'green'
            ],
        ];
    }
}