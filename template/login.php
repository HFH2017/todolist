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
            <h2>Ultimate Todolist - 登录</h2>
        </div>
    </div>
    <div class="row-fluid">
        <div class="panel d-center" id="login_form">
            <form action="?action=chk_register" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username" id="l_username">账号：</label>
                    <div class="controls">
                        <input type="text" name="id" id="username" placeholder="用户名/邮件地址">
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
                        <input type="submit" class="btn btn-primary" value="登陆">
                        <a href="register.php" class="btn btn-success">花15秒注册</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include(dirname(__FILE__) . '/footer.php'); ?>
</div>


</body>
</html>