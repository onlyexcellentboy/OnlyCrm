<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>新增客户</legend>
    </fieldset>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="">
            <label class="layui-form-label">客户名称</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_account" lay-verify="required" placeholder="请输入客户名称" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">详细地址</label>
            <div class="layui-input-inline">
                <select lay-filter="selected">
                    <option value="">请选择省</option>
                    @foreach( $area as $k => $v )
                    <option value="{{$v['id']}}">{{$v['area_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline">
                <select lay-filter="city" name="city">
                    <option value="">请选择市</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="area">
                    <option value="">请选择县/区</option>
                </select>
            </div>
        </div>


        <div class="layui-form-item" style="">
            <label class="layui-form-label">联系人</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_psd" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">职位</label>
            <div class="layui-input-inline">
                <select name="quiz4">
                    <option value="">请选择</option>
                    @foreach( $position as $k => $v )
                    <option value="{{$v['select_id']}}">{{$v['select_name']}}</option>
                    @endforeach
                </select>
            </div>

            <button class="layui-btn" lay-filter="demo2" name="insert">新增</button>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">联系电话</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_tel" lay-verify="required" autocomplete="off" class="layui-input" placeholder="联系人联系电话"/>
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_tel" lay-verify="required" autocomplete="off" class="layui-input" placeholder="客户手机号"/>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">产品分类</label>
            <div class="layui-input-inline">
                <select name="quiz1">
                    <option value="">请选择</option>
                    <option value="浙江" selected="">浙江省</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="quiz2">
                    <option value="">请选择</option>
                    <option value="杭州">杭州</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">客户类型</label>
            <div class="layui-input-inline">
                <select name="quiz4">
                    <option value="">请选择</option>
                    @foreach( $position as $k => $v )
                        <option value="{{$v['select_id']}}">{{$v['select_name']}}</option>
                    @endforeach
                </select>
            </div>

            <button class="layui-btn" lay-filter="demo2" name="insert">新增</button>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">客户来源</label>
            <div class="layui-input-inline">
                <select name="quiz4">
                    <option value="">请选择</option>
                    @foreach( $position as $k => $v )
                        <option value="{{$v['select_id']}}">{{$v['select_name']}}</option>
                    @endforeach
                </select>
            </div>

            <button class="layui-btn" lay-filter="demo2" name="insert">新增</button>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">客户级别</label>
            <div class="layui-input-inline">
                <select name="quiz4">
                    <option value="">请选择</option>
                    @foreach( $position as $k => $v )
                        <option value="{{$v['select_id']}}">{{$v['select_name']}}</option>
                    @endforeach
                </select>
            </div>

            <button class="layui-btn" lay-filter="demo2" name="insert">新增</button>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">备注其他</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>

        <button class="layui-btn" lay-submit="" lay-filter="demo1" name="play">立即提交</button>
    </div>
</div>

<script src="../../js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
    layui.use(['form','layer'], function (form) {

//        以下为系统自带
        var $ = layui.$
            , msg = winui.window.msg;

        form.render();
        form.on('switch(isNecessary)', function (data) {
            $(data.elem).val(data.elem.checked);
        });
        form.on('submit(formAddMenu)', function (data) {
            //表单验证
            if (winui.verifyForm(data.elem)) {
                layui.$.ajax({
                    type: 'get',
                    url: 'json/resfailed.json',
                    async: false,
                    data: data.field,
                    dataType: 'json',
                    success: function (json) {
                        if (json.isSucceed) {
                            msg('添加成功');
                        } else {
                            msg(json.message)
                        }
                        winui.window.close('addMenu');
                    },
                    error: function (xml) {
                        msg('添加失败');
                        console.log(xml.responseText);
                    }
                });
            }
            return false;
        });

//      以上为系统自带

        // 三级联动   ----  市
        form.on('select(selected)', function (data) {
//            console.log(data);
            // 选择的id
            var id = data.value;

            // 发送ajax请求将id传给php
            $.ajax({
                url: 'http://www.crm.com/areaUser',
                data: 'id=' + id + '&_token=' + '{{csrf_token()}}',
                type: 'get',
                dataType: 'json',
                success: function (json_info) {
//                    console.log( json_info.data.type );

                    var option = '<option value="0">请选择市</option>';

                    $.each(json_info.data, function (k, v) {
//                        console.log( v );

                        option += '<option value="' + v.id + '">' + v.area_name + '</option>';
                    });

                    // 替换数据
                    $('[name=city]').html( option );
//console.log( option );
                    // 渲染区选项
                    $('[name=area]').html( '<option value="0">请选择县/区</option>' );

                    // 重载下拉框
                    form.render( 'select' );

                }
            });


        });


        // 三级联动   ----  区
        form.on('select(city)', function (data) {
//            console.log(data);
            // 选择的id
            var id = data.value;

            // 发送ajax请求将id传给php
            $.ajax({
                url: 'http://www.crm.com/areaUser',
                data: 'id=' + id + '&_token=' + '{{csrf_token()}}',
                type: 'get',
                dataType: 'json',
                success: function (json_info) {
//                    console.log( json_info.data.type );

                    var option = '<option value="0">请选择县/区</option>';

                    $.each(json_info.data, function (k, v) {
//                        console.log( v );

                        option += '<option value="' + v.id + '">' + v.area_name + '</option>';
                    });

                        // 替换数据
                        $('[name=area]').html( option );

                        // 重载下拉框
                        form.render( 'select' );
                    }


            });


        });

        //新增职位
        $('[name=insert]').click(function () {

            // 打开新增页面
            $.ajax({
                type: 'get',
                url: 'http://www.crm.com/insertPosition',
                async: true,
                success: function (data) {
                    // layer.close(index);
                    content = data;
                    //从桌面打开
                    top.winui.window.open({
                        id: 'addPosition',
                        type: 1,
                        title: '新增职位',
                        content: content,
                        area: ['30vw', '25vh'],   //  vw设置宽  vh设置高
                        offset: ['40vh', '35vw']  //  vh设置上下间距  vw设置左右间距
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


        });


        // 提交数据
        $('[name=play]').click(function () {
            // 获取管理员名称
            var account = $('[name=admin_account]').val();

            // 判断名称不为空
            if( account === '' ){
                winui.window.msg( '管理员名称不能为空' );
                return false
            }

            // 获取密码
            var psd = $('[name=admin_psd]').val();

            // 判断密码不为空
            if( psd === '' ){
                winui.window.msg( '管理员密码不能为空' );
                return false;
            }

            // 判断密码长度  ---- 未完结
//            if( strlen(psd) <= 6 ){
//                winui.window.msg( '管理员密码不能少于6位' );
//                return false;
//            }

            // 获取确认密码
            var confirm_psd = $('[name=confirm_psd]').val();

            // 判断确认密码不为空
            if( confirm_psd === '' ){
                winui.window.msg( '确认密码不能为空' );
                return false;
            }

            //判断密码和确认密码一致
            if( psd != confirm_psd ){
                winui.window.msg( '确认密码必须和密码一致' );
                return false;
            }

            // 获取手机号
            var tel = $('[name=admin_tel]').val();

            // 判断手机号不为空
            if( tel === '' ){
                winui.window.msg( '手机号码不能为空' );
                return false;
            }


            // 获取是否实名
            var is_real = $('[name=is_real]:checked').val();


            // 获取是否启用
            var show = $('[name=show]:checked').val();

            $.ajax({
                url:'insertAdminDo',
                data:'account='+account+'&psd='+psd+'&confirm_psd='+confirm_psd+'&tel='+tel+'&is_real='+is_real+'&show='+show+'&_token='+'{{csrf_token()}}',
                type:'post',
                dataType:'json',
                async:false,
                success:function ( json_info ) {
                    if( json_info.status == 1000 ){
                        winui.window.msg( '添加成功了，可以登录了' );
                    }else{
                        winui.window.msg( json_info.msg );
                    }

                }
            });


        });
    });




</script>