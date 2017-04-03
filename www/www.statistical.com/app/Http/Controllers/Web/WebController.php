<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WebController extends Controller {
    
    
    /**
     * 格式转化
     * @auth jianwei
     */
    public function jsonFormat($data)
    {
        if(is_object($data)){
            if(method_exists($data,'toArray')){
                $data = $data->toArray();
            }
        }
        
        if(!is_array($data)){
            $data = (array)$data;
        }
        
        return [
            'code' => 0,
            'msg'  => '成功',
            'module'    =>  config('site.module_name'),
            'data' => $data,
        ];
    }

}
