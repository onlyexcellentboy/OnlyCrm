﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>售后列表</title>
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
            <button id="addMenu" class="winui-toolbtn"><i class="fa fa-plus" aria-hidden="true"></i>新增售后</button>
            <button id="editMenu" class="winui-toolbtn"><i class="fa fa-pencil" aria-hidden="true"></i>编辑售后</button>
            <button id="deleteMenu" class="winui-toolbtn"><i class="fa fa-trash" aria-hidden="true"></i>删除选中</button>
        </div>
    </div>
    <div style="margin:auto 10px;">
        <table id="sale" lay-filter="saletable"></table>
        <script type="text/html" id="barMenu">
            <a class="layui-btn layui-btn-xs" lay-event="setting">权限设置</a>
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        {{--<script type="text/html" id="openTypeTpl">--}}
            {{--{{#  if(d.openType == 1){ }}--}}
            {{--HTML--}}
            {{--{{#  } else if(d.openType==2) { }}--}}
            {{--Iframe--}}
            {{--{{#  } }}--}}
        {{--</script>--}}
        {{--<script type="text/html" id="isNecessary">--}}
            {{--{{#  if(d.isNecessary){ }}--}}
            {{--是--}}
            {{--{{#  } else { }}--}}
            {{--否--}}
            {{--{{#  } }}--}}
        {{--</script>--}}
        <div class="tips">Tips：1.系统菜单不可以删除 2.修改或添加数据后暂不支持自动刷新表格</div>
    </div>
    <script src="../../lib/layui/layui.js"></script>
    <script type="text/javascript">
        layui.config({
            base: '../../js/'
        }).use('salelist');
    </script>
</div>
</body>
</html>