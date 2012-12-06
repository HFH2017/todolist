<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午8:16
 * To change this template use File | Settings | File Templates.
 */?>
<div class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="navbar-inner">
        <ul class="nav">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?=$user['user_name']?>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">修改密码</a></li>
                    <li class="divider"></li>
                    <li>退出登录</li>

                </ul>
            </li>
        </ul>
        <a class="btn"><?=$user['user_name']?></a>
    </div>
</div>