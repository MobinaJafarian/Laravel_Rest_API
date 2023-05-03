<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Jobs\UserMailJob;
use App\Mail\UserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SoapClient;

class HomeController extends Controller
{
    public function email()
    {
        $email = 'nj@gmail.com';
        $mail = new UserMail();
        Mail::to($email)->send($mail);
        dispatch(new UserMailJob($email));

        return response()->json([
            'data' => [
                'message' => 'suceces send',
                'status' => 'success',
            ],
        ]);
    }

    public function buy(Request $request)
    {
        $MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
        $Amount = 1000; //Amount will be based on Toman - Required
        $Description = 'توضیحات تراکنش تستی'; // Required
        $Email = 'nj@gmail.com'; // Optional
        $Mobile = '09123456789'; // Optional
        $CallbackURL = 'http://localhost:8000/api/v2/courses/buy/callback'; // Required


        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );


        if ($result->Status == 100) {
            return redirect('https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
        } else {
            echo'ERR: '.$result->Status;
        }
    }

    public function callback()
    {
        $MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
        $Amount = 1000; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

        if ($_GET['Status'] == 'OK') {

            $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ]
            );

            if ($result->Status == 100) {
                echo 'Transaction success. RefID:'.$result->RefID;
            } else {
                echo 'Transaction failed. Status:'.$result->Status;
            }
        } else {
            echo 'Transaction canceled by user';
        }
    }
}
