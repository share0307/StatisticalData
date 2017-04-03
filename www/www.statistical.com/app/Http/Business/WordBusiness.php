<?php

namespace App\Http\Business;

use App\Exceptions\JsonException;
use App\Http\Business\Dao\WordDao;
use Illuminate\Support\Facades\Validator;

class WordBusiness extends BusinessBase{

    //关键词 dao
    private $word_dao = null;
    
    /**
     * 构造方法
     * @author  jianwei
     */
    public function __construct(WordDao $word_dao)
    {
        $this->word_dao = $word_dao;
    }
    
    
    /**
     * 获取关键词列表
     * @author  jianwei
     */
    public function wordList(array $condition = [],array $select_columns = ['*'],array $relatives = [])
    {
        return $this->word_dao->wordList($condition,$select_columns,$relatives);
    }
    
    /**
     * 添加关键词
     * @author  jianwei
     */
    public function storeWord(array $word_data)
    {
        $rule = array(
            'word'  =>  ['required','string','min:1'],
        );
        
        $validate = Validator::make($word_data,$rule);
        
        if($validate->fails()){
            throw new JsonException(10000);
        }
        
        //查询关键词是否存在
        try {
            $word = $this->word_dao->getWordByName($word_data['word']);
            throw new JsonException(20001);
        }catch (JsonException $e){
            if(!in_array($e->getCode(),[20000])){
                throw new JsonException($e->getCode());
            }
        }
        
        //添加关键词
        $store_response = $this->word_dao->storeWord($word_data);
        
        return $store_response;
    }
    
    /**
     * 删除关键词
     * @author  jianwei
     * @param $word_id  int 关键词 id
     */
    public function destroyWord($word_id)
    {
        if(!is_numeric($word_id) || $word_id < 1){
            throw new JsonException(10000);
        }
        
        return $this->word_dao->destroyWord($word_id);
    }


}
