<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de los tipos de relacion
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoRelaciones') {
    try {
        $sql          = "CALL TbTiposRelacionesListar()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="' . $resultados['IdTipoRelacion'] . '">' . utf8_encode($resultados['NombreMasculino']) . '/' . utf8_encode($resultados['NombreFemenino']) . ' - ' . utf8_encode($resultados['NombreInversoMasculino']) . '/' . utf8_encode($resultados['NombreInversoFemenino']) . '</a></li>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un tipo de relacion
if (isset($_POST['action']) && $_POST['action'] == 'registrarTipoRelacion') {
    try {
        $nombreMasculino        = $_POST['nombreMasculino'];
        $nombreFemenino         = $_POST['nombreFemenino'];
        $nombreInversoMasculino = $_POST['nombreInversoMasculino'];
        $nombreInversoFemenino  = $_POST['nombreInversoFemenino'];
        $usuarioActual          = $_SESSION['idPersona'];

        $sql = "CALL TbTiposRelacionesAgregar('$nombreMasculino','$nombreFemenino','$nombreInversoMasculino','$nombreInversoFemenino','$usuarioActual')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idTipoRelacion = $resultados['Id'];
                $exito          = "1";
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
