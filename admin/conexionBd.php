<?php
/* $servername = "localhost";
$username = "root";
$password = "";
$dbname = "spareparts"; */


//Funcion para conectar con la base de datos devuelve $conn para utilizarlo para consultas a dicha base
function conexionBaseDatos($servername, $username, $password, $dbname)
{
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión Fallida: " . $conn->connect_error);
    }

    return $conn;
}

?>
