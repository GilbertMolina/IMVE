<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 02/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de categorias grupos activas
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCategoriasGruposActivas') {
    try {
        $sql          = "CALL TbCategoriasGruposListar()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="' . $resultados['IdCategoriaGrupo'] . '">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nueva categoria de grupos
if (isset($_POST['action']) && $_POST['action'] == 'registrarCategoriaGrupo') {
    try {
        $descripcion   = $_POST['descripcion'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbCategoriasGruposAgregar('$descripcion','$usuarioActual')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idCategoriaGrupo = $resultados['Id'];
                $exito            = "1";
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