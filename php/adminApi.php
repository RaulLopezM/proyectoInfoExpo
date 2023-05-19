<?php
require_once('cn.php');


$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    //Update de la tabla--------
    case 'POST':
        $nombre = $_POST['nombre'];
        $ape = $_POST['apellidos'];
        $tel = $_POST['telefono'];
        $correo = $_POST['correo'];
        $fech = $_POST['fecha'];
        $pass = $_POST['password'];
        $cat = $_POST['categoria'];
        $id = $_POST['id'];

        $query = "UPDATE visitantes SET nombre='$nombre',apellidos='$ape',email='$correo',fechaNacimiento='$fech',categoria='$cat',telefono=$tel,password='$pass' WHERE idVisitante=$id";

        if (mysqli_query($cn, $query)) {

            echo 'T';
        } else {

            echo 'F';
        }
        break;

    case 'GET':
        //obtener los visitantes-----------
        if (!isset($_GET['id'])) {

            $result = mysqli_query($cn, "SELECT idVisitante,nombre,apellidos,email,fechaNacimiento,categoria,telefono FROM visitantes ");
            session_start();
            while ($row = mysqli_fetch_array($result)) {
                //Codigo para obtener y mandar  el contenido de la tabla. 
                $id = $row['idVisitante'];
                $nom = $row['nombre'];
                $ape = $row['apellidos'];
                $email = $row['email'];
                $fech = $row['fechaNacimiento'];
                $tel = $row['telefono'];
                $cat = $row['categoria'];

                echo "<tr id='$id'>
                    <td>$id</td>
                    <td>$nom $ape</td>
                    <td>$email</td>
                    <td>$tel</td>
                    <td>$fech</td>
                    <td>$cat</td>";

                if ($_SESSION['ath'] == 'administrador') {
                    echo "
                    <td>
                    <div id='$id' class=' btn editar mb-1' data-id='$id' onclick='editar($id)' data-bs-toggle='modal' data-bs-target='#editarModal'><i class='fas fa-pen'></i> Editar</div>
                    <div id='$id' class=' btn borrar' data-id='$id' onclick='borrar($id)'><i class='fas fa-trash'></i> Eliminar</div>
                    </td>";
                }
                echo "</tr>";
            }
        } else { // obetener un visitante por id--------
            $id = $_GET['id'];

            $query = mysqli_query($cn, "SELECT idVisitante,nombre,apellidos,email,fechaNacimiento,categoria,telefono,password FROM visitantes WHERE idVisitante=$id");

            if ($row = mysqli_fetch_array($query)) {

                $id = $row['idVisitante'];
                $nom = $row['nombre'];
                $ape = $row['apellidos'];
                $email = $row['email'];
                $fech = $row['fechaNacimiento'];
                $tel = $row['telefono'];
                $cat = $row['categoria'];
                $pass = $row['password'];

                //Mandar un json para poder obtener los datos.

                echo json_encode([

                    'id' => $id,
                    'nombre' => $nom,
                    'apellidos' => $ape,
                    'email' => $email,
                    'fecha' => $fech,
                    'telefono' => $tel,
                    'categoria' => $cat,
                    'password' => $pass

                ]);

            }
        }

        break;

    case 'DELETE':

        if (!isset($_REQUEST['id'])) {
            die(
                json_encode(
                    [
                        'status' => '503',
                        'message' => 'No se encontraron los datos ' . $_REQUEST['id']
                    ]
                )
            );
        }
        $id = $_REQUEST['id'];
        $query = mysqli_query($cn, "DELETE FROM visitantes WHERE idVisitante=$id");

        if (mysqli_affected_rows($cn) > 0) {

            echo json_encode([

                'message' => 'Se elimino correctamente',
                'value' => "$id"
            ]);
        } else {
            echo json_encode([
                'message' => 'No se encontró el visitante a eliminar'
            ]);
        }

        break;


    default:
        'sin metodo';
}



?>