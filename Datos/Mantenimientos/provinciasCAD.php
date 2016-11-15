<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene las provincias del sistema
if (isset($_POST['action']) && $_POST['action'] == 'obtenerProvincias') {
    try {
        $sql          = "CALL TbProvinciasListar()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdProvincia'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}
