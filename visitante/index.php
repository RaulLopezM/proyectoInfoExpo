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
        body{
            background-image: url('../images/fondo_tabla.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body categoria="<?php echo $_SESSION['ath']; ?>">
    <?php
    include_once("../admin/navbar.php");
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

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>

    </div>
    <!-- con el siguiente script recibiremos el contenido de la tabla-->
    <script src="../js/jquery-3.7.0.js"></script>
    <script src="../js/jquery.dataTables.js"></script>
    <script>

        $(document).ready(function () {
            //codigo para verificar el tipo de usuario  que solo pueda estar en su propia locacion
            var categoria = $('body').attr('categoria');

            if (categoria == "administrador") {
                document.location.href = "../"
            }

            $.ajax({
                type: "GET",
                url: "../php/adminApi.php",
                success: function (r) {
                    console.log(r);
                    var contenido = $(r);

                    let tabla = $("table").DataTable();

                    tabla.clear().draw();
                    tabla.rows.add(contenido).draw();
                }
            });
        });

    </script>
</body>

</html>