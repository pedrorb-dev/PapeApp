<?php
    $opcion = "registrarse";
    
    if(isset($_POST["iniciar_sesion"])) {
        $opcion = "iniciar_sesion";
        formulario($opcion, "Iniciar Sesion");
    } 
    if(isset($_POST["registrarse"])) {
        $opcion = "registrarse";
        formulario($opcion, "Registrarse");
    } 

    function formulario($name, $h1) {
        echo '<h1>'.$h1.'</h1>
        <form action="" method="post">
            <input type="text" name="user" id="user">
            <input type="text" name="pass" id="pass">
            <button type="submit" name = "'.$name.'">Enviar</button>
        </form>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!--<form method="post">
        <button type="submit" name="iniciar_sesion">Iniciar Sesion</button>
        <button type="submit" name="registrarse">Registrarse</button>
    </form>-->

    <button onClick="inicio()">Iniciar Sesion</button>
    <button onClick="registro()">Registrarse</button>

    <div id="registrarse" style="display:none;">

        <h1>Registrarse</h1>
            <form action="" method="post">
                <input type="text" name="user" id="user">
                <input type="text" name="pass" id="pass">
                <button type="submit">Enviar</button>
            </form>
    </div>
    <div id="iniciar_sesion">

        <h1>Iniciar sesion</h1>
        <form action="" method="post">
            <input type="text" name="user" id="user">
            <input type="text" name="pass" id="pass">
            <button type="submit">Enviar</button>
        </form>
    </div>
    <script>
        
        'use strict'

        function inicio() {
            document.getElementById("iniciar_sesion").style.display="block"
            document.getElementById("registrarse").style.display="none"
        }

        function registro() {
            document.getElementById("registrarse").style.display="block"
            document.getElementById("iniciar_sesion").style.display="none"
        }

        
    </script>
    <!--<?php if($opcion == "registrarse"){ ?>
        <h1>Registrarse</h1>
        <form action="" method="post">
            <input type="text" name="user" id="user">
            <input type="text" name="pass" id="pass">
            <button type="submit" name = "envio_registro">Enviar</button>
        </form>
    <?php }?>
    <?php if($opcion == "iniciar_sesion"){ ?>
        <h1>Iniciar Sesion</h1>
        <form action="" method="post">
            <input type="text" name="user" id="user">
            <input type="text" name="pass" id="pass">
            <button type="submit" name = "envio_login">Enviar</button>
        </form>
    <?php }?>-->

</body>
</html> 