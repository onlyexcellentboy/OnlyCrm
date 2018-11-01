<link href="../../lib/layui/css/layui.css" rel="stylesheet" />
<link href="../../lib/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" />
<link href="../../lib/winui/css/winui.css" rel="stylesheet" />
<script src="../../lib/layui/layui.js"></script>
<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up" style="text-align: center">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>登录</legend>
    </fieldset>

    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="margin-left: 40%">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline">
                <input type="text" name="account" lay-verify="" placeholder="请输入账号" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item" style="margin-left: 40%">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="psd" lay-verify="" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>

        <button class="layui-btn" lay-submit="" lay-filter="demo1" name="start">立即提交</button>
    </div>
</div>

<script src="../../js/jquery-3.2.1.min.js"></script>

<script>
    layui.use(['form','layer'], function (form) {
//        以下为系统自带
//        var $ = layui.$
//            , msg = winui.window.msg;

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
                            msg(json.msg)
                        }

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
        $('[name=start]').click(function () {
            // 获取账号
            var account = $('[name=account]').val();

//            alert( account );return false;
            // 判断名称不为空
            if( account === '' ){
                layui.layer.msg( '请输入您的账号' );
                return false
            }


            // 获取密码
            var psd = $('[name=psd]').val();

//            alert( position );return false;
            // 判断名称不为空
            if( psd === '' ){
                layui.layer.msg( '请输入您的密码' );
                return false
            }

//            alert( psd );return false;

            $.ajax({
                url:'checkLogin',
                data:'account='+account+'&psd='+psd+'&_token='+'{{csrf_token()}}',
                type:'post',
                dataType:'json',
                async:false,
                success:function ( json_info ) {
                    if( json_info.status == 1000 ){

                       window.location.href = 'http://www.crm.com/apiOauth';
                    }else{
                        layui.layer.msg( json_info.msg );
                    }

                }
            });


        })
    });
</script>