<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Todolist - 数据库系统设计综合实验</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">

</head>
<body>
<div class="container" style="margin-top: 5em;">
    <div class="row-fluid">
        <div class="t-center">
            <h2>Ultimate Todolist - 注册</h2>
        </div>
    </div>
    <div class="row-fluid">
        <div class="panel d-center" id="login_form">

            <div class="well">
                <b>注意：</b>本系统目前仅用于演示数据库系统设计综合实验，过后或作正式用途。目前MySQL相关操作均被记录并可公开查询（页面底部入口），因此请暂勿在本系统输入敏感信息。
            </div>
            <form action="?action=chk_register" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Email：</label>
                    <div class="controls">
                        <input type="text" name="usermail" id="usermail" placeholder="常用邮箱地址">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="username">用户名：</label>
                    <div class="controls">
                        <input type="text" name="username" id="username" placeholder="昵称/用户名">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">密码：</label>
                    <div class="controls">
                        <input type="password" name="password" id="password" placeholder="登陆密码">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-primary" value="注册">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <?php include(dirname(__FILE__) . '/footer.php'); ?>
</div>


</body>
</html>