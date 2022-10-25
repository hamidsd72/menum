<?php

namespace App\Http\Controllers\User;

use App\Activity;
use App\Model\ServiceFactor;
use function GuzzleHttp\Psr7\str;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transaction;
use SoapClient;
use App\Payer;
use Gateway;
use App\Ad;
use App\Need;
use App\Verify;
use App\SedaCard;
use App\OffCode;


class ZarinpalController extends Controller
{

 



//    user
    public function pay($id, $total, $user,$type)
    {
//        $price = 5000;
        $price = $total * 10;
//        dd($price);
//        if(auth()->user()->id==2)
//        {
//            $price=5000;
//        }
        try {
            $gateway = Gateway::Zarinpal();
//            dd
            $gateway->setCallback(route('user.verify_user'));
            $gateway->price($price)->ready();
            $refId = $gateway->refId();
            $transID = $gateway->transactionId();
//            return $transID;
            $data = Transaction::where('factor_id', $id)->first();
            if (!is_null($data)) {
                $data->delete();
            }

            $item = new Transaction();
            $item->user_id=$user;
            $item->factor_id=$id;
            $item->total=$total;
            $item->transaction_id=$refId;
            $item->type=$type;
            $item->save();
            // Your code here
            return $gateway->redirect();

        } catch (Exception $e) {

            return redirect('/')->with('flash_message', $e->getMessage());

        }

    }


    public function verify(Request $request)
    {

        if (($request['Status']) == 'NOK') {

            // basket back
            $item = Transaction::where('transaction_id', $request['Authority'])->first();

            try {
                $factor=ServiceFactor::find($item->factor_id);
                $factor->status="pending";
                $factor->pay_status="cancel";
                $factor->update();
                    return redirect()->route('user.index')->with('err_message', 'عملیات پرداخت لغو شد لطفا مجدد تلاش کنید');
            } catch (\Exception $e) {
                return redirect()->route('user.index')->with('err_message', 'عملیات پرداخت لغو شد لطفا دوباره تلاش کنید');
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
//            $item->card_number = $cardNumber;
//            $item->final_amount = str_replace(',','',$gateway->amount());
            $item->tracing_code = $request->transaction_id;
            $item->save();
            $factor=ServiceFactor::find($item->factor_id);
            $factor->status="pending";
            $factor->pay_status="paid";
            $factor->update();
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
            return redirect()->route('user.index')->with('flash_message','
            ثبت نام شما با موفقیت انجام شد. شروع خدمات سدار کارت در روزهای آتی از طریق شرکت سدار به شما اطلاع می گردد.
            ');
        } catch (Exception  $e) {
            return redirect()->route('user.index')->with('err_message', 'خطایی رخ داده مجددا تلاش کنید');
        }

    }
}