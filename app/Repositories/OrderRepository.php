<?php
namespace App\Repositories;

use App\Helper\ImageUpload;
use App\Helper\MessageHelper;
use App\Notification;
use App\Offer;
use App\Order;
use App\OrderImage;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Optimus\Optimus;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    function select($query = [])
    {
        $statement = $this->order;

        foreach ($query as $key => $value) {
            if ($key == 'email') {
                $statement = $statement->whereHas('account', function ($query) use ($key, $value) {
                    $query->where($key, 'like', "%$value%");
                });
            } else {
                $statement = $statement->whereRaw($value);
            }
        }

        $statement = $statement->with('account')->with('to_location')->with('from_location');

        return $statement->orderBy('request_time', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($order_id)
    {
        return $this->order->with('order_images')
            ->with('account')
            ->with('to_location')
            ->with('from_location')
            ->find($order_id);
    }

    public function saveOrder($user_id, $order1, $order2, $order3)
    {

        $order = new Order();
        $order->order_status = 1;
        $order->shopper_id = $user_id;
        $order->deliver_date = $order2["deliver_date"] ? date("Y-m-d", strtotime($order2["deliver_date"])) : '';
        $order->deliver_from = $order2["deliver_from"];
        $order->deliver_to = $order2["deliver_to"];
        $order->link = isset($order1["url"]) ? trim($order1["url"]) : "";
        $order->name = $order1["name"];
        $order->description = $order1["description"];
        $order->price = (float)$order1["price"];
        $order->quantity = (float)$order1["quantity"];
        $order->traveler_reward = (float)$order2["input-reward"];
        $order->additional_details = isset($order3["item_detail"]) ? $order3["item_detail"] : "";


        $order->save();

        $optimus = new Optimus(1580030173, 59260789, 1163945558);

        $id = $optimus->encode($order->order_id);

        $order->code = $id;

        $order->save();


        foreach ($order1["images"] as $item) {
            $orderImage = new OrderImage();
            $orderImage->order_id = $order->order_id;
            $orderImage->image = $item;
            $orderImage->save();
        }
        return $order->order_id;
    }

    public function editOrder($order_id, $request)
    {
        $order = Order::find($order_id);
        $deliver_date = $request->input("deliver_date", '');
        $order->deliver_date = ($deliver_date) ? date("Y-m-d", strtotime($deliver_date)) : '';
        $order->deliver_from = $request->input("deliver_from");
        $order->deliver_to = $request->input("deliver_to");
        $order->link = $request->input("link", $order->link);
        $order->name = $request->input("name");
        $order->description = $request->input("description");
        $order->price = (float)$request->input("price");
        $order->quantity = (float)$request->input("quantity");
        $order->traveler_reward = (float)$request->input("input-reward");
        $order->additional_details = $request->input("item_detail", "");
        $order->save();

        $count_image = 0;
        $delete_image = 0;

        foreach ($order->order_images as $image) {
            if (!in_array($image->order_image_id, $request->input("images-link", []))) {
                $image->delete();
//                $delete_image += 1;
            } else {
                $count_image += 1;
            }
        }
        $files = $request->file('images', []);
        if ($count_image == 0 && count($files) <= 1) {
            return false;
        }
        foreach ($files as $file) {
            $image = self::uploadOrderImage($file);
            if ($image) {
                $orderImage = new OrderImage();
                $orderImage->order_id = $order->order_id;
                $orderImage->image = $image;
                $orderImage->save();
            }
        }

        self::removeOffer($order_id, $order);
        return true;
    }

    public function uploadOrderImage($file)
    {
        $rules = array('file' => 'required|mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array('file' => $file), $rules);
        if ($validator->passes()) {
            return "/" . ImageUpload::order($file);
        } else {
            return "";
        }
    }

    public function uploadImage($file, $path)
    {
        $rules = array('file' => 'required|mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array('file' => $file), $rules);
        if ($validator->passes()) {
            $destinationPath = 'upload/order/' . date("ym") . "/";
            $filename = $file->getClientOriginalName();
            $upload_success = $file->move($destinationPath, $filename);
            return $destinationPath . $filename;
        } else {
            return "";
        }
    }

    public function removeOffer($order_id, $order = null)
    {
        $offers = Offer::where('order_id', $order_id)->get();
        foreach ($offers as $offer) {
            try {
                //Create Edit Order Notification
                $data = get_notification($order, $offer, MessageHelper::edit_order(), MessageHelper::edit_order('en'), 'edit_order');

                $notification_id = Notification::insertGetId($data);
                $notification = Notification::with('from_user')
                    ->with('to_user')
                    ->with('order')
                    ->where('notification_id', $notification_id)->first();

                //send mail
                send_mail($notification, 'edit_order');
            } catch (\Exception $e) {
            }
        }

        Offer::where("order_id", $order_id)->delete();
        return true;
    }
}