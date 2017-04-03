<?php

namespace App\Http\Controllers\Web;

use App\Http\Business\WordBusiness;
use Illuminate\Http\Request;

class WordController extends WebController{
    
    
    /**
     * 关键词列表
     * @author  jianwei
     */
    public function index(Request $request, WordBusiness $word_business)
    {
        $condition = $request->all();
        
        $word_list = $word_business->wordList($condition);
        
        return $this->jsonFormat($word_list);
    }
    
    /**
     * 添加关键词,页面展示
     * @author  jianwei
     */
    public function create()
    {
    
    }
    
    /**
     * 添加关键词,动作
     */
    public function store(Request $request, WordBusiness $word_business)
    {
        $word_data = $request->all();
    
        $store_response = $word_business->storeWord($word_data);
        
        return $this->jsonFormat($store_response);
    }
    
    /**
     * 删除关键词
     * @author  jianwei
     */
    public function destroy(Request $request, WordBusiness $word_business)
    {
        $word_id = $request->get('word_id');
        
        $destroy_response = $word_business->destroyWord($word_id);
        
        return $this->jsonFormat($destroy_response);
    }
    
    
}
