<?php
// client
/*



$client=new SoapClient(NULL,$options);

*/

if(isset($_REQUEST["nombre"])){
  $nombre=$_REQUEST["nombre"];
}else{
  $nombre='daniel';
}

$options= array(
  'location' 	=>	'http://localhost/Taller1soap/soapserver.php',
  'uri'		=>	'http://localhost/Taller1soap/soapserver.php'
);
$client=new SoapClient(NULL,$options);

if(isset($_REQUEST["nombre"])){
  $data['respuesta']=$client->saludo($nombre.'!!');
  echo json_encode($data);
}else{
  echo $client->saludo($nombre.'!!')."</br>";
echo "resultado de la suma ".$client->suma(3,5); //  8
echo "<br>resultado de la multiplicacion ".$client->multiplicacion(3,5);
echo "<br>resultado de la division ".$client->division(3,5);
}


?>