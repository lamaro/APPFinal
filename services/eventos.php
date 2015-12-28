<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {  
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
    header('Access-Control-Allow-Credentials: true');  
    header('Access-Control-Max-Age: 86400');   
}  
  
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
}  




include('conector.php');

/* Extrae los valores enviados desde la aplicacion movil */
$usuarioEnviado = $_GET['id'];
$hayrutas=1;
$sqlP = "SELECT * FROM eventos
INNER JOIN usuarioseneventos
ON eventos.idevento = usuarioseneventos.idevento
WHERE usuarioseneventos.idevento = '$usuarioEnviado'";


	$sqlQryP = mysqli_query($conexion,$sqlP);

if(mysqli_num_rows($sqlQryP)>0){   

	while ($r = mysqli_fetch_assoc($sqlQryP)){ // tiene q ser assoc para que no me cree arrays multimedimensional, probar que muestra un echo con array y otro con assoc
		$resultados[] = $r;
	}	
}else{
	$hayrutas=0;
}

$resultados["validacion"] = "neutro";

if( $hayrutas==1 ){
	$resultados["validacion"] = "ok";
}else{
	$resultados["validacion"] = "error";
}

$resultadosJson = json_encode($resultados);

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>