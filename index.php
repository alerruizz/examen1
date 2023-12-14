<?php
session_start();
    
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bdTarea2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '<div class="alert alert-success" role="alert">Conexión a la base de datos establecida correctamente.</div>';
} catch(PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">Error al conectar a la base de datos: ' . $e->getMessage() . '</div>';
}
?>


    
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Expedientes</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="container mt-5">
        <h1>Bienvenido.</h1>
        <h2>Por favor selecciona una opción del menú superior.</h2>


    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
