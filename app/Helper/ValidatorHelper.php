<?php

function is_error($validator)
{
    if ($validator->fails()) {
        return true;
    }

    return false;
}

function return_error($validator, &$response)
{
    if ($validator->fails()) {
        $response['status'] = "error";
        $response['message'] = $validator->errors()->first();
    }
}

function role_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name' => "required",
    ], [
        'name.required' => "Chưa nhập tên Quyền",
    ]);

    return $validator;
}

function account_admin_validator($request)
{
    $validator = Validator::make($request->all(), [
        'role_id' => 'required',
        'username' => 'required|alpha_dash',
        'password' => 'required|min:6|max:32|confirmed',
        'password_confirmation' => 'required||min:6|max:32',
        'name' => 'required',
        'tag' => 'required',
    ], [
        'role_id.required' => "Chưa phân quyền",
        'required' => 'Vui lòng nhập đầy đủ dữ liệu',
        'username.alpha_dash' => 'Tên đăng nhập không được chứa ký tự đặc biệt',
        'min' => 'Mật khẩu từ 6 đến 32 ký tự',
        'max' => 'Mật khẩu từ 6 đến 32 ký tự',
        'password.confirmed' => 'Mật khẩu nhập lại không đúng'
    ]);

    return $validator;
}

function country_validator($request)
{
    $validator = Validator::make($request->all(), [
        'country_code' => 'required|min:2|max:5',
        'name' => 'required'
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu',
        'country_code.max' => 'Mã quốc gia từ 2 đến 5 ký tự',
        'country_code.min' => 'Mã quốc gia từ 2 đến 5 ký tự'
    ]);

    return $validator;
}

function location_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name_vi' => "required",
        'name_en' => "required",
        'type' => "required"
    ], [
        'name_vi.required' => "Chưa nhập tên Địa điểm Tiếng Việt",
        'name_en.required' => "Chưa nhập tên Địa điểm Tiếng Anh",
        'type.required' => "Chưa phân loại Địa điểm",
    ]);

    return $validator;
}

function language_validator($request)
{
    $validator = Validator::make($request->all(), [
        'language_code' => 'required|min:2|max:5',
        'name' => 'required'
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu',
        'language_code.max' => 'Mã ngôn ngữ từ 2 đến 5 ký tự',
        'language_code.min' => 'Mã ngôn ngữ từ 2 đến 5 ký tự'
    ]);

    return $validator;
}

function bank_validator($request)
{
    $validator = Validator::make($request->all(), [
        'country_id' => 'required',
        'name' => 'required',
        'swift_code' => 'required'
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu'
    ]);

    return $validator;
}

function static_validator($request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required'
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu'
    ]);

    return $validator;
}

function faq_validator($request)
{
    $validator = Validator::make($request->all(), [
        'language' => 'required',
        'ask' => 'required',
        'answer' => 'required'
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu'
    ]);

    return $validator;
}

function change_password_validator($request)
{
    $validator = Validator::make($request->all(), [
        'old_password' => 'required',
        'password' => 'required|min:6|max:32|confirmed',
        'password_confirmation' => 'required||min:6|max:32',
    ], [
        'required' => 'Vui lòng nhập đầy đủ dữ liệu',
        'min' => 'Mật khẩu từ 6 đến 32 ký tự',
        'max' => 'Mật khẩu từ 6 đến 32 ký tự',
        'password.confirmed' => 'Mật khẩu nhập lại không đúng'
    ]);

    return $validator;
}

function category_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name_vi' => "required",
        'name_en' => "required",
        'category_type' => 'required'
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function website_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name_vi' => "required",
        'name_en' => "required",
        'link' => 'required',
        'location_id' => 'required',
        'category_id' => 'required',
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function item_validator($request)
{
    $validator = Validator::make($request->all(), [
        'category_id' => 'required',
        'name_vi' => "required",
        'name_en' => "required",
        'price' => "required",
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function brand_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name' => "required",
    ], [
        'required' => "Vui lòng nhập tên thương hiệu",
    ]);

    return $validator;
}

function coupon_validator($request)
{
    $validator = Validator::make($request->all(), [
        'coupon_code' => "required",
        'account_id' => "required",
        'money' => "required",
        'status' => "required",
        'total' => "required",
        'primary_percent' => "max:99",
        'secondary_percent' => "max:99",
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function blog_category_validator($request)
{
    $validator = Validator::make($request->all(), [
        'name' => "required",
        'language' => 'required',
        'status' => 'required',
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function blog_validator($request)
{
    $validator = Validator::make($request->all(), [
        'category_id' => "required",
        'language' => 'required',
        'slug' => 'required',
        'content' => 'required',
        'short_description' => 'required',
        'title' => 'required',
        'is_published' => 'required',
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function exchange_validator($request)
{
    $validator = Validator::make($request->all(), [
        'from_currency' => "required|min:3|max:10",
        'to_currency' => 'required|min:3|max:10',
        'money' => 'required'
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
        'min' => 'Đơn vị tiền tệ từ 3 đến 10 ký tự',
        'max' => 'Đơn vị tiền tệ từ 3 đến 10 ký tự',
    ]);

    return $validator;
}

function deal_validator($request)
{
    $validator = Validator::make($request->all(), [
        'title_vi' => "required",
        'title_en' => "required",
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}

function banner_validator($request)
{
    $validator = Validator::make($request->all(), [
        'image' => "required",
    ], [
        'required' => "Vui lòng nhập đầy đủ dữ liệu",
    ]);

    return $validator;
}