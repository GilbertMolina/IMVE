<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 27/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

//Se realiza el llamado a la clase de conexion
require("ConexionMySQL.php");
$db = new MySQL();

// Inicio de sesión en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'registrarUsuario') {
    try {
        $identificacion       = $_POST['identificacion'];
        $nombre               = $_POST['nombre'];
        $apellido1            = $_POST['apellido1'];
        $apellido2            = $_POST['apellido2'];
        $fechaNacimiento      = $_POST['fechaNacimiento'];
        $distrito             = $_POST['distrito'];
        $direccionDomicilio   = $_POST['direccionDomicilio'];
        $telefono             = $_POST['telefono'];
        $celular              = $_POST['celular'];
        $sexo                 = $_POST['sexo'];
        $contrasenaEncriptada = $_POST['contrasenaEncriptada'];
        
        $sql      = "CALL TbUsuariosAgregar('$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$sexo','$contrasenaEncriptada')";
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