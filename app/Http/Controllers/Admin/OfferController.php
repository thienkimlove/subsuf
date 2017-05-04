<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Helper\offerHelper;
use App\Http\Controllers\Controller;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private $request;
    private $offerRepository;

    public function __construct(Request $request, OfferRepository $offerRepository)
    {
        $this->request = $request;
        $this->title = 'Quản lý Offer';
        $this->offerRepository = $offerRepository;
    }

    public function info($offer_id)
    {
        $offer = $this->offerRepository->find($offer_id);

        if ($offer !== null) {
            $response = [
                'title' => $this->title,
                'offer' => $offer
            ];

            return view('admin.offer.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }
}