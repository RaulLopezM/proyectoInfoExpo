<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Registrar</title>
    <style>
        body {
            background-image: url('images/fondo1.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php
    include_once("components/navbar.php")
        ?>

    <div class="container mt-3">
        <div class="card bg-light pt-4">
            <h1 class="fas fa-user-plus text-center"></h1>
            <h1 class="text-center">Registrar</h1>
            <form class="container" id="frmRegistro">
                <div class="row">
                    <div class="col">
                        <label for="usuario">Nombre(s)</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="col">
                        <label>Apellido/s</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <label>Telefono</label>
                        <input type="number" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="col">
                        <label>Fecha de nacimiento</label>
                        <input type="date" name="fecha" id="fecha" class="form-control">
                    </div>
                </div>

                <label for="">Correo electronico</label>
                <input type="text" name="correo" id="correo" class="form-control">

                <div class="row">
                    <div class="col">
                        <label for="pass">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col">
                        <label for="passC">Confirmar contraseña</label>
                        <input type="password" name="passwordc" id="passwordc" class="form-control">
                    </div>
                </div>

                <label for="categoria" class="text-center d-block mx-auto">Categoria</label>
                <select class="form-select" name="categoria">
                    <option value="" selected>Selecciona</option>
                    <option value="normal" id="normal">Usuario normal</option>
                    <option value="administrador" id="administrador">Administrador</option>
                </select>

                <div class="row pb-1 pt-2">
                    <input type="submit" value="Registrarse" id="btnRegistrar"
                        class="btn btn-dark mt-4 col-2 offset-md-5">
                </div>
            </form>
            <div id="mensaje" class="m-2"></div>
        </div>

    </div>

    <!--Agregamos los js que necesitaremos para el siguiente codigo-->

    <script src="js/jquery-3.7.0.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script>

        $("#btnRegistrar").on("click", function () {

            $('#frmRegistro').validate({

                rules: {// reglas para el formulario
                    nombre: {
                        required: true,
                    },
                    apellidos: {
                        required: true,
                    },
                    telefono: {
                        required: true,
                        maxlength: 10,
                    },
                    fecha: {
                        required: true,
                    },
                    correo: {
                        required: true,
                        maxlength: 45,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                    passwordc: {
                        required: true,
                        minlength: 8,
                        equalTo: '#password',
                    },
                    categoria: {
                        required: true,
                    },
                }, messages: {// Respectivos mensaje que mostrara 
                    nombre: {
                        required: "Ese campo es obligatorio",
                    },
                    apellidos: {
                        required: "Este campo es obligatorio",
                    },
                    telefono: {
                        required: "Este campo es obligatorio",
                        maxlength: "Maximo de numeros {10}",
                    },
                    fecha: {
                        required: "Este campo es obligatorio",
                    },
                    correo: {
                        required: "Este campo es obligatorio.",
                        maxlength: "Maximo {45} caracteres",
                        email: "favor de verificar tu correo electronico",
                    },
                    password: {
                        required: "Este campo es obligatorio",
                        minlength: "Minimo 8 caracteres",
                    },
                    passwordc: {
                        required: "Este campo es obligatorio",
                        minlength: "Minimo 8 caracteres",
                        equalTo: "ingresa la misma contraseña",
                    },
                    categoria: {
                        required: "Selecciona una opcion",
                    },
                }, errorElement: "span",
                errorClass: "color-rojo col-12",

                submitHandler: function () {

                    var register = $('#frmRegistro').serialize();

                    $.ajax({
                        url: "php/servicioVisitantes.php",
                        data: register,
                        type: "POST",

                        success: function (r) {// funcion para mandar una alerta deque hay algo mal en la cuenta ingresada 
                            console.log(r);
                            if (r == 'F') { //alerta en la cual ya mostramos el mensaje 
                                const msg = "<div class='alert alert-danger'><b>El correo ya esta en uso</b></div>"
                                $('#mensaje').show()
                                $("#mensaje").html(msg);
                                setTimeout(function () {
                                    $("#mensaje").hide(6000);
                                }, 3000);

                            }
                            else {

                                document.location.href = "index.php"

                            }
                        }
                    });

                }

            });
        });


    </script>

</body>

</html>