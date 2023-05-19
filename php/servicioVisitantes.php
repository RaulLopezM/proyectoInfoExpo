<?php
require_once('cn.php');

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'POST':
        $nombre = $_POST['nombre'];
        $ape = $_POST['apellidos'];
        $tel = $_POST['telefono'];
        $fech = $_POST['fecha'];
        $email = $_POST['correo'];
        $pass = $_POST['password'];
        $cat = $_POST['categoria'];

        $query = "INSERT INTO visitantes (nombre,apellidos,email,fechaNacimiento,categoria,telefono,password) values ('$nombre','$ape','$email','$fech','$cat',$tel,'$pass')";
        if (mysqli_query($cn, $query)) {
            echo 'T';

        } else {
            echo 'F';
        }

        break;

    case 'GET':
        $email = $_GET['email'];
        $pass = $_GET['password'];
        $query = mysqli_query($cn, "SELECT email,password,categoria FROM visitantes WHERE email ='$email' AND password ='$pass'");

        if (mysqli_num_rows($query) == 1) {
            session_start();
            $row = mysqli_fetch_assoc($query);
            $categoria = $row['categoria'];
            $_SESSION['ath'] = $categoria;
            echo $categoria;
        } else {
            echo 'F';
        }

        break;

    default:
        'sin metodo';
}

?>