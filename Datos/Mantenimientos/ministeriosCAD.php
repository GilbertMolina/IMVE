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

// Obtiene el listado de ministerios activos
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoMinisteriosPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql          = "CALL TbMinisteriosListarEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosMinisteriosDetalleModificar(' . $resultados['IdMinisterio'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay ministerios en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de ministerios activos, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoMinisteriosActivosCombobox') {
    try {
        $sql          = "CALL TbMinisteriosListar()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";
        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdMinisterio'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo ministerio
if (isset($_POST['action']) && $_POST['action'] == 'registrarMinisterio') {
    try {
        $descripcion   = $_POST['descripcion'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbMinisteriosAgregar('$descripcion','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idMinisterio = $resultados['Id'];
                $exito        = "1";
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

// Se realiza la modificación de un ministerio existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarMinisterio') {
    try {
        $idMinisterio  = $_POST['idMinisterio'];
        $descripcion   = $_POST['descripcion'];
        $estado        = $_POST['estado'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbMinisteriosModificar('$idMinisterio','$descripcion','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un ministerio en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarMinisterio') {
    try {
        $idMinisterio = $_POST['idMinisterio'];

        $sql          = "CALL TbMinisteriosListarPorIdMinisterio('$idMinisterio')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionMinisterio">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionMinisterio" id="txtDescripcionMinisterio" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['Descripcion']) . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoMinisterio">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoMinisterio" id="cboEstadoMinisterio">';
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
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="MinisteriosModificarMinisterio(' . $resultados['IdMinisterio'] .')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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