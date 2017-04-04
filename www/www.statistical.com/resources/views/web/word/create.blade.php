<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>kwin!</title>
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>


<div class="container">
    <h3>添加关键词</h3>
    @include('web.common.btn')
    <form role="form">
        <div class="form-group">
            <label for="word">名称</label>
            <input type="text" class="form-control" id="word" name="word" placeholder="请输入关键词">
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>
</div>



</body>
</html>