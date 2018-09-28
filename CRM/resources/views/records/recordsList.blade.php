<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <link href="../../lib/layui/css/layui.css" rel="stylesheet" />
    <link href="../../lib/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="../../lib/winui/css/winui.css" rel="stylesheet" />
</head>
<body>
<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up">
    <div class="winui-toolbar">
        <div class="winui-tool">
            <button id="reloadTable" class="winui-toolbtn"><i class="fa fa-refresh" aria-hidden="true"></i>刷新数据</button>
            <button id="addRole" class="winui-toolbtn"><i class="fa fa-plus" aria-hidden="true"></i>新增跟单</button>
            <button id="deleteRole" class="winui-toolbtn"><i class="fa fa-trash" aria-hidden="true"></i>删除选中</button>
        </div>
    </div>
    <div style="margin:auto 10px;">
        <table id="records" lay-filter="recordstable"></table>
        <script type="text/html" id="barRole">
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        {{--<script type="text/html" id="stateTpl">--}}
            {{--{{#  if(d.dataState == 1){ }}--}}
            {{--正常--}}
            {{--{{#  } else if(d.dataState==2) { }}--}}
            {{--作废--}}
            {{--{{#  }else{ }}--}}
            {{--未知--}}
            {{--{{#  } }}--}}
        {{--</script>--}}
    </div>
    <script src="../../lib/layui/layui.js"></script>
    <script>
            layui.config({
                base: '../../js/'
            }).use('recordslist');
    </script>
</div>
</body>
</html>