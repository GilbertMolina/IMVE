<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("conexionMySQL.php");
$db = new MySQL();

// Se realiza el registro de un nuevo usuario en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'cambiarContrasena') {
    try {
        $idPersona            = $_SESSION['idPersona'];
        $contrasenaEncriptada = $_POST['contrasenaEncriptada'];

        $sql = "CALL TbUsuariosCambiarContrasena('$idPersona','$contrasenaEncriptada')";
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
