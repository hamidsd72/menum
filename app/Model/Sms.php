<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public static function SendSms($message, $destination)
    {
        $username = '989121031355';

        // $password = '@min4400';
        $password = '@Min4400';

        $originator = '500049295';

        $massage = $message;

        $content = urlencode($massage);

        $destination = $destination;

        $url = "https://negar.armaghan.net/sms/url_send.html?originator=$originator&destination=$destination&content=$content&password=$password&username=$username";

        if (extension_loaded('curl')) {

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);

            $curl_errno = curl_errno($ch);

            curl_close($ch);

            if ($curl_errno) {

                return false;

            }

        } else {

            $response = @file_get_contents($url);

        }


        if (false !== $response) {

            $json_response = json_decode($response);

            if ($json_response) {

                $json_return = $json_response->return;

                if ($json_return->status == 200) {

                    return $response;

                }

            }

        }

        return $response;
    }

    public static function TurkSendSms($message, $gsm) {

        $username = '5411010374';
        $password = '32f0e6ad795f5e0f53005796eb3d73b7';

        $url = "https://api.senagsm.com.tr/api/smsget/v1?username=".$username."&password=".$password."&header=ADIB&gsm=".$gsm."&message=".$message;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($ch);
        curl_close($ch);
        echo '['.$response.']'."\n";
    }
}
