<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms){

        $phone = $request->phone;

        if(!app()->environment('production')){
            $code = '1234';
        }else{
            $code = str_pad(random_int(1,9999), 4, 0, STR_PAD_LEFT);

            try{
                $result = $easySms->send($phone, [
                    'content'  =>  "【黄乐其bbs】您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            }catch(\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception){
                $message = $exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message ?: 'Message notification has exception');
            }
        }

        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinute(10);

        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            ])->setStatusCode(201);

//        return $this->response->array(['test_message' => 'store verification code']);
    }
}
