<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
    <link href="Login/css/style.css" rel='stylesheet' type='text/css' />
    <!--webfonts-->
    <link href='http://fonts.useso.com/css?family=PT+Sans:400,700,400italic,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.useso.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
<script>$(document).ready(function(c) {
        $('.close').on('click', function(c){
            $('.login-form').fadeOut('slow', function(c){
                $('.login-form').remove();
            });
        });
    });
</script>
<!--SIGN UP-->
<h1>CRM客户管理系统</h1>
<div class="login-form">
    <div class="close"> </div>
    <div class="head-info">
        <label class="lbl-1"> </label>
        <label class="lbl-2"> </label>
        <label class="lbl-3"> </label>
    </div>
    <div class="clear"> </div>
    <div class="avtar">
        <img src="Login/images/avtar.png" />
    </div>
    <form>
        <input type="text" class="text" value="用户名" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" >
        <div class="key">
            <input type="password" value="" name="psd" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
        </div>
    </form>
    {{--<a href="https://api.weibo.com/oauth2/authorize?client_id=711488263&redirect_uri=http://www.crm.com/wbLogin" name="weibo">微博登录</a>--}}

    <a href="http://188.131.133.134/oauth?client_id=711488263&redirect_uri=http://www.crm.com/elseLogin">其他登录</a>

    <div class="signin">
        <input type="submit" value="登录" name="submit"/>
    </div>
</div>
<div class="copy-rights">
    <p>Copyright &copy; 2015.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></p>
</div>

</body>
</html>

<script src="../../js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">

//    layui.use(['form','layer'], function (form) {
//        var $ = layui.$
//            , msg = winui.window.msg;

        // 登录
        $('[name=submit]').click(function () {

            //获取用户名
            var account = $('.text').val();

            // 判断用户名不为空
            if (account == '') {
//                winui.window.msg('请填写用户名');
                alert( '请填写用户名' );
                return false;
            }

            // 获取密码
            var psd = $('[name=psd]').val();

            // 判断密码不为空
            if( psd == '' ){
                alert( '请输入密码' );
                return false;
            }

            //发送ajax请求
            $.ajax({
               url:'checkLogin',
                type:'post',
                data:'account='+account+'&psd='+psd+'&_token='+'{{csrf_token()}}',
                dataType:'json',
                async:false,
                success:function ( json_info ) {
                    if( json_info.status == 1000 ){
                        alert( json_info );
                        window.location.href = 'index';
                    }else{
                        alert( json_info.msg );
                    }

                }
            });
//
        });


        //微博登录
//        $('[name=weibo]').click(function () {
//            $.ajax({
//                url:'https://api.weibo.com/oauth2/authorize?client_id=711488263&redirect_uri=http://www.crm.com/',
//                type:'get',
//            });
//
//        })

//    });
</script>