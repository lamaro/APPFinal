<?php
header('Content-Type: text/javascript; charset=UTF-8'); 
$resultados = array();

//$conexion = mysqli_connect("localhost", "root", "", "tpfinal");
//Conector Online
$conexion = mysqli_connect("localhost", "degira_degira", "Degira123", "degira_tpfinal");

mysqli_query($conexion, "SET NAMES 'UTF8'");
