<?php require_once("../php/guard.php");
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Inicio</title>
    <style>
        body {
            background-image: url('../images/fondo_tabla.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<!-- creamos un atributo categoria que almacena la sesion-->

<body categoria="<?php echo $_SESSION['ath']; ?>">
    <?php
    include_once("navbar.php");
    echo $_SESSION['ath'];
    ?>

    <!-- creacion de la tabla de visitantes-->
    <div class="container">
        <div class="card bg-light ">
            <h1 class="text-center mt-4 mb-5">Listado de visitantes(Evento)</h1>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Fecha de nacimiento</th>
                        <th>Categoria</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>

    </div>

    <!--Modal para poder actualizar-->
    <div id="editarModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="container" id="frmEditar">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
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

                        </div>

                        <label for="categoria" class="text-center d-block mx-auto">Categoria</label>
                        <select class="form-select" name="categoria" id="categoria">
                            <option value="" selected>Selecciona</option>
                            <option value="normal" id="normal">Usuario normal</option>
                            <option value="administrador" id="administrador">Administrador</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cerrar" data-bs-dismiss="modal">Close</button>
                    <input form="frmEditar" type="submit" id="btnActualizar" data-bs-dismiss="modal" value="Editar"
                        class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>

    <!-- con el siguiente script recibiremos el contenido de la tabla-->
    <script src="../js/jquery-3.7.0.js"></script>
    <script src="../js/jquery.dataTables.js"></script>
    <script src="../js/jquery.validate.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>

    <script>
        let tabla = $("table").DataTable();
        $(document).ready(function () {

            //codigo para verificar el tipo de usuario  que solo pueda estar en su propia locacion
            var categoria = $('body').attr('categoria');

            if (categoria == "normal") {
                document.location.href = "../"
            }

            $.ajax({
                type: "GET",
                url: "../php/adminApi.php",
                success: function (r) {
                    console.log(r);
                    var contenido = $(r);


                    tabla.clear().draw();
                    tabla.rows.add(contenido).draw();
                }
            });
        });

        function borrar(id) {
            // Mostrar ventana de confirmación
            if (confirm("¿Estás seguro de que quieres eliminar a este visitante?")) {
                // El usuario ha confirmado, proceder con la eliminación
                $.ajax({
                    url: '../php/adminApi.php?id=' + id,
                    type: 'DELETE',
                    success: function (e) {
                        console.log(this.data);
                        console.log(e);
                        $(`#${id}`).remove().draw();

                    }
                });
            } else {
                // El usuario ha cancelado, no hacer nada.
            }
        }

        function editar(id) {
            $.ajax({
                type: "GET",
                url: "../php/adminApi.php?id=" + id,

                success: function (r) {
                    
                    var contenido = JSON.parse(r);

                    $('#id').val(contenido.id);
                    $('#nombre').val(contenido.nombre);
                    $('#apellidos').val(contenido.apellidos);
                    $('#correo').val(contenido.email);
                    $('#fecha').val(contenido.fecha);
                    $('#telefono').val(contenido.telefono);
                    $('#categoria').val(contenido.categoria);
                    $('#password').val(contenido.password);

                }
            });
            $("#btnActualizar").on("click", function () {
                $('#frmEditar').validate({

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
                        categoria: {
                            required: "Selecciona una opcion",
                        },
                    }, errorElement: "span",
                    errorClass: "color-rojo col-12",

                    submitHandler: function () {

                        var update = $('#frmEditar').serialize();

                        $.ajax({
                            url: "../php/adminApi.php?id=" + id,
                            type: "POST",
                            data: update,

                            success: function (r) {
                                $.ajax({
                                    type: "GET",
                                    url: "../php/adminApi.php",
                                    success: function (r) {
                                        console.log(r);
                                        var contenido = $(r);

                                        tabla.clear().draw();
                                        tabla.rows.add(contenido).draw();
                                    }
                                });
                            }

                        });

                    }

                });
            });

        }

    </script>
</body>

</html>