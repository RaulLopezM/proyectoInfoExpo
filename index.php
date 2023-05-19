<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- agregamos a los font-awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Iniciar sesion</title>

    <!--Agregamos una imagen de fondo -->
    <style>
        body {
            background-image: url('images/fondo1.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>

<body>
    <!--incluimos un navbar -->
    <?php
    include_once("components/navbar.php")
        ?>

    <div class="container mt-5">
        <div class="card bg-light pt-4">
            <h1 class="text-center fa fa-user"></h1>
            <h1 class="text-center ">Inicio de Sesion</h1>
            <!--se realiza el formulario de login -->
            <form class="container for-floating" id="frmLogin">
                <i class="fas fa-envelope"></i>
                <label>Email</label>
                <input type="text" name="email" id="email" class="form-control">
                <i class="fas fa-lock"></i>
                <label>Constraseña</label>
                <input type="password" name="password" id="password" class="form-control">
                <div class="btn btn-secondary mt-2" id="verOcultar">Ver/ocultar</div>
                <div class="row pb-4 pt-5">
                    <input type="submit" value="Acceder" class="btn mt-4 btn-dark col-3 offset-md-2" id="btnAcceder">
                    <a class="btn btn-dark mt-4 col-3 offset-md-2" id="btnRegistrar" href="registro.php">Registrar</a>
                </div>
            </form>
            <div id="mensaje" class="m-2"></div>

        </div>

    </div>
    <!--Agregamos los js que necesitaremos para el siguiente codigo-->

    <script src="js/jquery-3.7.0.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script>

        $("#btnAcceder").on("click", function () {

            $('#frmLogin').validate({

                rules: {// reglas para el formulario
                    email: {
                        required: true,
                        maxlength: 45,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                }, messages: {// Respectivos mensaje que mostrara 
                    email: {
                        required: "Este campo es obligatorio",
                        maxlength: "Maximo {45} caracteres",
                        email: "favor de verificar tu correo electronico",
                    },
                    password: {
                        required: "Este campo es obligatorio",
                        minlength: "Minimo 8 caracteres",
                    },
                }, errorElement: "span",
                errorClass: "color-rojo col-12",

                submitHandler: function () {

                    var login = $('#frmLogin').serialize();

                    $.ajax({
                        url: "php/servicioVisitantes.php",
                        data: login,
                        type: "GET",

                        success: function (r) {// funcion para mandar una alerta deque hay algo mal en la cuenta ingresada 
                            
                            if (r == 'F') { //alerta en la cual ya mostramos el mensaje 

                                const msg = "<div class='alert alert-danger'><b>Usuario</b> y/o <b>contraseña incorrecta</b></div>"
                                $('#mensaje').show()
                                $("#mensaje").html(msg);
                                setTimeout(function () {
                                    $("#mensaje").hide(6000);
                                }, 3000);

                            }
                            else {//codigo para dirigir al usuario a su respectiva pagin.
                                if (r == 'administrador') {
                                    document.location.href = "admin/"
                                }
                                else {
                                    if (r == 'normal') {
                                        document.location.href = "visitante/"
                                    }
                                }

                            }
                        }
                    });

                }

            });
        });
        //Con este codigo podremos mostrar y ocultar el contenido de la caja de texto para la contraseña
        $("#verOcultar").on("click", function () {
            var estadoPassword = $('#password').attr('type');
            if (estadoPassword == "password") {
                $("#password").attr('type', 'text');
                $('#verOcultar').removeClass("btn-primary").addClass("btn-dark");

            } else {
                $("#password").attr('type', 'password');
                $('#verOcultar').removeClass("btn-dark").addClass("btn-primary");
            }

        });

    </script>
</body>

</html>