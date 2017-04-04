<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>kwin!</title>
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/bootstrap/css/fileinput.min.css') }}">--}}
    <script src="{{ asset('/js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
    {{--<script src="{{ asset('/bootstrap/js/fileinput.min.js') }}"></script>--}}
</head>
<body>


<div class="container">
    <h3 class="page-header">评论分析</h3>
    @include('web.common.btn')

    @if($comments_file === null)
        <div class="">
            <form role="form" class="col-sm-12" method="post" action="{{action('Web\CommentsController@upload')}}" enctype="multipart/form-data" >
                <div class="form-group col-sm-5 " style="padding-left: 0px; ">
                    <input type="file" class="form-control panel-info" id="comment" name="comment" placeholder=" 上传文件，支持 csv 文件">
                </div>
                <button type="submit" class="btn btn-default">分析</button>
            </form>
        </div>
    @else
        <div class="col-lg-12 page-header">
            <span class="col-lg-1">当前文件:</span>
            <span class="col-lg-11">
                <b class="btn-danger">{{ $comments_file->file_name }}</b>   <em style="padding-left: 30px;">--分析结果</em>
            </span>
        </div>
    @endif

    @if(!empty($check_response))
    <hr />
    <table class="table table-striped">
        <thead>
        <tr>
            <th>产品名称</th>
            <th>关键词</th>
            <th>总数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($check_response as $rk=>$rv)
            <tr>
                @if(!empty($rv['rowspan']))
                    <td  valign="middle"  style="vertical-align:middle" rowspan="{{ $rv['rowspan'] }}"><b>{{ $rv['word'] }}</b></td>
                @endif
                <td>{{ $rv['product_name'] }}</td>
                <td>{{ $rv['total'] }}</td>
                <td><button comment_ids="{{ $rv['comment_ids'] }}" word="{{ $rv['word'] }}" class="show_comment">查看评论</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

<div id="show_comment" style="position: fixed;top:100px; width: 880px;background:#ffffff;max-height: 500px;overflow:scroll;border: 1px solid #9acfea;display:none;padding: 5px;border-radius:5px;margin: 0 auto;left: 20%;">

    <table class="table table-striped">
        <thead>
        <tr>
            <th>产品名称</th>
            <th>评论</th>
        </tr>
        </thead>
        <tbody class="comment_list">

        </tbody>
    </table>
    <p>
        <button class="btn-xs btn-warning pull-right close_comment">关闭</button>
    </p>
</div>


<script>

    {{--//自动上传文件-JS--}}
    {{--function initFileInput(ctrlName, uploadUrl) {--}}
        {{--var control = $('#' + ctrlName);--}}

        {{--control.fileinput({--}}
            {{--language: 'zh', //设置语言--}}
            {{--uploadUrl: uploadUrl, //上传的地址 (该方法需返回JSON字符串)--}}
            {{--allowedFileExtensions: ['csv',],//接收的文件后缀--}}
            {{--showUpload: false, //是否显示上传按钮--}}
            {{--showCaption: true,//是否显示标题--}}
            {{--browseClass: "btn btn-primary", //按钮样式--}}
            {{--//previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",--}}
            {{--//uploadExtraData: { ID: "123" }--}}
        {{--}).on('filebatchselected', function (event, data, id, index) {--}}
            {{--$(this).fileinput("upload");--}}
        {{--}).on("fileuploaded", function (event, data) {--}}
            {{--if (data.response) {--}}

                {{--//通过 data.response.Json对象属性 获得返回数据--}}
                {{--errors = data.response.ErrorList;--}}
            {{--}--}}
        {{--})--}}
    {{--}--}}

    {{--//上传JS初始化--}}
    {{--$(function () {--}}
        {{--initFileInput("comment", '{{action('Web\CommentsController@upload')}}');--}}
    {{--});--}}
    {{--//获取上传文件弹窗关闭动作--}}
    {{--$("#fileUpload").change(function () { alert("上传文件弹窗已关闭") });--}}

    $(function(){
        $('.show_comment').click(function(){
            var comment_ids = $(this).attr('comment_ids');

            var word = $(this).attr('word');

            //先隐藏显示层
            $('#show_comment').hide(300);


            //请求
            $.ajax({
                url   :   '{{action('Web\CommentsController@commentsList')}}',
                data  : {
                    'comment_ids'   :   comment_ids,
                },
                success :   function(data,xhr){
                    console.log(data);
                    if(typeof data.code == 'undefined'){
                        alert('请求出错!');
                        return false;
                    }else if(data.code != 0){
                        alert(data.msg);
                        return false;
                    }


                    var tmp = '';
                    for (var i in data.data){
                        tmp+='\
                            <tr>\
                                <td>'+data.data[i].product_name+'</td>\
                                <td>'+data.data[i].comments.replace(word, '<span style="color:red;font-weight: bold;">'+word+"</span>")+'</td>\
                            </tr>\
                        '
                    }

                    $('.comment_list').html(tmp);

                    //先隐藏显示层
                    $('#show_comment').show(300);
                    return true;
                }
            });
        });

        //关闭
        $('.close_comment').click(function(){

            //先隐藏显示层
            $('#show_comment').hide(300);
        });
    });

</script>
</body>
</html>