<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{trans("index.thanhtoanttnganluong")}}</title>
</head>

<script type="text/javascript">
    function check() {
        var price = document.Test.txt_gia.value;

        if (price < 0) {

            alert('Minimum amount is 2000 VND');
            return false;
        }

        return true;
    }
</script>

<body>
<p>
    <span class="font-dark">
        <em>
            <span style="font-size: medium;">
                <strong>
                    <span>
{{trans("index.thanhtoanttnganluong")}}
                    </span>
                </strong>
             </span>
        </em>
</p>
{{Form::open(['action' => 'Frontend\PaymentController@payment', 'method' => 'post', 'name' => 'Test', 'onsubmit' => "return check();"])}}
<table>
    <tr>
        <th><strong>{{trans("index.hoten")}}:</strong></th>
        <td><input type="text" name="txt_name" size="28" placeholder="{{trans("index.hoten")}}"/></td>
    </tr>
    <tr>
        <th><strong>Email:</strong></th>
        <td><input type="text" name="txt_email" size="28" placeholder="địa chỉ email"/></td>
    </tr>
    <tr>
        <th><strong>{{trans("index.dienthoai")}}:</strong></th>
        <td><input type="text" name="txt_phone" size="28" placeholder="{{trans("index.dienthoai")}}"/></td>
    </tr>
    <tr>
        <th><strong>{{trans("index.sotienthanhtoan")}}:</strong></th>
        <td><input name="txt_gia" type="text" size="28" placeholder="{{trans("index.sotienthanhtoan")}}"/></td>
    </tr>
    <tr>
        <th></th>
        <td><input type="submit" name="submit" value="{{trans("index.thanhtoan")}}"></td>
    </tr>
</table>
{{Form::close()}}
</body>
</html>

