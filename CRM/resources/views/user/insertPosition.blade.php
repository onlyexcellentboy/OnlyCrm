<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>新增职位</legend>
    </fieldset>

    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="">
            <label class="layui-form-label">新增职位</label>
            <div class="layui-input-inline">
                <input type="text" name="position" lay-verify="required" placeholder="请输入职位名称" autocomplete="off" class="layui-input">
            </div>
        </div>

        <button class="layui-btn" lay-submit="" lay-filter="demo1" name="submit">立即提交</button>
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
        $('[name=submit]').click(function () {
            // 获取管理员名称
            var position = $('[name=position]').val();

//            alert( position );return false;
            // 判断名称不为空
            if( position === '' ){
                winui.window.msg( '职位名称不能为空' );
                return false
            }


            $.ajax({
                url:'insertPositionDo',
                data:'position='+position+'&_token='+'{{csrf_token()}}',
                type:'post',
                dataType:'json',
                async:false,
                success:function ( json_info ) {
                    if( json_info.status == 1000 ){
                        msg('添加成功', {
                            icon: 1,
                            time: 2000
                        });
                        winui.window.close('addPosition');
                    }else{
                        winui.window.msg( json_info.msg );
                    }

                }
            });


        })
    });
</script>