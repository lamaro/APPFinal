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

header('Content-Type: text/javascript; charset=UTF-8'); 
$resultados = array();


include('conector.php');


/* Extrae los valores enviados desde la aplicacion movil */
$usuarioEnviado = $_GET['usuario'];
$passwordEnviado = $_GET['password'];

/* revisar existencia del usuario con la contraseña en la bd */
$sqlCmd = "SELECT email, password, idUsuario
FROM usuarios
WHERE email
LIKE '".mysqli_real_escape_string($conexion,$usuarioEnviado)."' 
AND password ='".mysqli_real_escape_string($conexion,$passwordEnviado)."'
LIMIT 1";

//echo $sqlCmd;

$sqlQry = mysqli_query($conexion,$sqlCmd);

if(mysqli_num_rows($sqlQry)>0){

	$login=1;

    //echo "hola";

	$fila = mysqli_fetch_array($sqlQry); //hago esto para poder extraer el id usuario que peciso.
    
	$idUsuario =  $fila["idUsuario"];
    
    $resultados["usuario"] = $fila["idUsuario"];
    


    // Traigo todas las rutas donde se encuentra anotado el usuario.

    $sqlPref = "SELECT * FROM rutas
                    INNER JOIN usuariosenrutas
                    ON rutas.idruta = usuariosenrutas.idruta
                    WHERE usuariosenrutas.idUsuario = '$idUsuario'";
    
    $sqlQryPref = mysqli_query($conexion,$sqlPref);

    while ($pf = mysqli_fetch_assoc($sqlQryPref)){
        $resultados["rutas"][] = $pf; 
    }
    
    /*
    // Traigo lista completa de generos
    $sqlListGeneros = "SELECT * from categoria";
    $sqlQryGeneros = mysqli_query($conexion,$sqlListGeneros);
    while ($ligen = mysqli_fetch_assoc($sqlQryGeneros)){
        $resultados["listageneros"][] = $ligen; 
    }    

    */
    //AGREGAR ACA SI NECESITO MAS DATOS DE UNA, SE GUARDA TODO EN EL VECTOR RESULTADOS UTILIZANDO LO QUE ESTA ADENTRO DE LAS COMILLAS ;)
    
	
}else{
	$login=0;
}
$resultados["validacion"] = "neutro";
if( $login==1 ){
$resultados["validacion"] = "ok";
}else{
$resultados["validacion"] = "error";
}


$resultadosJson = json_encode($resultados, JSON_UNESCAPED_UNICODE);

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>