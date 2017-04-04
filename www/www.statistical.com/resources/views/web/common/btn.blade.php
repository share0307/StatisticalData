<div class="col-lg-12" style="padding-bottom: 15px;">
    <a href="{{action('Web\WordController@index')}}" class="btn btn-xs {{ \Illuminate\Support\Facades\Request::is('word') ? 'btn-success' : 'btn-info' }}">关键词列表</a>
{{--    <a href="{{action('Web\WordController@create')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('word/create') ? 'btn-success' : 'btn-info' }}">添加关键词</a>--}}
    <a href="{{action('Web\CommentsController@index')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('comment') ? 'btn-success' : 'btn-info' }}">分析评论</a>
    <a href="{{action('Web\CommentsController@init')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('comment/init') ? 'btn-success' : 'btn-info' }}">初始化评论数据</a>
    <a href="{{action('Web\CommentsController@demo')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('comment/demo') ? 'btn-success' : 'btn-info' }}" target="_blank" alt="示例导入文件下载">示例文件</a>
</div>