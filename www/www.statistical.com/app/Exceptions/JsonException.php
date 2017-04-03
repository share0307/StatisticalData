<?php

namespace App\Exceptions;

use Exception;

class JsonException extends Exception 
{
    /**
     * 错误码列表
     * 10000 - 19999 基本错误
     */
    private $code_list = [
        '20000'   =>  [
            'msg'   =>  '没找到关键词!'
        ],
        '20001'   =>  [
            'msg'   =>  '关键词已存在!'
        ],
        
        /*---基本错误 end-----*/
        '10000'   =>  [
            'msg'   =>  '参数错误'
        ],
    ];


    /**
     * 构造函数
     */
    public function __construct($code, $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }


    /**
     * 获取错误信息
     */
    public function getErrorMsg()
    {
        $re = [
            'code' => 10000,
            'msg'  => $this->code_list[10000]['msg'],
            'data' => '',
            'module'    =>  config('site.module_name'),
        ];
        if (empty($this->code_list[$this->code])) {
            return $re;
        }

        $re['code'] = (string)$this->code;
        $re['msg']  = $this->code_list[$this->code]['msg'];
        $re['data'] = $this->data;
        $re['module'] = config('site.module_name');

        return $re;
    }
}
