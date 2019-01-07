<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivationCode;
use Illuminate\Support\Carbon;
use App\Course;
use App\Learning;
use App\Payment;
use SoapClient;

class UserController extends Controller
{
    public function activation($token){
        $activationCode = ActivationCode::whereCode($token)->first();
        
        
        if(! $activationCode) {
                dd('not exist');
    
                return redirect('/');
            }
    
            if($activationCode->expire < Carbon::now()) {
                dd('expire');
                return redirect('/');
            }
    
            if($activationCode->used == true) {
                dd('used');
                return redirect('/');
            }
            $activationCode->user()->update([
                'active' => 1
            ]);
    
            $activationCode->update([
                'used' => true
            ]);
    
            auth()->loginUsingId($activationCode->user->id);
            return redirect('/');
    }
    public function index()
    {
        
        return view('Home.panel.index');
    }

    public function history()
    {
    

        $payments = auth()->user()->payments()->latest()->paginate(20);
        return view('Home.panel.history' , compact('payments'));
    }

    public function vip()
    {
        return view('Home.panel.vip');
    }
    protected $MerchantID = 'f83cc956-f59f-11e6-889a-005056a205be';
    public function vipPayment()
    {
        
        $this->validate(request(),[
            'plan' => 'required'
        ]);

        switch (\request('plan')) {
            case 3 :
                $price = 30000;
                break;
            case 12 :
                $price = 120000;
                break;
            default:
                $price = 100;
        }

        $Description = 'توضیحات تراکنش تستی'; // Required
        $Email = user()->email; // Optional
        $CallbackURL = url(route('user.panel.vip.checker')); // Required

        $client = new SoapClient('http://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $this->MerchantID,
                'Amount' => $price,
                'Description' => $Description,
                'Email' => $Email,
                'CallbackURL' => $CallbackURL,
            ]
        );

        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {

            user()->payments()->create([
                'resnumber' => $result->Authority,
                'price' => $price,
            ]);

            return redirect('http://sandbox.zarinpal.com/pg/StartPay/'.$result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function vipChecker()
    {
        $Authority = request('Authority');

        $payment = Payment::whereResnumber($Authority)->firstOrFail();

        if (request('Status') == 'OK') {
            $client = new SoapClient('http://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $this->MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $payment->price,
                ]
            );

            if ($result->Status == 100) {
                if($this->checkPayment($payment)) {
                    alert()->success('عملیات مورد نظر با موفقیت انجام شد','با تشکر');
                    return redirect(route('user.panel'));
                }
            } else {
                echo 'Transaction failed. Status:'.$result->Status;
            }
        } else {
            echo 'Transaction canceled by user';
        }
    }

    public function checkPayment($payment)
    {
        $payment->update([
            'payment' => 1
        ]);

        switch ($payment->price) {
            case 100 :
                $time = 1;
//                $type = 'month';
                break;
            case 30000 :
                $time = 3;
//                $type = '3month';
                break;
            case 120000 :
                $time = 13;
//                $type = '12mo';
                break;
        }

        $user = $payment->user;
       // dd(user);
        $viptime = $user->isActive() ? Carbon::parse($user->viptime) : Carbon::now();
        $user->update([
            'viptime' => $viptime->addMonths($time),
        ]);

        return true;

}
}