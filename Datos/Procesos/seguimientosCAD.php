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

setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Costa_Rica');

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

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoSeguimientosDeHoy') {
    try {
        $usuarioActual = $_SESSION['idPersona'];

        $sqlSeguimiento              = "CALL TbSeguimientosListarSeguimientosDeHoyPorIdResponsable('$usuarioActual')";
        $consultaSeguimiento         = $db->consulta($sqlSeguimiento);
        $consultaSeguimientoAcciones = $db->consulta($sqlSeguimiento);
        $cadena_datos                = "";

        $idVisita = "";

        if($db->num_rows($consultaSeguimiento) != 0)
        {
            $cadena_datos .= '<ul data-role="listview" id="listaSeguimientosDeHoy" data-filter="true" data-split-icon="gear" data-input="#filtro" data-inset="true">';

            while($resultadoSeguimientos = $db->fetch_array($consultaSeguimiento))
            {
                $idVisita = $resultadoSeguimientos['IdVisita'];

                $fechaPropuesta   = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoSeguimientos['FechaPropuesta'])[0])));
                $fechaRealizacion = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoSeguimientos['FechaRealizacion'])[0])));

                $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #337AB7; color: #FFFFFF">' . utf8_encode($resultadoSeguimientos['DescripcionSeguimiento']) . '</li>';
                $cadena_datos .= '<li>';
                $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosSeguimientosDetalleModificar(' . $resultadoSeguimientos['IdVisita'] . ',' . $resultadoSeguimientos['IdSeguimiento'] . ')">';
                $cadena_datos .= '<h2>Visita: ' . utf8_encode($resultadoSeguimientos['Descripcion']) . '</h2>';
                $cadena_datos .= '<p><span style="font-weight: bold">Fecha propuesta: </span>' . $fechaPropuesta .'</p>';
                $cadena_datos .= '</a>';
                $cadena_datos .= '<a href="#acciones_'. $resultadoSeguimientos['IdSeguimiento'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a>';
                $cadena_datos .= '</li>';
            }
            $cadena_datos .= '</ul>';

            $sqlPersonaVisita      = "CALL TbPersonasVisitasAccionesPorIdVisita('$idVisita')";
            $consultaPersonaVisita = $db->consulta($sqlPersonaVisita);

            if($db->num_rows($consultaSeguimientoAcciones) != 0)
            {
                while($resultadoSeguimientosAcciones = $db->fetch_array($consultaSeguimientoAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadoSeguimientosAcciones['IdSeguimiento'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Visitantes</h3>';
                    $cadena_datos .= '<hr>';
                    $cadena_datos .= '<ul data-role="listview" id="listaPersonas" data-filter="true" data-input="#filtro" data-autodividers="true" data-inset="true">';

                    if($db->num_rows($consultaPersonaVisita) != 0)
                    {
                        while($resultadosPersona = $db->fetch_array($consultaPersonaVisita))
                        {
                            $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosPersonasDetalleModificar(' . $resultadosPersona['IdPersona'] . ')">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</a></li>';
                        }
                        $cadena_datos .= '</ul>';
                    }
                    else
                    {
                        $cadena_datos .= '<li>No hay personas asociadas en este seguimiento.</li>';
                    }
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';

                    $cadena_datos .= '<hr>';
                    $cadena_datos .= '<a href="#" onclick="BienvenidaCerrarSeguimiento(' . $resultadoSeguimientosAcciones['IdSeguimiento'] . ')" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini">Cerrar seguimiento</a>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<div class="alert alert-success" role="alert">';
            $cadena_datos .= '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    ';
            $cadena_datos .= 'No tiene ningún seguimiento para hoy.';
            $cadena_datos .= '</div>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoSeguimientosPendientes') {
    try {
        $usuarioActual = $_SESSION['idPersona'];

        $sqlSeguimiento              = "CALL TbSeguimientosListarCompromisosPendientesPorIdResponsable('$usuarioActual')";
        $consultaSeguimiento         = $db->consulta($sqlSeguimiento);
        $consultaSeguimientoAcciones = $db->consulta($sqlSeguimiento);
        $cadena_datos                = "";

        $idVisita = "";

        if($db->num_rows($consultaSeguimiento) != 0)
        {
            $cadena_datos .= '<ul data-role="listview" id="listaSeguimientosPendientes" data-filter="true" data-split-icon="gear" data-input="#filtro" data-inset="true">';

            while($resultadoSeguimientos = $db->fetch_array($consultaSeguimiento))
            {
                $idVisita = $resultadoSeguimientos['IdVisita'];

                $fechaPropuesta   = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoSeguimientos['FechaPropuesta'])[0])));
                $fechaRealizacion = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoSeguimientos['FechaRealizacion'])[0])));

                $fechaActual               = new DateTime("now");
                $fechaPropuestaSeguimiento = date_create($resultadoSeguimientos['FechaPropuesta']);

                if($fechaPropuestaSeguimiento < $fechaActual)
                {
                    $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #D9534F; color: #FFFFFF">' . utf8_encode($resultadoSeguimientos['DescripcionSeguimiento']) . '</li>';
                    $cadena_datos .= '<li>';
                    $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosSeguimientosDetalleModificar(' . $resultadoSeguimientos['IdVisita'] . ',' . $resultadoSeguimientos['IdSeguimiento'] . ')">';
                    $cadena_datos .= '<h2>Visita: ' . utf8_encode($resultadoSeguimientos['Descripcion']) . '</h2>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha propuesta: </span>' . $fechaPropuesta .'</p>';
                    $cadena_datos .= '</a>';
                    $cadena_datos .= '<a href="#acciones_'. $resultadoSeguimientos['IdSeguimiento'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a>';
                    $cadena_datos .= '</li>';
                }
                else
                {
                    $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #337AB7; color: #FFFFFF">' . utf8_encode($resultadoSeguimientos['DescripcionSeguimiento']) . '</li>';
                    $cadena_datos .= '<li>';
                    $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosSeguimientosDetalleModificar(' . $resultadoSeguimientos['IdVisita'] . ',' . $resultadoSeguimientos['IdSeguimiento'] . ')">';
                    $cadena_datos .= '<h2>Visita: ' . utf8_encode($resultadoSeguimientos['Descripcion']) . '</h2>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha propuesta: </span>' . $fechaPropuesta .'</p>';
                    $cadena_datos .= '</a>';
                    $cadena_datos .= '<a href="#acciones_'. $resultadoSeguimientos['IdSeguimiento'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a>';
                    $cadena_datos .= '</li>';
                }
            }
            $cadena_datos .= '</ul>';

            $sqlPersonaVisita      = "CALL TbPersonasVisitasAccionesPorIdVisita('$idVisita')";
            $consultaPersonaVisita = $db->consulta($sqlPersonaVisita);

            if($db->num_rows($consultaSeguimientoAcciones) != 0)
            {
                while($resultadoSeguimientosAcciones = $db->fetch_array($consultaSeguimientoAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadoSeguimientosAcciones['IdSeguimiento'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Visitantes</h3>';
                    $cadena_datos .= '<hr>';
                    $cadena_datos .= '<ul data-role="listview" id="listaPersonas" data-filter="true" data-input="#filtro" data-autodividers="true" data-inset="true">';

                    if($db->num_rows($consultaPersonaVisita) != 0)
                    {
                        while($resultadosPersona = $db->fetch_array($consultaPersonaVisita))
                        {
                            $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosPersonasDetalleModificar(' . $resultadosPersona['IdPersona'] . ')">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</a></li>';
                        }
                        $cadena_datos .= '</ul>';

                        $sqlPersonaVisita      = "CALL TbPersonasVisitasAccionesPorIdVisita('$idVisita')";
                        $consultaPersonaVisita = $db->consulta($sqlPersonaVisita);
                    }
                    else
                    {
                        $cadena_datos .= '<li>No hay personas asociadas en este seguimiento.</li>';
                    }
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';

                    $cadena_datos .= '<hr>';
                    $cadena_datos .= '<a href="#" onclick="BienvenidaCerrarSeguimiento(' . $resultadoSeguimientosAcciones['IdSeguimiento'] . ')" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini">Cerrar seguimiento</a>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<div class="alert alert-success" role="alert">';
            $cadena_datos .= '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    ';
            $cadena_datos .= 'Actualmente no tiene seguimientos pendientes.';
            $cadena_datos .= '</div>';
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

        $sqlSeguimiento      = "CALL TbSeguimientosAgregar('$idVisita','$idTipoSeguimiento','$descripcion','$fechaPropuesta','$observaciones','$usuarioActual')";
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

        if($fechaRealizacion != '')
        {
            $sqlSeguimiento      = "CALL TbSeguimientosModificarConFechaRealizacion('$idSeguimiento','$idTipoSeguimiento','$descripcion','$fechaPropuesta','$fechaRealizacion','$observaciones','$estado','$usuarioActual')";
            $consultaSeguimiento = $db->consulta(utf8_decode($sqlSeguimiento));
            echo 1;
        }
        else{
            $sqlSeguimiento      = "CALL TbSeguimientosModificarSinFechaRealizacion('$idSeguimiento','$idTipoSeguimiento','$descripcion','$fechaPropuesta','$observaciones','$estado','$usuarioActual')";
            $consultaSeguimiento = $db->consulta(utf8_decode($sqlSeguimiento));
            echo 1;
        }
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el cierre de un seguimiento existente
if (isset($_POST['action']) && $_POST['action'] == 'cerrarSeguimiento') {
    try {
        $idSeguimiento = $_POST['idSeguimiento'];
        $usuarioActual = $_SESSION['idPersona'];

        $sqlSeguimiento      = "CALL TbSeguimientosCerrarSeguimiento('$idSeguimiento','$usuarioActual')";
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
                $cadena_datos .= '<option value="0">Seleccione</option>';
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


