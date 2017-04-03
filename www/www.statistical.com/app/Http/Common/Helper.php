<?php

namespace App\Http\Common;

class Helper{
    
    
    /**
     * 获取当前时间
     * @author  jianwei
     * @param   $flag   double  当$flag 为 true 时,等同于 time()
     */
    public static function getNow($flag = false)
    {
        static $now_time = null;
        if(null === $now_time){
            $now_time = time();
        }
        
        if(true === $flag){
            return time();
        }
        
        return $now_time;
    }
    
    
}
