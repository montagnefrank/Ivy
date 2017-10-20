<div class="container">
    <div  class="login-container">
        <video class="fullscreen-bg__video" autoplay="" muted="" loop="">
            <source type="video/mp4" src="<?php echo base_url() ?>public/background/loop1.mp4"/>
        </video>
        <div class="login-box animated fadeInDown">
            <div class="login-logo">
                <img id="logo_login" src="<?php echo base_url() ?>public/images/logo2white.png" />
            </div>
            <div id="loginbody" class="login-body">
                <div class="login-title"><strong>Bienvenido</strong>, Estábamos esperando por ti</div>
                <?php
                $attributes = array('id' => 'login-form', 'name' => 'login-form', 'method' => "post", 'class' => 'text-left form-horizontal', 'autocomplete' => "off");
                echo form_open('admin/inicio/sesion/iniciar', $attributes);
                ?>

                <?php
                if (isset($error_message)) {
                    echo '<div class="login-form-main-message show error">' . $error_message . '</div>';
                }
                //echo validation_errors();

                if (isset($logout_message)) {
                    echo '<div class="login-form-main-message show success">' . $logout_message . '</div>';
                }

                if (isset($message_display)) {
                    echo '<div class="login-form-main-message show success">' . $message_display . '</div>';
                }
                ?>

                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" id="contrasena"/>
                    </div>
                </div>
                <button type="submit" name="go" class="login-button btn btn-primary">Ingresar <i class="fa fa-chevron-right"></i></button>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="login-footer">
            
        </div>
    </div>
</div>
</div>

<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<script src="<?php echo base_url() ?>public/js/admin/login.js"></script>