<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Iniciar sesion</title>
</head>
<body>

    <?php
    include_once("components/navbar.php")
    ?>
    
    <div class="row pt-5">
        <div class="card bg-light pt-4">
            <h1 class="text-center">Inicio de Sesion</h1>
                <!--se realiza el formulario de login agregando-->
                <form class="container" id="frmLogin">
                    <label for="usuario">Email</label>
                    <input type="text" name="usuario" id="usuario" class="form-control">
                    <label for="password">Constraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="btn btn-primary mt-2" id="verOcultar">Ver/ocultar</div>
                   <div class="row pb-5 pt-5" ="center">
                        <input type="submit" value="Acceder" class="btn mt-5 btn-primary col-5" id="btnAcceder">
                        <div class="col-1"></div>
                        <div class="btn btn-primary mt-5  col-5" id="btnRegistrar">Registrar</div>
                    </div>
                   
                </form>
                <div id="mensaje"></div>

        </div>

     </div>
</body>
</html>