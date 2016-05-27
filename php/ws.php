<?php 
error_reporting(0);
include_once('../lib/nusoap.php');

$nombre = $_POST['nombre'];

function obj2array($obj) {
     $out = array();
  foreach ($obj as $key => $val) {
    switch(true) {
        case is_object($val):
         $out[$key] = obj2array($val);
         break;
      case is_array($val):
         $out[$key] = obj2array($val);
         break;
      default:
        $out[$key] = $val;
    }
  }
  return $out;
}
$objClienteSOAP = new soapclient('http://192.168.1.74:8080/Service.asmx?WSDL');
$parametros=array();
$parametros['nombre']=$nombre;
$objRespuesta = $objClienteSOAP->autores($parametros);
$tes=$objRespuesta->autoresResult->librosPorAutor;
if (count($tes)==0) {
	echo '<h2>No se encontraron resultados</h2>';
}else{
	$var = $objRespuesta->autoresResult->librosPorAutor;//[1];

	if (count($var)==1) {
	echo "<h2>".$var->NombreAutor." </h2>";
	}
	else{
		echo "<h2>".$var[0]->NombreAutor." </h2>";
	}

	for($i=0; $i<count($var); $i++){
		if (count($var)==1) {
			echo "
			<table class='table table-hover'>
		    <th>".$var->Titulo."</th>
		    <tr><td>Precio: ".$var->Precio."</td></tr>
		    <tr><td>Sucursal: ".$var->Sucursal."</td></tr>
		    </table>";
		}
		else{
				echo "
			<table class='table table-hover'>
		    <tr>".$var[$i]->Titulo."</tr>
		    <tr><td>Precio: ".$var[$i]->Precio."</td></tr>
		    <tr><td>Sucursal: ".$var[$i]->Sucursal."</td></tr>
		    </table>";
		}
	}
 }
?>