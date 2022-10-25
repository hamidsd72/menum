<?php

namespace App\Http\Controllers\User;


use App\User;
use App\Model\Service;
use App\Model\ServicePackage;
use App\Model\Basket;
use App\Model\BasketFactor;
use App\Model\OffCode;

use App\Model\Activity;
use App\Model\ServiceFactor;
use function GuzzleHttp\Psr7\str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transaction;
use Illuminate\Support\Facades\Cookie;
use SoapClient;
use Gateway;
class ZarinpalNewController extends Controller
{

//    user
    public function pay($factor_id, $user_id)
    {
        $factor=BasketFactor::findOrFail($factor_id);
        $total= $factor->sum_off_price;
        $price = $factor->sum_off_price * 10;
//        if(auth()->user()->id==2)
//        {
//            $price=5000;
//        }
        try {
            $gateway = Gateway::Zarinpal();
            $gateway->setCallback(route('user.verify.new'));
            $gateway->price($price)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();
            $data = Transaction::where('factor_id', $factor_id)->where('user_id', $user_id)->where('type', 'factor')->where('status', 0)->first();
            if (!is_null($data)) {
                $data->delete();
            }
            $item = new Transaction();
            $item->user_id=$user_id;
            $item->factor_id=$factor_id;
            $item->total=$total;
            $item->transaction_id=$refId;
            $item->type='factor';
            $item->save();
            return $gateway->redirect();
        } catch (Exception $e) {
            return redirect('/')->with('flash_message', $e->getMessage());
        }
    }
    public function verify(Request $request)
    {

        if (($request['Status']) == 'NOK') {
            $item = Transaction::where('transaction_id', $request['Authority'])->first();
            try {
                $factor=BasketFactor::find($item->factor_id);
                $factor->status="cancel";
                $factor->update();
                return redirect()->route('user.basket.list')->with('err_message', 'عملیات پرداخت لغو شد لطفا مجدد تلاش کنید');
            } catch (\Exception $e) {
                $factor=BasketFactor::find($item->factor_id);
                $factor->status="cancel";
                $factor->update();
                return redirect()->route('user.basket.list')->with('err_message', 'عملیات پرداخت لغو شد لطفا دوباره تلاش کنید');
            }
        }
        try {
            $gateway = \Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $cardNumber = $gateway->cardNumber();
            $item = Transaction::where('transaction_id', $request->Authority)->first();
            $item->status = 1;
            $item->tracing_code = $trackingCode;
            $item->transaction_id = $request->transaction_id;
            $item->tracing_code = $request->transaction_id;
            $item->save();

            $factor=BasketFactor::find($item->factor_id);
            $factor->status="active";
            $factor->update();

            $baskets=Basket::where('factor_id',$factor->id)->get();
            foreach ($baskets as $basket)
            {
                $basket->status='active';
                $basket->update();
                if($basket->type=='service')
                {
                    $item=Service::find($basket->sale_id);
                }
                else
                {
                    $item=ServicePackage::find($basket->sale_id);
                }
                if($item)
                {
                    $item->sale_count+=1;
                    $item->update();
                }
            }
            $off_code=OffCode::where('code',$factor->off_code)->first();
            if($off_code)
            {
                $off_code->used_num+=1;
                if(($off_code->used_num+1)>=$off_code->inventory)
                {
                    $off_code->used='yes';
                }
                $off_code->update();
            }
            $basket_show=[];
            $order_code=0;
            Cookie::queue('basket', json_encode($basket_show), 1);
            Cookie::queue('order_code', json_encode($order_code), 1);
            if (Cookie::has('basket')) {
                Cookie::queue(Cookie::forget('basket'));
            }
            if (Cookie::has('order_code')) {
                Cookie::queue(Cookie::forget('order_code'));
            }

            if($basket->type=='service')
            {
                $item=Service::find($basket->sale_id);
                return redirect()->route('user.service',[$item->slug])->with('flash_message','خرید شما با موفقیت انجام شد');

            }
            else
            {
                $item=ServicePackage::find($basket->sale_id);
                return redirect()->route('user.package',[$item->slug])->with('flash_message','خرید شما با موفقیت انجام شد');

            }

        } catch (Exception  $e) {
            $item = Transaction::where('transaction_id', $request->Authority)->first();
            $factor=BasketFactor::find($item->factor_id);
            $factor->status="error";
            $factor->update();
            return redirect()->route('user.basket.list')->with('err_message', 'خطایی رخ داده مجددا تلاش کنید');
        }

    }
}
