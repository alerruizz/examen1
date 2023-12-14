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
    <?php include 'navbar.php'?>
    <div class="container mt-5">
        <h1>Lista de estudiantes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Apellido 1</th>
                    <th>Apellido 2</th>
                    <th>Nombre</th>
                    <th>Fotografía</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
              session_start();
              if (isset($_GET['mensaje']) && isset($_GET['tipo'])) {
                $mensaje = $_GET['mensaje'];
                $tipo = $_GET['tipo'];
            
                echo '<div class="alert alert-' . $tipo . '" role="alert">' . $mensaje . '</div>';
            }

                $expedientesPorPagina = 2; // Cantidad de expedientes por página
                if (isset($_GET['pagina'])) {
                   $pagina = $_GET['pagina'];
                } else {
                 $pagina = 1;
                    }

                $offset = ($pagina - 1) * $expedientesPorPagina;

                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "bdTarea2";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "SELECT * FROM expedientes LIMIT :offset, :expedientesPorPagina";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->bindParam(':expedientesPorPagina', $expedientesPorPagina, PDO::PARAM_INT);
                    $stmt->execute();
                
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $nombres = $row['nombres'];
                        $datosNombres = explode(' ', $nombres); // Dividir el campo nombres en un array
                    
                        // Definir variables para apellidos y nombres
                        $apellido1 = isset($datosNombres[0]) ? $datosNombres[0] : '-';
                        $apellido2 = isset($datosNombres[1]) ? $datosNombres[1] : '-';
                        $nombresIndividuales = isset($datosNombres[2]) ? implode(' ', array_slice($datosNombres, 2)) : '-';
                    
                        echo "<tr>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $nombresIndividuales . "</td>";
                        echo "<td>" . $apellido2 . "</td>";
                        echo "<td>" . $apellido1 . "</td>";
                        echo "<td><img src='" . $row['foto'] . "' height='50' width='50' class='img-avatar'></td>";
                        echo "<td>";
                        echo "<a href='#' class='ver-detalle' data-expediente-id='" . $row['ID'] . "'><i class='fas fa-search'></i></a>";
                        echo "<a href='borrar_expediente.php?id=" . $row['ID'] . "'><i class='fas fa-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "<div class='container mt-3'>";
                    echo "<ul class='pagination justify-content-center'>";
                    
                    $pagAnterior = $pagina - 1;
                    $pagSiguiente = $pagina + 1;
                    
                    echo "<li class='page-item'><a class='page-link' href='expedientes.php?pagina=1'>Primera</a></li>";
                    
                    if ($pagina > 1) {
                        echo "<li class='page-item'><a class='page-link' href='expedientes.php?pagina=$pagAnterior'>Anterior</a></li>";
                    }
                    
                    echo "<li class='page-item active'><a class='page-link' href='#'>$pagina</a></li>";
                    
                    // Calculamos el número total de páginas
                    $sqlTotal = "SELECT COUNT(*) AS total FROM expedientes";
                    $stmtTotal = $conn->query($sqlTotal);
                    $totalFilas = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
                    $totalPaginas = ceil($totalFilas / $expedientesPorPagina);
                    
                    if ($pagina < $totalPaginas) {
                        echo "<li class='page-item'><a class='page-link' href='expedientes.php?pagina=$pagSiguiente'>Siguiente</a></li>";
                    }
                    
                    echo "<li class='page-item'><a class='page-link' href='expedientes.php?pagina=$totalPaginas'>Última</a></li>";
                    echo "</ul>";
                    echo "</div>";
                    $conn = null;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }                             
                ?>
            </tbody>
        </table>
        <div class="text-center mt-3">
            <a href="pdfexpedientes.php" target="_blank"><i class="fas fa-print fa-2x"></i></a>
        </div>

    </div>


    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
    $(document).ready(function() {
        // Función para cargar los detalles del expediente en el modal
        $(".ver-detalle").click(function() {
            var expedienteId = $(this).data("expediente-id");

            $.ajax({
                type: "GET",
                url: "detalles_expediente.php", // Archivo PHP para obtener los detalles del expediente
                data: {
                    id: expedienteId
                },
                success: function(response) {
                    $("#detallesExpediente").html(response);
                    $("#detalleExpedienteModal").modal("show");
                }
            });
        });
    });
    </script>
    <!-- Agrega este modal al final de tu archivo expedientes.php -->
    <div class="modal fade" id="detalleExpedienteModal" tabindex="-1" role="dialog"
        aria-labelledby="detalleExpedienteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleExpedienteModalLabel">Detalles del Expediente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los detalles del expediente -->
                    <div id="detallesExpediente"></div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>