<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Words extends Model {

    use SoftDeletes;
    
    //表名
    protected $table = 'kkk_words';
    
    
    /**
     * 通过名称查询
     * @author  jianwei
     */
    public function scopeWordQuery($query, $word)
    {
        return $query->where('word',$word);
    }
    
    /**
     * 通过 id 查询
     * @author  jianwei
     */
    public function scopeIdQuery($query, $word_id)
    {
        return $query->where('id',$word_id);
    }
    
    
}
