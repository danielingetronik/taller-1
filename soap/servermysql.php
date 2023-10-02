<?php

    require_once("nusoap.php");
    $namespace = "http://localhost/soap";
    $server = new soap_server();
    $server->configureWSDL("WSDLTST", $namespace);
    $server->soap_defencoding = 'UTF-8';
    $server->wsdl->schemaTargetNamespace = $namespace;  
    
    function creaContacto($nombre, $direccion, $apellidos){

            require_once("conexion.php");
            $conn = mysqli_connect($servername, $username, $password, $dbname)or die("Error de conexión con la base de datos");
            $sql = "INSERT INTO escritor (nombre, direccion, apellidos) VALUES ('".$nombre."', '".$direccion."', '".$apellidos."')";
            if (mysqli_query($conn, $sql)) {
                $msg =  "Se introdujo un nuevo registro en la BD; ".$nombre;
            } else {
                $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
            return new soapval('return', 'xsd:string', $msg);
    }

    function eliminarContacto($id) {
        require_once("conexion.php");
        $conn = mysqli_connect($servername, $username, $password, $dbname);
                $sql = "DELETE FROM `escritor` WHERE id_escritor='".$id."'";
                if (mysqli_query($conn, $sql)) {
                    $msg =  "Se elimino un registro de la BD;";
                } else {
                    $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
                return new soapval('return', 'xsd:string', $msg);
        }

        function editarContacto($id) {
            require_once("conexion.php");
            $conn = mysqli_connect($servername, $username, $password, $dbname);
                    $sql = "UPDATE `escritor` SET `nombre`='$nombre',`direccion`='$direccion',`apellidos`='$apellidos' WHERE id_escritor='".$id."'";
                    if (mysqli_query($conn, $sql)) {
                        $msg =  "Se edito un registro de la BD;";
                    } else {
                        $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                    return new soapval('return', 'xsd:string', $msg);
            }

    function buscarContacto($nombre) {
        require_once("conexion.php");
        $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM escritor where nombre='".$nombre."'";

            $resultado = mysqli_query($conn, $sql);
            
            $listado = "<table border='1'><tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Direcci&oacute;n</td></tr>";
            while ($fila = mysqli_fetch_array($resultado)){
                    $listado = $listado."<tr><td>".$fila['id_escritor']."</td>
                                            <td>".$fila['nombre']."</td>
                                            <td>".$fila['apellidos']."</td>
                                            <td>".$fila['direccion']."</td>
                                            <td><button onclick='eliminarContacto(".$fila['id_escritor'].")'>eliminar </button></td>
                                            <td><button onclick='editarContacto(".$fila['id_escritor'].")'>editar </button></td>
                                            </tr>";
            }
            $listado = $listado."</table>";
            mysqli_close($conn);
            return new soapval('return', 'xsd:string', $listado);

    }



    function mostrarTodosContactos() {

    require_once("conexion.php");

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM escritor";

            $resultado = mysqli_query($conn, $sql);
            $listado = "<table border='1'><tr><td>ID</td><td>Nombre</td><td>Apellidos</td><td>Direcci&oacute;n</td></tr>";
            while ($fila = mysqli_fetch_array($resultado)){
                $listado = $listado."<tr><td>".$fila['id_escritor']."</td>
                <td>".$fila['nombre']."</td>
                <td>".$fila['apellidos']."</td>
                <td>".$fila['direccion']."</td>
                <td><button onclick='eliminarContacto(".$fila['id_escritor'].")'>eliminar </button></td>
                <td><button onclick='editarContacto(".$fila['id_escritor'].")'>editar </button></td>
                </tr>";
            }
            $listado = $listado."</table>";
            mysqli_close($conn);

            return  new soapval('return', 'xsd:string', $listado);

    }


$server->register('creaContacto',
    array('nombre'=>'xsd:string','direccion'=>'xsd:string',
        'apellidos'=>'xsd:string'),
    array('return'=> 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'funcion que crea contacto'
    );


$server->register
('mostrarTodosContactos',
    array(),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'funcion que crea muestra los contactos'
    );



    $server->register
    ('buscarContacto',
    array('nombre' => 'xsd:string'),
    array('return' => 'xsd:string'),
        $namespace,
    false,
    'rpc',
    'encoded',
    'funcion que crea muestra los contactos'
    );       

if ( !isset( $HTTP_RAW_POST_DATA ) ) {
        $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
}

$server->service($HTTP_RAW_POST_DATA);
?>



