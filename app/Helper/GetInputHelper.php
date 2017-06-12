<?php

use App\Helper\EncryptHelper;
use Intervention\Image\Facades\Image;

function get_role_form($request)
{
    $data = [
        'name' => ucwords(trim($request->input('name', '')))
    ];

    return $data;
}

function get_admin_form($request, $account_admin = null)
{
    $data = [
        'role_id' => (int)$request->input('role_id'),
        'username' => trim($request->input('username', '')),
        'password' => EncryptHelper::password(trim($request->input('password', ''))),
        'tag' => trim($request->input('tag', '')),
        'name' => trim($request->input('name', '')),
        'status' => (int)trim($request->input('status', -1)),
        'avatar' => ''
    ];

    //store avatar
    $account_admin_path = get_admin_avatar_folder() . md5($data['username']) . '/';
    if (!is_dir($account_admin_path)) {
        mkdir($account_admin_path);
    }

    if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
        try {
            $avatar_img = Image::make($request->file('avatar'));
            $width = $avatar_img->width();
            $avatar_file_name = 'avatar_' . date('ymdHis') . '.jpg';
            $avatar_img->fit($width);
            $avatar_img->save($account_admin_path . $avatar_file_name);

            $data['avatar'] = '/' . $account_admin_path . $avatar_file_name;
        } catch (Exception $e) {
        }
    }

    if ($account_admin != null) {
        if (trim($request->input('password', '')) == 'subsuf123456') {
            unset($data['password']);
        }

        if ($data['avatar'] == '') {
            unset($data['avatar']);
        }

        if (isset($data['avatar']) && $data['avatar'] == $account_admin->avatar) {
            unset($data['avatar']);
        }
    }

    return $data;
}

function get_country_form($request)
{
    $data = [
        'country_code' => trim($request->input('country_code')),
        'name' => trim($request->input('name'))
    ];

    return $data;
}

function get_location_form($request)
{
    $data = [
        'name_vi' => ucwords(trim($request->input('name_vi', ''))),
        'name_en' => ucwords(trim($request->input('name_en', ''))),
        'type' => (int)trim($request->input('type', 1)),
        'location_order' => (int)trim($request->input('location_order', 1)),
        'is_showed' => (int)trim($request->input('is_showed', 0)),
    ];

    //store location image
    $image_path = get_location_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {
        }
    }

    return $data;
}

function get_language_form($request)
{
    $data = [
        'language_code' => trim($request->input('language_code')),
        'name' => trim($request->input('name'))
    ];

    return $data;
}

function get_bank_form($request)
{
    $data = [
        'country_id' => (int)trim($request->input('country_id')),
        'name' => trim($request->input('name')),
        'swift_code' => trim($request->input('swift_code'))
    ];

    return $data;
}

function get_static_form($request)
{
    $data = [
        'title' => trim($request->input('title')),
        'content' => trim($request->input('content')),
    ];

    return $data;
}

function get_faq_form($request)
{
    $order = (int)trim($request->input('faq_order'));
    if ($order <= 0) {
        $order = 1;
    }

    $data = [
        'language' => trim($request->input('language')),
        'ask' => trim($request->input('ask')),
        'answer' => trim($request->input('answer')),
        'faq_order' => $order,
        'faq_type' => (int)trim($request->input('faq_type', 1)),
    ];

    return $data;
}

function get_change_password_form($request)
{
    $data = [
        'old_password' => trim($request->input('old_password')),
        'password' => trim($request->input('password')),
        'password_confirmation' => trim($request->input('password_confirmation')),
    ];

    return $data;
}

function get_category_form($request)
{
    $data = [
        'name_vi' => mb_ucfirst(trim($request->input('name_vi', ''))),
        'name_en' => mb_ucfirst(trim($request->input('name_en', ''))),
        'category_type' => (int)trim($request->input('category_type', 1)),
        'category_order' => (int)trim($request->input('category_order', 1)),
        'is_showed' => (int)trim($request->input('is_showed', 0)),
    ];

    //store category image
    $image_path = get_category_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {
        }
    }

    return $data;
}

function get_website_form($request)
{
    $data = [
        'name_vi' => mb_ucfirst(trim($request->input('name_vi', ''))),
        'name_en' => mb_ucfirst(trim($request->input('name_en', ''))),
        'link' => trim($request->input('link')),
        'location_id' => (int)trim($request->input('location_id')),
        'category_id' => (int)trim($request->input('category_id')),
        'description_vi' => trim($request->input('description_vi')),
        'description_en' => trim($request->input('description_en')),
        'website_order' => (int)trim($request->input('website_order', 1)),
        'is_showed' => (int)trim($request->input('is_showed', 0)),
    ];

    //store website image
    $image_path = get_website_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {
        }
    }

    return $data;
}

function get_item_form($request)
{
    $data = [
        'name_vi' => mb_ucfirst(trim($request->input('name_vi', ''))),
        'name_en' => mb_ucfirst(trim($request->input('name_en', ''))),
        'label' => mb_ucfirst(trim($request->input('label', ''))),
        'price' => (round(trim($request->input('price', 0)), 2)),
        'link' => trim($request->input('link')),
        'category_id' => (int)trim($request->input('category_id')),
        'brand_id' => (int)trim($request->input('brand_id')),
        'featured' => (int)trim($request->input('featured', 0)),
        'description_vi' => trim($request->input('description_vi')),
        'description_en' => trim($request->input('description_en')),
        'item_order' => (int)trim($request->input('item_order', 1)),
        'is_showed' => (int)trim($request->input('is_showed', 0)),
        'is_sale' => (int)trim($request->input('is_sale', 0)),
        'price_sale' => (round(trim($request->input('price_sale', 0)), 2)),
    ];

    //store item image
    $image_path = get_item_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $data['image'] = store_image($request, $image_path);
        } catch (Exception $e) {
            dump($e->getMessage());
            dd($e->getTraceAsString());
        }
    }

    return $data;
}

function get_brand_form($request)
{
    $data = [
        'name' => mb_ucfirst(trim($request->input('name', ''))),
        'label' => mb_ucfirst(trim($request->input('label', ''))),
        'description' => trim($request->input('description')),
        'link' => trim($request->input('link')),
    ];

    //store item image
    $image_path = get_brand_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        try {
            $data['logo'] = store_image($request, $image_path, 'logo');
        } catch (Exception $e) {
        }
    }

    if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
        try {
            $data['cover'] = store_image($request, $image_path, 'cover');
        } catch (Exception $e) {
        }
    }

    return $data;
}

function get_coupon_form($request)
{
    $data = [
        'coupon_code' => trim($request->input('coupon_code', '')),
        'account_id' => (int)(trim($request->input('account_id', ''))),
        'money' => (float)trim($request->input('money')),
        'total' => (int)trim($request->input('total')),
        'status' => (int)trim($request->input('status')),
        'type' => (int)trim($request->input('type')),
    ];
    if ($request->has('amount')) {
        $data['amount'] = (int)trim($request->input('amount'));
    } else {
        $data['amount'] = (int)trim($request->input('total'));
    }

    if ($data['status'] == -1) {
        $data['used_at'] = date('Y-m-d H:i:s');
    } else {
        $data['used_at'] = '';
    }

    // more type for coupon
    if ($data['type'] == 1) {
        $data['primary_percent'] = ($request->input('primary_percent'))? (int)trim($request->input('primary_percent')) : 0;
        $data['secondary_percent'] = 0;
    }

    if ($data['type'] == 2) {
        $data['primary_percent'] = ($request->input('primary_percent'))? (int)trim($request->input('primary_percent')) : 0;
        $data['secondary_percent'] = ($request->input('secondary_percent'))? (int)trim($request->input('secondary_percent')) : 0;
    }

    return $data;
}

function get_blog_category_form($request)
{
    $data = [
        'language' => trim($request->input('language', '')),
        'name' => mb_ucfirst(trim($request->input('name', ''))),
        'status' => (int)(trim($request->input('status', 0))),
    ];

    $slug = trim($request->input('slug', ''));
    if ($slug == '') {
        $slug = str_slug($data['name']);
    }

    $data['slug'] = $slug;

    return $data;
}

function get_blog_form($request)
{
    $data = [
        'category_id' => (int)trim($request->input('category_id', '')),
        'author_id' => (int)trim($request->input('author_id', 0)),
        'language' => trim($request->input('language', '')),
        'title' => mb_ucfirst(trim($request->input('title', ''))),
        'content' => trim($request->input('content', '')),
        'short_description' => trim($request->input('short_description', '')),
        'is_published' => (int)trim($request->input('is_published', 0)),
    ];

    $slug = trim($request->input('slug', ''));
    if ($slug == '') {
        $slug = str_slug($data['title']);
    }

    $data['slug'] = $slug;

    //store category image
    $image_path = get_blog_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {
        }
    }

    return $data;
}

function get_notification($order, $offer, $content_vi, $content_en, $type)
{
    switch ($type) {
        default:
        case "make_new_offer":
        case "cancel_offer":
        case "payment_success":
            $from_user_id = $offer->traveler_id;
            $to_user_id = $order->shopper_id;
            break;

        case "accept_offer":
        case "edit_order":
        case "shopper_received":
            $from_user_id = $order->shopper_id;
            $to_user_id = $offer->traveler_id;
            break;
    }

    $data = [
        'order_id' => $order->order_id,
        'from_user_id' => $from_user_id,
        'to_user_id' => $to_user_id,
        'content_vi' => $content_vi,
        'content_en' => $content_en,
        'sent_at' => date('Y-m-d H:i:s')
    ];

    return $data;
}

function get_exchange_form($request)
{
    $data = [
        'from_currency' => trim($request->input('from_currency')),
        'to_currency' => trim($request->input('to_currency')),
        'money' => (float)trim($request->input('money'))
    ];

    return $data;
}

function get_deal_form($request)
{
    $data = [
        'title_vi' => trim($request->input('title_vi', '')),
        'title_en' => trim($request->input('title_en', '')),
        'desc_en' => trim($request->input('desc_en', '')),
        'desc_vi' => trim($request->input('desc_vi', '')),
    ];

    //store category image
    $image_path = get_deal_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {

        }

    }

    return $data;
}

function get_banner_form($request)
{
    //store banner image
    $image_path = get_deal_image_folder();
    if (!is_dir($image_path)) {
        mkdir($image_path);
    }

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $path_info = pathinfo($request->file('image')->getClientOriginalName());
            $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

            $avatar_img = Image::make($request->file('image'));
            $avatar_img->save($image_path . $file_name);

            $data['image'] = '/' . $image_path . $file_name;
        } catch (Exception $e) {

        }

    }

    return $data;
}