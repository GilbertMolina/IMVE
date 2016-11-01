<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de personas del sistema para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonas') {
    try {
        $sql          = "CALL TbPersonasListar()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</a></li>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de una nueva persona en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'registrarPersona') {
    try {
        $identificacion       = $_POST['identificacion'];
        $nombre               = $_POST['nombre'];
        $apellido1            = $_POST['apellido1'];
        $apellido2            = $_POST['apellido2'];
        $fechaNacimiento      = $_POST['fechaNacimiento'];
        $distrito             = $_POST['distrito'];
        $direccionDomicilio   = $_POST['direccionDomicilio'];
        //$foto                 = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $foto                 = $_POST['foto'];
        $telefono             = $_POST['telefono'];
        $celular              = $_POST['celular'];
        $correo               = $_POST['correo'];
        $sexo                 = $_POST['sexo'];
        $usuarioActual        = $_SESSION['idPersona'];

        $sql = "CALL TbPersonasAgregar('$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$foto','$telefono','$celular','$correo','$sexo','$usuarioActual')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona = $resultados['Id'];
                $exito     = "1";
            }

        } else {
            $exito = "-1";
        }
        echo $exito;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}
