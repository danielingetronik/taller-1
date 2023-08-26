<?php

if(isset($_REQUEST["nombre"])){
  $nombre=$_REQUEST["nombre"];
  $num1 =$_REQUEST["num1"];
  $num2 =$_REQUEST["num2"];
}else{
  $nombre='daniel';
}

$options= array(
  'location' 	=>	'http://localhost/taller-1-main/soapserver.php',
  'uri'		=>	'http://localhost/taller-1-main/soapserver.php'
);
$client=new SoapClient(NULL,$options);

if(isset($_REQUEST["nombre"])){
  $data['respuesta']=$client->saludo($nombre.'!!');
  $data['respuesta']=$client->suma($num1.$num2);
  $data['respuesta']=$client->multiplicacion($num1.$num2);
  echo json_encode($data);
}else{
  echo "</br>".$client->saludo($nombre.'!!')."</br>";
echo "resultado de la suma ".$client->suma(3,5); //  8
echo "<br>resultado de la multiplicacion ".$client->multiplicacion(3,5);
echo "<br>resultado de la division ".$client->division(3,5);
}


?>