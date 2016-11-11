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

// Obtiene el listado de categorias de grupos activas o inactivas
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCategoriasGruposPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql          = "CALL TbCategoriasGruposListarEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosCategoriasGruposDetalleModificar(' . $resultados['IdCategoriaGrupo'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay categorías de grupos en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de categorias de grupos activas o inactivas, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCategoriasGruposActivasCombobox') {
    try {
        $sql          = "CALL TbCategoriasGruposListar()";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";
        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdCategoriaGrupo'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
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
        $consulta = $db->consulta(utf8_decode($sql));

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

// Se realiza la modificación de una categoria grupo existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarCategoriaGrupo') {
    try {
        $idCategoriaGrupo = $_POST['idCategoriaGrupo'];
        $descripcion      = $_POST['descripcion'];
        $estado           = $_POST['estado'];
        $usuarioActual    = $_SESSION['idPersona'];

        $sql = "CALL TbCategoriasGruposModificar('$idCategoriaGrupo','$descripcion','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga una categoría grupo en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarCategoriaGrupo') {
    try {
        $idCategoriaGrupo = $_POST['idCategoriaGrupo'];

        $sql          = "CALL TbCategoriasGruposListarPorIdCategoriaGrupo('$idCategoriaGrupo')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionCategoriaGrupo">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionCategoriaGrupo" id="txtDescripcionCategoriaGrupo" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['Descripcion']) . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoCategoriaGrupo">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoCategoriaGrupo" id="cboEstadoCategoriaGrupo">';
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
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="CategoriasGruposModificarCategoria(' . $resultados['IdCategoriaGrupo'] .')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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