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
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de personas para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonas') {
    try {
        $sql          = "CALL TbUsuariosListar()";
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

// Obtiene el listado de personas que no tienen usuario, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasCombobox') {
    try {
        $sql          = "CALL TbPersonasListarSinUsuario()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo usuario
if (isset($_POST['action']) && $_POST['action'] == 'registrarUsuario') {
    try {
        $idPersona     = $_POST['idPersona'];
        $idRolUsuario  = $_POST['idRolUsuario'];
        $contrasena    = $_POST['contrasenaEncriptada'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbUsuariosAgregar('$idPersona','$idRolUsuario','$contrasena','$usuarioActual')";
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
