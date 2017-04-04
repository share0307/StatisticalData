<?php



Route::group(['namespace'=>'Web'],function(){
    
    //关键词管理
    Route::group(['prefix'=>'/word',],function(){
        //关键词列表
        Route::any('/','WordController@index');
        //添加关键词(页面)
        Route::any('/create','WordController@create');
        //添加关键词(动作)
        Route::any('/store','WordController@store');
        //删除关键词
        Route::any('/destroy','WordController@destroy');
        //初始化关键词
        Route::any('/init','WordController@init');
    });
    
    //评论
    Route::group(['prefix'=>'/comment',],function(){
        //上传文件
        Route::any('/','CommentsController@index');
        //上传文件
        Route::any('/upload','CommentsController@upload');
        //检查
        Route::any('/check','CommentsController@check');
        //评论列表
        Route::any('/list','CommentsController@commentsList');
        //初始化评论表
        Route::any('/init','CommentsController@init');
        //示例导入文件下载
        Route::any('/demo','CommentsController@demo');
    });
    
    Route::any('/',function(){
        return redirect('word/');
    });
});

