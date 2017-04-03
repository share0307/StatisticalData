<?php



Route::group([],function(){
    
    //关键词管理
    Route::group(['prefix'=>'/word','namespace'=>'Web'],function(){
        //关键词列表
        Route::any('/','WordController@index');
        //添加关键词(页面)
        Route::any('/create','WordController@create');
        //添加关键词(动作)
        Route::any('/store','WordController@store');
        //删除关键词
        Route::any('/destroy','WordController@destroy');
    });
    
    //评论
    Route::group(['prefix'=>['comment',]],function(){
        //上传文件
        Route::any('upload','CommentsController@upload');
    });
    
    
});

