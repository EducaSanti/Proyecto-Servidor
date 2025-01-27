<?php
session_start();

function autenticar()
{
    $_SESSION["MOSTRAR_AUTENT"] = true;
    header('WWW-Authenticate: Basic realm="Mi dominio"');
    header('HTTP/1.0 401 Unauthorized');
}

function comprobarIntentos(){
    if(!isset($_SESSION["INTENTOS"])){
        $_SESSION["INTENTOS"] = 0;
    }else{
        $_SESSION["INTENTOS"]++;
    }
}

// Arreglar problemas con la tabla, poner una sola para todos los usuarios. Y diferentes roles
function anadirRoles()
{
    // SELECT id_usuario FROM usuarios WHERE rol = 'admin'
    $roles_sql = "SELECT id_usuario FROM usuarios WHERE rol = 'admin';";

    $cont = 0;
    $resultRoles = $GLOBALS['conn']->query($roles_sql);
    while ($filas = $resultRoles->fetch_row()) {
        $_SESSION['roles_usuario'][$cont] = $filas[$cont];
        $cont++;
    }
}

?>