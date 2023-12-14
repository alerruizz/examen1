<?php
// detalles_expediente.php

// Verificar si se ha recibido el ID del expediente
if (isset($_GET['id'])) {
    $expedienteId = $_GET['id'];

    // Realizar la conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bdTarea2";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL para obtener los detalles del expediente
        $sql = "SELECT * FROM Expedientes WHERE ID = :expedienteId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':expedienteId', $expedienteId);
        $stmt->execute();

        // Obtener los datos del expediente
        $expediente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mostrar los detalles del expediente
        if ($expediente) {
            echo "<p>ID: " . $expediente['ID'] . "</p>";
            echo "<p><b>Número de Expediente " . $expediente['numexp'] . "</b></p>";
            echo "<p>Nombre:  " . $expediente['nombres'] . "</p>";
            echo "<p>Email:  " . $expediente['email'] . "</p>";
            echo "<p>Teléfono:  " . $expediente['telefono'] . "</p>";
            echo "<p>Foto: <img src='" . $expediente['foto'] . "' height='70' width='70'></p>";
            // Agrega más detalles según la estructura de tu tabla Expedientes
        } else {
            echo "Expediente no encontrado.";
        }

        // Cerrar la conexión
        $conn = null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID de expediente no proporcionado.";
}
?>