<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gruas</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <?= link_tag("plugins/fontawesome-free/css/all.min.css"); ?>

    <?= link_tag("plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>

    <?= link_tag("dist/css/adminlte.min.css?v=3.2.0"); ?>
</head>

<body class="login-page" style="min-height: 466px;">
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Gruas</b></a>
            </div>
            <div class="card-body text-center">
                <p class="login-box-msg">¿Olvidaste tu Contraseña?</p>
                <p>Ingresa un correo electrónico válido y enviaremos un enlace para restablecer tu contraseña.</p>
                <div style="color:red;">
                    <?= validation_list_errors() ?>
                </div>
                <?= form_open("/auth/forgot-password") ?>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Correo" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block ">Enviar</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <?= script_tag("plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
</body>

</html>