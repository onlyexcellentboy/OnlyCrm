layui.config({
    base: '../../lib/winui/' //指定 winui 路径
    , version: '1.0.0-beta'
}).define(['table', 'jquery', 'winui'], function (exports) {

    winui.renderColor();

    var table = layui.table,
        $ = layui.$,
        tableId = 'tableid';
    //表格渲染
    table.render({
        id: tableId,
        elem: '#user',
        url: 'http://www.crm.com/userInfo',
        //height: 'full-65', //自适应高度
        //size: '',   //表格尺寸，可选值sm lg
        //skin: '',   //边框风格，可选值line row nob
        //even:true,  //隔行变色
        page: true,
        limits: [8, 16, 24, 32, 40, 48, 56],
        limit: 8,
        cols: [[
            { field: 'user_id', type: 'checkbox' },
            { field: 'user_id', title: '项目信息', width: 90 },
            { field: 'ctime', title: '录入时间', width: 110 },
            { field: 'user_name', title: '客户名称', width: 90, templet: '#stateTpl' },
            { field: 'province', title: '省份', width: 80, templet: '#stateTpl' },
            { field: 'city', title: '地区', width: 80, templet: '#stateTpl' },
            { field: 'area_detail', title: '详细地址', width: 150, templet: '#stateTpl' },
            { field: 'user_type', title: '客户类型', width: 90, templet: '#stateTpl' },
            { field: 'user_phone', title: '联系电话', width: 120, templet: '#stateTpl' },
            { field: 'user_from', title: '客户来源', width: 90, templet: '#stateTpl' },
            { field: 'admin_name', title: '联系人', width: 80, templet: '#stateTpl' },
            { field: 'place', title: '职位', width: 80, templet: '#stateTpl' },
            { field: 'admin_phone', title: '手机号码', width: 120, templet: '#stateTpl' },
            { title: '操作', fixed: 'right', align: 'center', toolbar: '#barRole', width: 120 }
        ]]
    });
    //监听工具条
    table.on('tool(usertable)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        var ids = '';   //选中的Id
        $(data).each(function (index, item) {
            ids += item.user_id + ',';
        });
        if (layEvent === 'del') { //删除
            deleteRole(ids, obj);
        } else if (layEvent === 'edit') { //编辑
            if (!data.user_id) return;
            var content;
            var index = layer.load(1);
            $.ajax({
                type: 'get',
                url: 'http://www.crm.com/userEdit?id=' + data.user_id,
                async: true,
                success: function (data) {
                    layer.close(index);
                    content = data;
                    //从桌面打开
                    top.winui.window.open({
                        id: 'editRole',
                        type: 1,
                        title: '编辑客户',
                        content: content,
                        area: ['60vw', '70vh'],
                        offset: ['15vh', '20vw'],
                    });
                    top.winui.window.msg("选择框带联动的,尽情享用", {
                        time: 2000
                    });
                },
                error: function (xml) {
                    layer.close(index);
                    top.winui.window.msg("获取页面失败", {
                        icon: 2,
                        time: 2000
                    });
                    console.log(xml.responseText);
                }
            });
        }
    });
    //表格重载
    function reloadTable() {
        table.reload(tableId, {});
    }

    //打开添加页面
    function addUser() {
        // top.winui.window.msg("自行脑补画面", {
        //     icon: 2,
        //     time: 2000
        // });

        $.ajax({
            type: 'get',
            url: 'http://www.crm.com/insertUser',
            async: true,
            success: function (data) {
                // layer.close(index);
                content = data;
                //从桌面打开
                top.winui.window.open({
                    id: 'addUser',
                    type: 1,
                    title: '新增客户',
                    content: content,
                    area: ['60vw', '70vh'],
                    offset: ['15vh', '20vw']
                });

                // top.winui.window.msg("选择框带联动的,尽情享用", {
                //     time: 2000
                // });
            },
            error: function (xml) {
                layer.close(index);
                top.winui.window.msg("获取页面失败", {
                    icon: 2,
                    time: 2000
                });
                console.log(xml.responseText);
            }
        });
    }
    //删除角色
    function deleteRole(ids, obj) {
        var msg = obj ? '确认删除客户【' + obj.data.user_name + '】吗？' : '确认删除选中数据吗？'
        top.winui.window.confirm(msg, { icon: 3, title: '删除系统客户' }, function (index) {
            layer.close(index);
            //向服务端发送删除指令
            $.ajax({
                url:'http://www.crm.com/userDel?id='+obj.data.user_id,
                type:'get',
                dataType:'json',
                async:false,
                success:function ( json_info ) {
                    if( json_info.status == 1000 ){
                        top.winui.window.msg('删除成功', {
                            icon: 1,
                            time: 2000
                        });
                        obj.del(); //删除对应行（tr）的DOM结构
                        reloadTable();  //直接刷新表格
                    }else{
                        winui.window.msg( json_info.msg );
                    }
                }
            });
            //刷新表格
            // if (obj) {
            //     top.winui.window.msg('删除成功', {
            //         icon: 1,
            //         time: 2000
            //     });
            //     obj.del(); //删除对应行（tr）的DOM结构
            // } else {
            //     top.winui.window.msg('向服务端发送删除指令后刷新表格即可', {
            //         time: 2000
            //     });
            //     reloadTable();  //直接刷新表格
            // }
        });
    }
    //绑定按钮事件
    $('#addUser').on('click', addUser);
    $('#deleteRole').on('click', function () {
        var checkStatus = table.checkStatus(tableId);
        var checkCount = checkStatus.data.length;
        if (checkCount < 1) {
            top.winui.window.msg('请选择一条数据', {
                time: 2000
            });
            return false;
        }
        var ids = '';
        $(checkStatus.data).each(function (index, item) {
            ids += item.id + ',';
        });
        deleteRole(ids);
    });
    $('#reloadTable').on('click', reloadTable);

    exports('rolelist', {});
});
