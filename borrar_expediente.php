<?php
session_start();


if (isset($_GET['id']) && !empty($_GET['id']) && isset($_POST['eliminar'])) {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bdTarea2";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_GET['id'];
        $sql = "DELETE FROM Expedientes WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: expedientes.php?mensaje=Expediente borrado correctamente.&tipo=success");
        exit();
    } catch (PDOException $e) {
        header("Location: expedientes.php?mensaje=Error al borrar expediente: " . $e->getMessage() . "&tipo=error");
        exit();
    }
}  else {
    // Obtener el nombre del expediente
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bdTarea2";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_GET['id'];
        $sql = "SELECT nombres FROM Expedientes WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $expediente = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Verificacion de borrado.</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Agrega estilos personalizados aquí si es necesario */
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 100px;
    }

    .card {
        border: none;
    }
    </style>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="card-title">Verificacion de borrado.</h1>
                <p class="card-text">¿Estas seguro de que quieres borrar el expediente de <?php echo $expediente['nombres']; ?>?</p>
                <a href="expedientes.php" class="btn btn-success" style="margin:20px">Volver</a>
                <form method="post" action="">
                    <button type="submit" name="eliminar" class="btn btn-danger">ELIMINAR</button>
                </form>
            </div>
        </div>


    </div>


    <a href="index.php"><button type="submit" name="inicio" class="btn btn-primary mt-3 index-btn">Inicio</button></a>


    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>