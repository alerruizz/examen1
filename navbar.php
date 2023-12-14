<?php


if (isset($_POST['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>


<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php"><h1>Expedientes</h1></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Listados
            </a>
            <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="expedientes.php">Expedientes</a>
            </div>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Crear nuevo/a
            </a>
            <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="crea_expedientes.php">Expediente</a>

            </div>
        </li>
        </li>
    </ul>
    <form method="post" class="form-inline my-2 my-lg-0" action="">
        <button type="submit" name="cerrar_sesion" class="btn btn-danger my-2 my-sm-0">Cerrar Sesión</button>
    </form>
</div>

        </div>
    </nav>
    