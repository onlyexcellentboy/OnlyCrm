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
            <button id="addAdmin" class="winui-toolbtn"><i class="fa fa-plus" aria-hidden="true"></i>新增管理员</button>
            <button id="deleteAdmin" class="winui-toolbtn"><i class="fa fa-trash" aria-hidden="true"></i>删除选中</button>
        </div>
    </div>
    <div style="margin:auto 10px;">
        <table id="admin" lay-filter="admintable"></table>
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
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script>
            layui.config({
                base: '../../js/'
            }).use('adminlist');
    </script>
</div>

</body>
</html>


<script type="text/javascript">

//    $('#addAdmin').click(function () {
////        alert(1);
//
//        //从桌面打开
//        top.winui.window.open({
//            id: 'editAdmin',
//            type: 1,
//            title: '编辑管理员',
//            content: content,
//            area: ['60vw', '70vh'],
//            offset: ['15vh', '20vw'],
//        });
//        top.winui.window.msg("选择框带联动的,尽情享用", {
//            time: 2000
//        });
//    });
</script>