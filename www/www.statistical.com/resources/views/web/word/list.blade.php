<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>kwin!</title>
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('/js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>


<div class="container">
    <h3 class="page-header">关键词</h3>
    @include('web.common.btn')
    <div class="">
        <form role="form" class="col-sm-12" method="post" action="{{action('Web\WordController@store')}}">
            <div class="form-group col-sm-5 " style="padding-left: 0px; ">
                <input type="text" class="form-control panel-info" id="word" name="word" placeholder="添加关键词">
            </div>
            <button type="submit" class="btn btn-default">保存</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>编号</th>
            <th>关键词</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($word_list as $lk=>$lv)
            <tr>
                <td>{{ $lv->id }}</td>
                <td>{{ $lv->word }}</td>
                <td>{{ date('Y-m-d h:i:s',$lv->addtime) }}</td>
                <td><a href="{{ action('Web\WordController@destroy').'?word_id='.$lv->id }}">删除</a> </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



</body>
</html>