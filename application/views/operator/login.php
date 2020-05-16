<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo base_url();?>"><span class="fa fa-users"></span> <b>Обработка</b> жалоб</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Авторизация в системе</p>
            <form id="form_login" action="<?php echo base_url();?>login" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="login" class="form-control" maxlength="100" placeholder="Логин">
                    <span class="fa fa-user-circle form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Пароль">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="checkbox icheck error"></div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button id="bt-login" type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->