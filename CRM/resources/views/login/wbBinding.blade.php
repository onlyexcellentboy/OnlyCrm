<link href="../../lib/layui/css/layui.css" rel="stylesheet" />
<link href="../../lib/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" />
<link href="../../lib/winui/css/winui.css" rel="stylesheet" />
<script src="../../lib/layui/layui.js"></script>
<ins class="adsbygoogle" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>

<div  class="layui-anim layui-anim-rotate layui-anim-up" data-anim="layui-anim-up" style="text-align: center">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>绑定账号</legend>
    </fieldset>

    <div class="layui-form layui-form-pane">
        <div class="layui-form-item" style="margin-left: 40%">
            <div class="layui-input-inline">
                <input type="hidden" name="wb_id" lay-verify="required" readonly value="{{$id}}" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item" style="margin-left: 40%">
            <label class="layui-form-label">微博昵称</label>
            <div class="layui-input-inline">
                <input type="text" name="wb_name" lay-verify="required" readonly value="{{$name}}" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item" style="margin-left: 40%">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" name="username" lay-verify="required" placeholder="请输入您的用户名" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item" style="margin-left: 40%">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="psd" lay-verify="required" placeholder="请输入您的密码" autocomplete="off" class="layui-input">
            </div>
        </div>

        <button class="layui-btn" lay-submit="" lay-filter="demo1" name="binding">立即绑定</button>
    </div>
</div>

<script src="../../js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
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
        {{--$('[name=]').click(function () {--}}
            {{--// 获取管理员名称--}}
            {{--var id = $('[name=wb_name]').html();--}}

            {{--alert( id );return false;--}}
            {{--// 判断名称不为空--}}
            {{--if( from === '' ){--}}
                {{--winui.window.msg( '客户来源不能为空' );--}}
                {{--return false--}}
            {{--}--}}


            {{--$.ajax({--}}
                {{--url:'insertFromDo',--}}
                {{--data:'from='+from+'&_token='+'{{csrf_token()}}',--}}
                {{--type:'post',--}}
                {{--dataType:'json',--}}
                {{--async:false,--}}
                {{--success:function ( json_info ) {--}}
                    {{--if( json_info.status == 1000 ){--}}
                        {{--msg('添加成功', {--}}
                            {{--icon: 1,--}}
                            {{--time: 2000--}}
                        {{--});--}}
                        {{--winui.window.close('addFrom');--}}
                    {{--}else{--}}
                        {{--winui.window.msg( json_info.msg );--}}
                    {{--}--}}

                {{--}--}}
            {{--});--}}


        {{--});--}}

        // 提交数据
        form.on('submit(demo1)', function(data){
//            console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}

            // 表单数据
            var info = data.field;

            $.ajax({
               url:'wbBindingDo',
                type:'post',
                data:'wb_id='+info.wb_id+'&wb_name='+info.wb_name+'&username='+info.username+'&psd='+info.psd+'&_token='+'{{csrf_token()}}',
                dataType:'json',
                async:false,
                success:function ( json_info ) {

                    if( json_info.status == 1000 ){
                        layui.layer.msg( '绑定成功' );
                    }else{
                        layui.layer.msg( json_info.msg );
                    }
                }
            });
        });
    });
</script>