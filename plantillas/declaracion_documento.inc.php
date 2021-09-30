<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
    if (!isset($titulo) || empty($titulo)) {
        $titulo = 'Dashboard';
    }
    echo "<title>$titulo</title>";
    ?>
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/api.ico">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?php echo RUTA_CSS;  ?>bootstrap-plantilla.css" rel="stylesheet">
    <link href="<?php echo RUTA_CSS;  ?>estilos.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">