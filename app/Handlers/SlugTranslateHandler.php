<?php
/**
 * Created by PhpStorm.
 * User: huanghanwei
 * Date: 7/11/18
 * Time: 11:37 PM
 */

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler{

    public function translate($text){

        $http = new Client();

        //init variables
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        $sign = md5($appid. $text . $salt . $key);

        //build parameters
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        $response = $http->get($api.$query);
        $result = json_decode($response->getBody(),true);

        if(isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            return $this->pinyin($text);
        }
    }

    public function pinyin($text){
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}