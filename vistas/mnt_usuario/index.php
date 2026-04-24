
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title> 
    <link href = "css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="layout">
        <div class="fondo">
            <img src="./img/logo_transparente.png" class="logo">
            <a id="btn-registrarse" onClick="registro()">Registrarse</a> <!--estos botones también pueden ser un formulario para que se carguen diferentes partesd de la página-->
            <a id="btn-login" onClick="inicio()">Iniciar sesión</a>
        </div>
        <div class="container">
            <div id="login-form">
                <h2>Iniciar Sesión</h2>
                <img src="./img/usuarios.png" width="50" height="50">
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
                        <p>No tienes un usuario aún? <a onClick="registro()">Registrate</a></p>
                    </div>      
                </form>
            </div>
            <div id="registro-form">
                <h2>Registrarse</h2>
                <img src="./img/usuarios.png" width="50" height="50">
                <form id="forma-registro" method="POST">
                    <div class="elemento">
                        <i class="bi bi-person"></i>
                        <input type="text" id="usuario" name="usuario" required="true", placeholder="Ususario">
                    </div>
                    <div class="elemento">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="contraseña" name="contraseña" required="true" placeholder="Contraseña">
                    </div>
                    <div class="elemento">
                        <input type="submit" value="Registrarse" name="registrarse" id="registrarse">
                    </div>
                    <div class="elemento">
                    </div>      
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="mnt_usuario.js"></script>
</body>

<script>
        
        'use strict'

        function inicio() {
            document.getElementById("login-form").style.display="block"
            document.getElementById("registro-form").style.display="none"
            document.getElementById("btn-login").style.backgroundColor="rgb(24, 76, 82)"
            document.getElementById("btn-registrarse").style.backgroundColor=" rgb(41, 106, 115)"
        }

        function registro() {
            document.getElementById("registro-form").style.display="block"
            document.getElementById("login-form").style.display="none"
            document.getElementById("btn-login").style.backgroundColor= "rgb(41, 106, 115)"
            document.getElementById("btn-registrarse").style.backgroundColor= "rgb(24, 76, 82)"
        }

        
    </script>

</html>