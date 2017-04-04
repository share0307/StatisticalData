<div class="col-lg-12" style="padding-bottom: 15px;">
    <a href="{{action('Web\WordController@index')}}" class="btn btn-xs {{ \Illuminate\Support\Facades\Request::is('word') ? 'btn-success' : 'btn-info' }}">关键词列表</a>
{{--    <a href="{{action('Web\WordController@create')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('word/create') ? 'btn-success' : 'btn-info' }}">添加关键词</a>--}}
    <a href="{{action('Web\CommentsController@index')}}" class="btn btn-xs  {{ \Illuminate\Support\Facades\Request::is('comment') ? 'btn-success' : 'btn-info' }}">分析评论</a>
</div>