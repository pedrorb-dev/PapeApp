<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title> 
    <link href = "css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="layout">
        <div class="fondo">
            <img src="/img/logo_transparente.png" class="logo">
            <a>Registrarse</a> <!--estos botones también pueden ser un formulario para que se carguen diferentes partesd de la página-->
            <a>Iniciar sesión</a>
        </div>
        <div class="container">
            <h2>Iniciar Sesión</h2>
            <?php
                require_once("../config/Conexion.php");
                require_once("../modelos/Usuarios.php");
            ?>
            <img src="/img/usuarios.png" width="50" height="50">
            <form id="forma" method="POST">
                <div class="elemento">
                    <i class="bi bi-person"></i>
                    <input type="text" id="usuario" name="usuario" required="true", placeholder="Ususario">
                </div>
                <div class="elemento">
                    <i class="bi bi-lock"></i>
                    <input type="password" id="contraseña" name="contraseña" required="true" placeholder="Contraseña">
                </div>
                <div class="elemento">
                    <input type="submit" value="Ingresar" name="ingresar" id="ingresar">
                </div>
                <div class="elemento">
                    <p>No tienes un usuario aún? <a>Registrate<a></p>
                </div>      
            </form>
        </div>
    </div>
</body>
</html>
</html>