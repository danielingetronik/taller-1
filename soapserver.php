<?php

// server
class MiPrimerSoap
{
  public function saludo($name)
  {
    return 'Hola, '.$name.'!';
  }
  
  public function suma($num1,$num2)
  {
    return $num1+$num2;
  }

  public function multiplicacion($num1,$num2)
  {
    return $num1*$num2;
  }

  public function division($num1,$num2)
  {
    return $num1/$num2;
  }
}

$options= array('uri'=>'http://localhost/Taller1soap');
$server=new SoapServer(NULL,$options);
$server->setClass('MiPrimerSoap');
$server->handle();



?>