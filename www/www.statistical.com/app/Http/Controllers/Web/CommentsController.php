<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\JsonException;
use App\Http\Business\CommentsBusiness;
use App\Http\Business\WordBusiness;
use Illuminate\Http\Request;

class CommentsController extends WebController{
    
    
    /**
     * 上传文件
     * @author  jianwei
     */
    public function upload(Request $request, CommentsBusiness $comments_business)
    {
        $file = $request->file('comment');
        
        if(empty($file)){
            throw new JsonException(10000);
        }
    
        //保存文件
        $upload_response = $comments_business->uploadExcelFile($file);
        
        //读取文件写入数据库
        $save_response = $comments_business->saveCommentData($upload_response);
        
        return $this->jsonFormat($upload_response);
    }
    
    /**
     * 根据关键词，从数据中查询
     * @author  jianwei
     */
    public function check(Request $request, CommentsBusiness $comments_business)
    {
        $comment_file_id = $request->get('comment_file_id');
    
        $check_response = $comments_business->checkComments($comment_file_id);
        
        return $this->jsonFormat($check_response);
    }
    
    
}
