<?php
include("../admin/conexionBd.php");
include("./autenticacion.php");

session_start();

// Conexion realizada con exito
$conn = conexionBaseDatos("localhost", "programador", "prog", "spareparts");

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SESSION["MOSTRAR_AUTENT"] == false) {
    if ($_SESSION["INTENTOS"] > 3) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
           <!--  <meta http-equiv="refresh" content="5 ; URL=../index.php"> -->
        </head>

        <body>
           <h1>Fallo al iniciar sesion</h1>
        <?php
    } else {
        autenticar();
        ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <!-- <meta http-equiv="refresh" content="5 ; URL=../index.php"> -->
            </head>

            <body>
                <h1>Exito</h1>
              
            <?php
        }
        exit;
    } else {
        // El usuario aportado credenciales
        $idUsuario = $_SERVER['PHP_AUTH_USER'];
        $pwUsuario = $_SERVER['PHP_AUTH_PW'];
        // 2. verificar credenciales
        $sql = "SELECT * FROM usuarios WHERE nombre='$idUsuario';";
        anadirRoles();

        //Como nombre es clave primaria no hace falta comparar los nombres
        $result = $conn->query($sql);
        $compararHash = $result->fetch_assoc();
        if ($result->num_rows > 0 && password_verify($pwUsuario, $compararHash["contrasena"])) {
            $_SESSION['id_usuario'] = $idUsuario;
            // Redireecion ¿Pagina de entrada?
            if ($_SESSION['roles_usuario'][0] == 'administrador') {
                header("Location: ./administrador.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <link rel="stylesheet" href="../estilos/styles.css">
                </head>

                <body>
                    <h1>McDawnald's</h1>
                    <div class="contenido-central">
                        <p class="lema">Las mejores hamburguesas del mercado.</p>
                        <p>Usuario o contraseña invalidas.</p>
                    </div>
                    <footer>
                        <a href='../index.php'>Volver a la pagina del inicio</a>
                        <a href='loginAdmin.php'>Volver a autenticarse</a>
                    </footer>
            <?php
            comprobarIntentos();
            $_SESSION["MOSTRAR_AUTENT"] = false;
        }
    }
            ?>
                </body>

                </html>