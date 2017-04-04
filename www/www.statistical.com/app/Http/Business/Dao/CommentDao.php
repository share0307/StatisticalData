<?php

namespace App\Http\Business\Dao;

use App\Exceptions\JsonException;
use App\Http\Common\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Commentdao extends DaoBase{

    
    /**
     * 模拟匹配出数据
     * @author  jianwei
     * @param $comment_file_id  int 文件 id
     * @param $word string  关键词
     * @param $except_id_arr    array   排除的 id
     */
    public function checkCommentData($comment_file_id,$word,array $except_id_arr)
    {
        if(empty($word) || !is_numeric($comment_file_id)){
            throw new JsonException(10000);
        }
        
        $CommentsModel = app('CommentsModel');
    
        $select_column = DB::raw('GROUP_CONCAT(id) as comment_ids, `product_name`');
        $comments_obj = $CommentsModel->select($select_column);
    
        $comments_obj->where('file_id',$comment_file_id);
        $comments_obj->where('comments','like','%'.$word.'%');
        
        if(!empty($except_id_arr)){
            $comments_obj->whereNotIn('id',$except_id_arr);
        }
    
        $comments_obj->groupBy('product_name');
    
        $comments_list = $comments_obj->get();
    
        return $comments_list;
    }

    


}
