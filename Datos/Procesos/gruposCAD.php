<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 11/11/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de grupos del sistema para mostrarlos en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoGruposPorEstado') {
    try {
        $estado       = $_POST['estado'];

        $sql          = "CALL TbGruposListarPorEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosGruposDetalleModificar(' . $resultados['IdGrupo'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a><a href="#acciones_'. $resultados['IdGrupo'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay grupos en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo grupo
if (isset($_POST['action']) && $_POST['action'] == 'registrarGrupo') {
    try {
        $idCategoriaGrupo = $_POST['idCategoriaGrupo'];
        $idMinisterio     = $_POST['idMinisterio'];
        $descripcion      = $_POST['descripcion'];
        $usuarioActual    = $_SESSION['idPersona'];

        $sql = "CALL TbGruposAgregar('$idCategoriaGrupo','$idMinisterio','$descripcion','$usuarioActual')";
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

// Se realiza la modificación de un grupo existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarGrupo') {
    try {
        $idGrupo          = $_POST['idGrupo'];
        $idCategoriaGrupo = $_POST['idCategoriaGrupo'];
        $idMinisterio     = $_POST['idMinisterio'];
        $descripcion      = $_POST['descripcion'];
        $estado           = $_POST['estado'];
        $usuarioActual    = $_SESSION['idPersona'];

        $sql = "CALL TbGruposModificar('$idGrupo', '$idCategoriaGrupo','$idMinisterio','$descripcion','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un grupo en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarGrupo') {
    try {
        $idGrupo = $_POST['IdGrupo'];

        $sql          = "CALL TbGruposListarPorIdGrupo('$idGrupo')";
        $consulta     = $db->consulta($sql);
        $result       = array();
        $cadena_datos = "";

        $sqlCategoriasGrupos      = "CALL TbCategoriasGruposListar()";
        $consultaCategoriasGrupos = $db->consulta($sqlCategoriasGrupos);

        $sqlMinisterios      = "CALL TbMinisteriosListar()";
        $consultaMinisterios = $db->consulta($sqlMinisterios);

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdCategoriasGrupos">Categorías de grupo:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdCategoriasGrupos" id="cboIdCategoriasGrupos">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaCategoriasGrupos) != 0)
                {
                    while($resultadosCategoriasGrupo = $db->fetch_array($consultaCategoriasGrupos))
                    {
                        if ($resultadosCategoriasGrupo['Descripcion'] == $resultados['Categoria']){
                            $cadena_datos .= '<option value="' . $resultadosCategoriasGrupo['IdCategoriaGrupo'] . '" selected>' . utf8_encode($resultadosCategoriasGrupo['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosCategoriasGrupo['IdCategoriaGrupo'] . '">' . utf8_encode($resultadosCategoriasGrupo['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdMinisterios">Ministerios:</label>';
                $cadena_datos .= '<select name="cboIdMinisterios" id="cboIdMinisterios">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaMinisterios) != 0)
                {
                    while($resultadosMinisterios = $db->fetch_array($consultaMinisterios))
                    {
                        if ($resultadosMinisterios['Descripcion'] == $resultados['Ministerio']){
                            $cadena_datos .= '<option value="' . $resultadosMinisterios['IdMinisterio'] . '" selected>' . utf8_encode($resultadosMinisterios['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosMinisterios['IdMinisterio'] . '">' . utf8_encode($resultadosMinisterios['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionGrupo">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionGrupo" id="txtDescripcionGrupo" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['Descripcion']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoGrupo">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoGrupo" id="cboEstadoGrupo">';
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
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="GruposModificarGrupo(' . $resultados['IdGrupo'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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

