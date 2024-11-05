<?php

    session_start();
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/plantilla.css">
    <link rel="stylesheet" href="../public/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/fontawesome/css/all.css">
    <link rel="stylesheet" href="../public/datatable/buttons.dataTables.min.css">
    <title>Help-Desk</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light static-top mb-5 shadow">
    <?php include "alerta.php" ?>
        <div class="container">
            <a class="navbar-brand" href="inicio.php">
                <img src="../public/img/goboico.png" width="35%" alt="Logo Gobo">
            </a>   
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" 
                    aria-expanded="false" aria-label="Toggle navigation">  
            <span class="navbar-toggler-icon"></span>
            </button> 
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="inicio.php">
                        <span class="fas fa-home"></span> Inicio
                    </a>
                </li>
            <?php if($_SESSION['usuario']['rol'] == 1) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="misDispositivos.php">
                        <span class="fas fa-laptop"></span> Mis Dispositivos
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="misReportes.php">
                        <span class="fas fa-file-alt"></span> Mis Reportes
                </a>
                </li>
            <?php } else if($_SESSION['usuario']['rol'] == 2) { ?>
                <!--Administrador-->
                <li class="nav-item active">
                    <a class="nav-link" href="usuarios.php">
                    <span class="fas fa-users"></span> Usuarios
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="asignacion.php">
                        <span class="fas fa-ballot-check"></span> Asignacion
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="reportes.php">
                    <span class="fas fa-file-alt"></span> Reportes
                </a>
                </li>
            <?php } ?>
                <li class="nav-item dropdown">
                    <a style="color:black" class="nav-link dropdown-toggle" href="#" 
                        role="button" data-toggle="dropdown" aria-expanded="false">
                        <span class="fas fa-user"></span> Usuario 
                        <?php echo $_SESSION['usuario']['nombre']; ?>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" 
                        data-toggle="modal" 
                        data-target="#modalActualizarDatosPersonales"
                        onclick="obtenerDatosPersonalesInicio('<?php echo $_SESSION['usuario']['id']; ?>')">
                        <span class="fas fa-user-edit"></span> Editar Datos
                    </a>
                    
                    

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../procesos/login/salir.php">
                    <span class="fas fa-sign-out-alt"></span> Salir
                </a>
                    </div>
                    
                </li>
            </ul>
            </div>
        </div>
    </nav>

   

    <?php 
        include "inicio/modalActualizarDatosPersonales.php";
     
        
    ?>
