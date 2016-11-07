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

// Obtiene el listado de tipos de seguimientos activos
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoTiposSeguimientosPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql          = "CALL TbTiposSeguimientosListarEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosTiposSeguimientosDetalleModificar(' . $resultados['IdTipoSeguimiento'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay tipos de seguimientos en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo tipo de seguimiento
if (isset($_POST['action']) && $_POST['action'] == 'registrarTipoSeguimiento') {
    try {
        $descripcion   = $_POST['descripcion'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbTiposSeguimientosAgregar('$descripcion','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idTipoSeguimiento = $resultados['Id'];
                $exito             = "1";
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

// Se realiza la modificación de un tipo de seguimiento existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarTipoSeguimiento') {
    try {
        $idTipoSeguimiento = $_POST['idTipoSeguimiento'];
        $descripcion       = $_POST['descripcion'];
        $estado            = $_POST['estado'];
        $usuarioActual     = $_SESSION['idPersona'];

        $sql = "CALL TbTiposSeguimientosModificar('$idTipoSeguimiento','$descripcion','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un tipo de seguimiento en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarTipoSeguimiento') {
    try {
        $idTipoSeguimiento = $_POST['idTipoSeguimiento'];

        $sql          = "CALL TbTiposSeguimientosListarPorIdTipoSeguimiento('$idTipoSeguimiento')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionTipoSeguimiento">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionTipoSeguimiento" id="txtDescripcionTipoSeguimiento" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['Descripcion']) . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoTipoSeguimiento">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoTipoSeguimiento" id="cboEstadoTipoSeguimiento">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultados['Estado'] == 'A'){
                    $cadena_datos .= '<option value="A" selected>Activo</option>';
                    $cadena_datos .= '<option value="I">Inactivo</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="A">Activo</option>';
                    $cadena_datos .= '<option value="I" selected>Inactivo</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="TiposSeguimientosModificarTipoSeguimiento(' . $resultados['IdTipoSeguimiento'] .')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '</div>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}