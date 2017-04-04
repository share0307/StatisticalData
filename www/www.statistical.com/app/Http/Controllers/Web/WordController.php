<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\JsonException;
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
    
        $condition['all'] = 'true';
        
        try {
            $word_list = $word_business->wordList($condition);
        }catch (JsonException $e){
            $word_list = null;
        }
        
        $response_arr = array();
        //关键词列表
        $response_arr['word_list'] = $word_list;
        
        return view('web.word.list')->with($response_arr);
        //return $this->jsonFormat($word_list);
    }
    
    /**
     * 添加关键词,页面展示
     * @author  jianwei
     */
    public function create()
    {
        return view('web.word.create');
    }
    
    /**
     * 添加关键词,动作
     */
    public function store(Request $request, WordBusiness $word_business)
    {
        $word_data = $request->all();
    
        try {
            $store_response = $word_business->storeWord($word_data);
        }catch (JsonException $e){
        
        }
        
        //跳回列表
        return redirect('/word');
        
        //return $this->jsonFormat($store_response);
    }
    
    /**
     * 初始化
     */
    public function  init(Request $request, WordBusiness $word_business)
    {
        $word_data = array('尺码问题','尺寸','偏大','偏小','大','小','规格','码数','小一号','大一号','号大','号小','小一点','大一点','腰围紧','勒','腰围','腰围太紧','质量问题','质量','质量差','侧漏','漏尿','潮','湿','漏','前漏','流出来','后漏','导尿','没水份','没水分','太干','干','很干','没水','水珠','高分子','高份子','珠子','颗粒','吸水因子','晶体','白色','吸水珠','太薄','薄','很薄','超薄','有脏物','脏','脏东西','黑点','污点','发霉','起坨','起陀','一块','一坨','一陀','连抽','抽不出','抽','抠','断层','短层','吸水性','吸水量一般','吸水量不足','不够干燥','吸收效果','不干爽','吸水效果','异味','塑料味','味','味道','气味','刺鼻','臭','材质问题','材质','魔术贴','粘','断开','划伤','硬','没尿显','尿显','尿显不明显','没有尿显','不良反应','不良反应','红屁屁','屁股','过敏','红','pp','PP','屁屁','湿疹','起疹','疹子','过敏','敏感','摩擦','价格问题','价格','涨价','贵','不划算','降价','便宜','价格跌','价格低了','其他问题','其他问题','商品不满意','不满意','没想象中好','质量不好','质量差','不满意','不怎么好','一般般','一般般','差','很差','太差','少发','漏发','少','假货','不是正品','错发','发错','客服问题','回复慢','等半天','没人','没客服','没回应','没回答','没下文','没人理','服务不好','不回话','不理','不回复','不处理','解决问题','包装问题','包装问题','包装差','烂','坏','包装不好','破损','包装烂','箱子烂','物流问题','物流','不送货上门','不送货上门','自取','快递态度差','态度不好','发货慢','发货太慢','慢','快递慢','不给力','物流慢死','物流超级慢','发货速度太慢','物流不送','不给送');
    
        $response_arr = array();
        foreach($word_data as $dk=>$dv) {
            try {
                $tmp = array('word'=>$dv);
                $store_response = $word_business->storeWord($tmp);
            }catch (JsonException $e){
                continue;
            }
    
            $response_arr[] = $store_response;
        }
        
        return $this->jsonFormat($response_arr);
    }
    
    /**
     * 删除关键词
     * @author  jianwei
     */
    public function destroy(Request $request, WordBusiness $word_business)
    {
        $word_id = $request->get('word_id');
        
        $destroy_response = $word_business->destroyWord($word_id);
        
        //跳回列表
        return redirect('/word');
        
        //return $this->jsonFormat($destroy_response);
    }
    
    
}
