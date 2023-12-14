<?php
session_start();

// Comprobación de la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bdTarea2";

    try {
        // Establecer conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validación y sanitización de los campos
        $nif = filter_var($_POST['nif'], FILTER_SANITIZE_STRING);
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
        $numexp = filter_var($_POST['numexp'], FILTER_SANITIZE_STRING);

       // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Procesar el archivo aquí
        $imagen_nombre = $_FILES['imagen']['name']; // Nombre original del archivo
        $imagen_tmp = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo

        $carpeta_destino = "uploads/".$imagen_nombre; // Ruta en la que quieres guardar la imagen

        // Mover la imagen a la carpeta de destino
        move_uploaded_file($imagen_tmp, $carpeta_destino);
    } else {
        echo "Error: No se ha seleccionado ningún archivo o ha ocurrido un problema con la carga.";
        exit(); // Detener el script si no se envió un archivo válido
    }



        $nombres = $nombre . ' ' . $apellidos;

    // Preparar la consulta SQL para insertar un nuevo expediente
    $sql = "INSERT INTO Expedientes (numexp, nif, nombres, email, telefono, foto)
            VALUES (:numexp, :nif, :nombres, :email, :telefono, :foto)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':numexp', $numexp);
    $stmt->bindParam(':nif', $nif);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':foto', $carpeta_destino); // Guardamos la ruta de la imagen

        // Ejecutar la declaración
        $stmt->execute();

        // Redireccionar después de insertar
        header("Location: expedientes.php?mensaje=Expediente creado correctamente.&tipo=success");
        exit();
    } catch (PDOException $e) {
        header("Location: expedientes.php?mensaje=Error al crear expediente: " . $e->getMessage() . "&tipo=error");
        exit();
    }

    
} else {
    // Si la solicitud no es POST, redireccionar a alguna página de error o mostrar un mensaje
    header("Location: expedientes.php?mensaje=Error al crear expediente: " . $e->getMessage() . "&tipo=error");
    exit();
}

// Cerrar la conexión
$conn = null;
?>