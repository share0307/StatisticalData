<?php

namespace App\Http\Business;

use App\Exceptions\JsonException;
use App\Http\Business\Dao\Commentdao;
use App\Http\Business\Dao\WordDao;
use App\Http\Common\Helper;
use App\Model\CommentsFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

class CommentsBusiness extends BusinessBase{

    //关键词 dao
    private $word_dao = null;
    
    //评论 dao
    private $comment_dao = null;
    
    /**
     * 构造方法
     * @author  jianwei
     */
    public function __construct(WordDao $word_dao, Commentdao $comment_dao)
    {
        $this->word_dao = $word_dao;
        $this->comment_dao = $comment_dao;
    }
    
    /**
     * 上传文件
     * @author  jianwei
     * @param $file
     */
    public function uploadExcelFile(UploadedFile $file)
    {
        //$allow_ext_arr = array('xls');
        $allow_ext_arr = array('csv');
        
        $ext_name = $file->getClientOriginalExtension();
        
        if(!in_array($ext_name,$allow_ext_arr)){
            throw new JsonException(20002);
        }
        
        $file_data = array();
        $file_data['file_name'] = $file->getClientOriginalName();
        $file_name = date('Ymdhis').'-'.rand(1,999999999).'.'.$ext_name;
        $file_path = 'upload/';
        $file_save_path = storage_path($file_path);
        $file_data['path'] = $file_path.$file_name;
        
        $file->move($file_save_path,$file_name);
        
        //保存到数据
        $CommentsFileModel = app('CommentsFileModel');
    
        $CommentsFileModel->file_name = $file_data['file_name'];
        $CommentsFileModel->path = $file_data['path'];
    
        $CommentsFileModel->save();
        
        return $CommentsFileModel;
    }
    
    /**
     * 读取文件，保存到数据
     * @author  jianwei
     */
    public function saveCommentData(CommentsFile $comments)
    {
        if(!isset($comments->id)) {
            throw new JsonException(10000);
        }
        
        $file_path = storage_path($comments->path);
        
        if(!file_exists($file_path)) {
            throw new JsonException(20003);
        }
        
        ini_set('memory_limit','1024m');
        set_time_limit(0);
        
        $file = fopen($file_path,"r");
    
        //保存评论数据
        $comments_data = array();
        
        $row = 0;
        while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容
            if(count($data) < 2 || empty($data[0]) || empty($data[1])){
                //跳过
                continue;
            }
            //保存临时数据
            $tmp_data = array();
            //关联的文件 id
            $tmp_data['file_id'] = $comments->id;
            //产品名称
            $tmp_data['product_name'] = mb_convert_encoding($data[0],'utf-8','gbk');
            //评论
            $tmp_data['comments'] = mb_convert_encoding($data[1],'utf-8','gbk');
            //添加时间
            $tmp_data['addtime'] = Helper::getNow();
    
            $comments_data[] = $tmp_data;
    
            app('CommentsModel')->insert($tmp_data);
        }
        fclose($file);
        
        if(empty($comments_data)){
            return $comments_data;
        }
        
        //保存
//        return app('CommentsFileModel')->insert($comments_data);
        
        return $comments_data;
    }
    
    /**
     * 检查
     * @author  jianwei
     */
    public function checkComments($comment_file_id)
    {
        //先取得关键词列表
        $word_list = $this->word_dao->wordList(['all'=>'true']);
        
        //保存返回的数据
        $response_data = array();
        //循环遍历
        $except_id_arr = array();
        foreach ($word_list as $lk=>$lv){
            $comments_list = $this->comment_dao->checkCommentData($comment_file_id,$lv->word,$except_id_arr);
            
            foreach($comments_list as $tk=>$tv) {
                $tmp_arr = explode(',', $tv->comment_ids);
                $response_data[] = array(
                    'product_name' => $tv->product_name,
                    'word' => $lv->word,
                    'total' => count($tmp_arr),
                    'comment_ids' => $tv->comment_ids,
                );
    
                $except_id_arr = array_merge($except_id_arr, $tmp_arr);
            }
        }
        
        return $response_data;
    }
    
}
