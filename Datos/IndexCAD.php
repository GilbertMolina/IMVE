<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 26/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

//Se realiza el llamado a la clase de conexion
require("ConexionMySQL.php");
$db = new MySQL();

// Inicio de sesión en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'iniciarSesion') {
    try {
        $identificacion = $_POST['identificacion'];
        $contrasena     = $_POST['contrasena'];
        
        $sql      = "CALL TbUsuariosIniciarSesion('$identificacion','$contrasena')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona      = $resultados['IdPersona'];
                $identificacion = $resultados['Identificacion'];
                $nombreCompleto = $resultados['NombreCompleto'];
                $sexo           = $resultados['Sexo'];
                $idRol          = $resultados['IdRolUsuario'];
                $rol            = $resultados['Rol'];
                $token          = uniqid(); //Token para login
                $exito          = "1,".$nombreCompleto.",".$sexo;
            }

            //Se crean las variables de sesión
            $_SESSION['idPersona']      = $idPersona;
            $_SESSION['nombreCompleto'] = $nombreCompleto;
            $_SESSION['sexo']           = $sexo;
            $_SESSION['rol']            = $rol;
            $_SESSION['token']          = $token;

        } else {
            $exito = "-1,no,no";
        }
        echo $exito;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Cerrar sesión en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'cerrarSesion') {
    try {
        session_destroy();
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}