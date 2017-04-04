<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentsFile extends Model {

    use SoftDeletes;
    
    //表名
    protected $table = 'kkk_comments_file';
    
    
    
}
