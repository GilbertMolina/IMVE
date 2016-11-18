<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 15/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoSeguimientosPorVisitaEstado') {
    try {
        $idVisita = $_POST['IdVisita'];
        $estado   = $_POST['estado'];

        $sql          = "CALL TbSeguimientosListarPorVisita('$idVisita','$estado')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosSeguimientosDetalleModificar(' . $resultados["IdVisita"] . ',' . $resultados["IdSeguimiento"] . ')">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay seguimientos en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza la modificación de un seguimiento existente
if (isset($_POST['action']) && $_POST['action'] == 'registrarSeguimiento') {
    try {
        $idVisita          = $_POST['idVisita'];
        $idTipoSeguimiento = $_POST['tipoSeguimiento'];
        $descripcion       = $_POST['descripcion'];
        $fechaPropuesta    = $_POST['fechaPropuesta'];
        $observaciones     = $_POST['observaciones'];
        $estado            = $_POST['estado'];
        $usuarioActual     = $_SESSION['idPersona'];

        $sqlSeguimiento      = "CALL TbSeguimientosAgregar('$idVisita','$idTipoSeguimiento','$descripcion','$fechaPropuesta','','$observaciones','$usuarioActual')";
        $consultaSeguimiento = $db->consulta(utf8_decode($sqlSeguimiento));

        if ($db->num_rows($consultaSeguimiento) != 0) {
            while ($resultadosSeguimiento = $db->fetch_array($consultaSeguimiento)) {
                $idSeguimiento = $resultadosSeguimiento['Id'];
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

// Se realiza la modificación de un seguimiento existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarSeguimiento') {
    try {
        $idSeguimiento     = $_POST['idSeguimiento'];
        $idVisita          = $_POST['idVisita'];
        $idTipoSeguimiento = $_POST['tipoSeguimiento'];
        $descripcion       = $_POST['descripcion'];
        $fechaPropuesta    = $_POST['fechaPropuesta'];
        $fechaRealizacion  = $_POST['fechaRealizacion'];
        $observaciones     = $_POST['observaciones'];
        $estado            = $_POST['estado'];
        $usuarioActual     = $_SESSION['idPersona'];

        $sqlSeguimiento      = "CALL TbSeguimientosModificar('$idSeguimiento','$idTipoSeguimiento','$descripcion','$fechaPropuesta','$fechaRealizacion','$observaciones','$estado','$usuarioActual')";
        $consultaSeguimiento = $db->consulta(utf8_decode($sqlSeguimiento));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un seguimiento en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarSeguimiento') {
    try {
        $idSeguimiento = $_POST['idSeguimiento'];

        $sqlSeguimiento      = "CALL TbSeguimientosListarPorIdSeguimiento('$idSeguimiento')";
        $consultaSeguimiento = $db->consulta($sqlSeguimiento);
        $cadena_datos        = "";

        $sqlTipoSeguimiento      = "CALL TbTiposSeguimientosListar()";
        $consultaTipoSeguimiento = $db->consulta($sqlTipoSeguimiento);

        if($db->num_rows($consultaSeguimiento) != 0)
        {
            while($resultadosSeguimiento = $db->fetch_array($consultaSeguimiento))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdTipoSeguimiento">Tipo de seguimiento:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdTipoSeguimiento" id="cboIdTipoSeguimiento">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                while($resultadosTipoSeguimiento = $db->fetch_array($consultaTipoSeguimiento))
                {
                    if ($resultadosTipoSeguimiento['IdTipoSeguimiento'] == $resultadosSeguimiento['IdTipoSeguimiento']){
                        $cadena_datos .= '<option value="' . $resultadosTipoSeguimiento['IdTipoSeguimiento'] . '" selected>' . utf8_encode($resultadosTipoSeguimiento['Descripcion']) . '</option>';
                    }
                    else
                    {
                        $cadena_datos .= '<option value="' . $resultadosTipoSeguimiento['IdTipoSeguimiento'] . '">' . utf8_encode($resultadosTipoSeguimiento['Descripcion']) . '</option>';
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionSeguimiento">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionSeguimiento" id="txtDescripcionSeguimiento" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultadosSeguimiento['Descripcion']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaPropuesta">Fecha propuesta de realización:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="date" name="txtFechaPropuesta" id="txtFechaPropuesta" data-clear-btn="true" value="' . explode(" ", $resultadosSeguimiento['FechaPropuesta'])[0] . '" />';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaRealizacion">Fecha de realización:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="date" name="txtFechaRealizacion" id="txtFechaRealizacion" data-clear-btn="true" value="' . explode(" ", $resultadosSeguimiento['FechaRealizacion'])[0] . '" />';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtObservacionesSeguimiento">Observaciones:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<textarea name="txtObservacionesSeguimiento" id="txtObservacionesSeguimiento" maxlength="250" placeholder="Observaciones del seguimiento.">' . utf8_encode($resultadosSeguimiento['Observaciones']) . '</textarea>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoSeguimiento">Estado:</label>';
                $cadena_datos .= '<select name="cboEstadoSeguimiento" id="cboEstadoSeguimiento">';
                if ($resultadosSeguimiento['Estado'] == 'N'){
                    $cadena_datos .= '<option value="N" selected>Abierto</option>';
                    $cadena_datos .= '<option value="S">Cerrado</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="N">Abierto</option>';
                    $cadena_datos .= '<option value="S" selected>Cerrado</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="SeguimientosModificarSeguimiento(' . $resultadosSeguimiento["IdVisita"] . ',' . $resultadosSeguimiento["IdSeguimiento"] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-edit">Modificar</button>';
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


