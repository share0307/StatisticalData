<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\JsonException;
use App\Http\Business\CommentsBusiness;
use Illuminate\Http\Request;

class CommentsController extends WebController{
    
    /**
     * 检查文件
     * @author  jianwei
     */
    public function index(Request $request,CommentsBusiness $comments_business)
    {
        $comment_file_id = $request->get('comment_file_id');
    
        //评论文件
        $comment_file = null;
        //检出的数据
        $check_response = null;
        try {
            $comment_file = $comments_business->getCommentFile($comment_file_id);
            //但存在即分析咯
            $check_response = $comments_business->checkComments($comment_file_id);
        }catch (JsonException $e){
            $comment_file = null;
            $check_response = null;
        }
        
        $response_arr = array();
        $response_arr['comment_file_id'] = $comment_file_id;
        $response_arr['comments_file'] = $comment_file;
        $response_arr['check_response'] = $check_response;
        
        return view('web.comment.index')->with($response_arr);
    }
    
    
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
    
        //先删除之前的数据
        //$comments_business->delHistoryComment();
        
        //保存文件
        $upload_response = $comments_business->uploadExcelFile($file);
        
        //读取文件写入数据库
        $save_response = $comments_business->saveCommentData($upload_response);
        
        $redirect_url = url('/comment').'?'.http_build_query(['comment_file_id'=>$upload_response->id]);
        return redirect($redirect_url);
        
        //return $this->jsonFormat($upload_response);
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
    
    
    /**
     *  通过评论 id 找到评论
     * @author  jianwei
     */
    public function commentsList(Request $request, CommentsBusiness $comments_business)
    {
        $comment_ids = $request->get('comment_ids');
    
        $comment_id_arr = explode(',', $comment_ids);
        
        $comments_list = $comments_business->getCommentList($comment_id_arr);
        
        return $this->jsonFormat($comments_list);
    }
    
    /**
     * 删除之前的数据
     * @author  jianwei
     */
    public function init(CommentsBusiness $comments_business)
    {
        //先删除之前的数据
        $sb = $comments_business->delHistoryComment();
        
//        dd($sb);
        return redirect('/comment');
    }
    
}
