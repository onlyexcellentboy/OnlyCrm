<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>新增订单</legend>
    </fieldset>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="">
            <label class="layui-form-label">订单名称</label>
            <div class="layui-input-inline">
                <input type="text" name="order_name" lay-verify="required" placeholder="请输入订单名称" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">订单联系人</label>
            <div class="layui-input-inline">
                <select lay-verify="required" name="admin_id" disabled>
                    <option value="">请选择</option>
                    @foreach( $user_info as $k => $v )
                        <option value="{{$v['admin_id']}}" selected>{{$v['admin_name']}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">订单预付款</label>
            <div class="layui-input-inline">
                <input type="text" name="imprest" lay-verify="required" placeholder="请输入订单预付款" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">下单日期</label>
            <div class="layui-input-inline">
                <input type="datetime-local" name="create_time" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">交单日期</label>
            <div class="layui-input-inline">
                <input type="datetime-local" name="submit_time" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item" style="">
            <label class="layui-form-label">是否完成</label>
            <div class="layui-input-block" style="margin-right: 65%;">
                <input type="radio" name="status" value="1" title="是" checked="">
                <input type="radio" name="status" value="2" title="否">
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
            // 获取订单名称
            var order_name = $('[name=order_name]').val();

            // 判断名称不为空
            if( order_name === '' ){
                winui.window.msg( '请输入订单名称' );
                return false
            }

            // 获取订单联系人
            var admin_id = $('[name=admin_id]').val();

//            alert( admin_id );return;
            // 判断订单联系人不为空
            if( admin_id === '' ){
                winui.window.msg( '请选择订单联系人' );
                return false;
            }


            // 获取预付款
            var imprest = $('[name=imprest]').val();

            // 判断预付款不为空
            if( imprest === '' ){
                winui.window.msg( '请输入预付款金额' );
                return false;
            }


            // 获取下单日期
            var create_time = $('[name=create_time]').val();

            // 判断下单不为空
            if( create_time === '' ){
                winui.window.msg( '请选择下单日期' );
                return false;
            }


            // 获取交单日期
            var submit_time = $('[name=submit_time]').val();

            // 判断交单不为空
            if( submit_time === '' ){
                winui.window.msg( '请选择交单日期' );
                return false;
            }

            // 获取是否完成
            var status = $('[name=status]:checked').val();

            $.ajax({
                url:'insertOrderDo',
                data:'order_name='+order_name+'&admin_id='+admin_id+'&imprest='+imprest+'&create_time='+create_time+'&submit_time='+submit_time+'&status='+status+'&_token='+'{{csrf_token()}}',
                type:'post',
                dataType:'json',
                async:false,
                success:function ( json_info ) {

                    if( json_info.status == 1000 ){
                        winui.window.msg( '订单添加成功' );
                        return true;
                    }else{
                        winui.window.msg( json_info.msg );
                        return false;
                    }

                }
            });


        })
    });
</script>