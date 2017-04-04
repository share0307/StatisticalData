<?php

namespace App\Http\Business\Dao;

use App\Exceptions\JsonException;
use App\Http\Common\Helper;
use Illuminate\Support\Facades\Validator;

class WordDao extends DaoBase{


    /**
     * 关键词列表
     * @author  jianwei
     * @param $condition    array   查询条件
     * @param $select_columns   array   查询条件
     * @param $relatives    array   关联关系
     *
     */
    public function wordList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $WordsModel = app('WordsModel');
        
        $word_obj = $WordsModel->select($select_columns);
    
        $page_size = isset($condition['page_size']) ? $condition['page_size'] : 10;
    
        $word_obj->orderby('id','desc');
        if(isset($condition['all']) && $condition['all'] == 'true') {
            $word_list = $word_obj->get();
        }else{
            $word_list = $word_obj->paginate($page_size);
        }
        
        if(count($word_list) < 1){
            throw new JsonException(20000);
        }
        
        if(!empty($relatives)){
            $word_list->load($relatives);
        }
        
        return $word_list;
    }
    
    /**
     * 通过关键词找到关键词数据
     * @author  jianwei
     */
    public function getWordByName($word, array $select_columns = ['*'], array $relatives = [])
    {
        $WordsModel = app('WordsModel');
        
        $word_obj = $WordsModel->select($select_columns);
    
        $word_obj->WordQuery($word);
    
        $word = $word_obj->first();
        
        if(empty($word)){
            throw new JsonException(20000);
        }
        
        if(!empty($relatives)){
            $word->load($relatives);
        }
        
        return $word;
    }
    
    
    /**
     * 添加关键词
     * @author  jianwei
     * @param $word_data    array   关键词
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
    
        $WordsModel = app('WordsModel');
    
        //关键词
        $WordsModel->word = $word_data['word'];
        $WordsModel->addtime = Helper::getNow();
    
        $WordsModel->save();
        
        return $WordsModel;
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
    
        return app('WordsModel')->IdQuery($word_id)->delete();
    }

}
