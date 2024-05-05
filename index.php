<?php
    session_name("agrocacao");
    session_start();
if(isset($_SESSION["us_tipo"])){
    header("Location: views/Home/admin_catalogo.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9cce3d02ed.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/img/logo-header.png">
    <title>Agrocacao</title>
</head>
<body>
<div class="logo">
        <h1>Acceder a tu cuenta</h1>
        <!-- include  cuantas veces seas -->
        <form action="controllers/login.php" method="post">
            <!-- user name -->
            <label for="username"><i class="fa-solid fa-user"></i> Usuario</label>
            <input type="text" placeholder="Ingresar Usuario" name="usuario">
            <!-- pasword -->
            <label for="pasword"><i class="fa-solid fa-key"></i> Contraseña</label>
            <input type="password" placeholder="Ingresar Contraseña" name="password">

            <!-- boton -->
            <input type="submit" value="INICIO" name="btningresar">
            
            <!-- <a href="">¿Has Olvidado tu Contraseña?</a> -->
            
        </form>

</div>
 
</body>
</html>

