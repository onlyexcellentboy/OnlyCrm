<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>添加管理员</legend>
    </fieldset>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="">
            <label class="layui-form-label">管理员名称</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_account" lay-verify="required" placeholder="请输入管理员名称" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">登录密码</label>
            <div class="layui-input-inline">
                <input type="password" name="admin_psd" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-inline">
                <input type="password" name="confirm_psd" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_tel" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">是否已实名</label>
            <div class="layui-input-block" style="margin-right: 65%;">
                <input type="radio" name="is_real" value="1" title="是" checked="">
                <input type="radio" name="is_real" value="0" title="否">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">是否启用</label>
            <div class="layui-input-block" style="margin-right: 65%;">
                <input type="radio" name="show" value="1" title="是" checked="">
                <input type="radio" name="show" value="0" title="否">
            </div>
        </div>
        <button class="layui-btn" lay-submit="" lay-filter="demo1" name="play">立即提交</button>
    </div>
</div>

<script src="../../js/jquery-3.2.1.min.js"></script>

<script>
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

        // 提交数据
        $('.layui-btn').click(function () {
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
                data:'account='+account+'&psd='+psd+'&confirm_psd='+confirm_psd+'&tel='+tel+'&is_real='+is_real+'&_token='+'{{csrf_token()}}',
                type:'post',
                dataType:'json',
                async:false,
                success:function ( json_info ) {

                }
            });


        })
    });
</script>