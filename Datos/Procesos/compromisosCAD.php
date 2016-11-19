<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Se realiza el registro de un nuevo compromiso
if (isset($_POST['action']) && $_POST['action'] == 'registrarCompromiso') {
    try {
        $tipoResposable   = $_POST['tipoResposable'];
        $idMinisterio     = $_POST['idMinisterio'];
        $idTipoCompromiso = $_POST['idTipoCompromiso'];
        $descripcion      = $_POST['descripcion'];
        $fechaInicio      = $_POST['fechaInicio'];
        $fechaFinal       = $_POST['fechaFinal'];
        $lugar            = $_POST['lugar'];

        $listaPersonasResponsables = "";
        $listaGruposResponsables = "";

        if($tipoResposable == 'P'){
            $listaPersonasResponsables = json_decode(stripslashes($_POST['listaPersonasResponsables']));
        }
        else{
            $listaGruposResponsables = json_decode(stripslashes($_POST['listaGruposResponsables']));
        }
        
        $listaPersonasParticipantes = json_decode(stripslashes($_POST['listaPersonasParticipantes']));
        $usuarioActual              = $_SESSION['idPersona'];
        $idCompromiso               = "";

        $sqlCompromiso      = "CALL TbCompromisosAgregar('$idMinisterio','$idTipoCompromiso','$descripcion','$fechaInicio','$fechaFinal','$lugar','$usuarioActual')";
        $consultaCompromiso = $db->consulta(utf8_decode($sqlCompromiso));

        if ($db->num_rows($consultaCompromiso) != 0) {
            while ($resultados = $db->fetch_array($consultaCompromiso)) {
                $idCompromiso = $resultados['Id'];
                $exito       = "1";
            }

        } else {
            $exito = "-1";
        }

        if ($exito == "1"){
            if($tipoResposable == 'P') {
                if(count($listaPersonasResponsables) > 0){
                    foreach($listaPersonasResponsables as $personaResponsable){
                        $sqlPersonaResponsable        = "CALL TbResponsablesCompromisosAgregar('$personaResponsable','$idCompromiso','$usuarioActual')";
                        $consultaPersonaResponsable   = $db->consulta(utf8_decode($sqlPersonaResponsable));

                        if ($db->num_rows($consultaPersonaResponsable) != 0) {
                            while ($resultadosPersonaResponsable= $db->fetch_array($consultaPersonaResponsable)) {
                                $idPersonaResponsable = $resultadosPersonaResponsable['Id'];
                                $exito                = "1";
                            }
                        } else {
                            $exito = "-1";
                        }
                    }
                }
            }
            else
            {
                if(count($listaGruposResponsables) > 0){
                    foreach($listaGruposResponsables as $grupoResponsable){
                        $sqlGrupoResponsable        = "CALL TbReponsablesGruposCompromisosAgregar('$grupoResponsable','$idCompromiso','$usuarioActual')";
                        $consultaGrupoResponsable   = $db->consulta(utf8_decode($sqlGrupoResponsable));

                        if ($db->num_rows($consultaGrupoResponsable) != 0) {
                            while ($resultadosGrupoResponsable= $db->fetch_array($consultaGrupoResponsable)) {
                                $idGrupoResponsable = $resultadosGrupoResponsable['Id'];
                                $exito              = "1";
                            }
                        } else {
                            $exito = "-1";
                        }
                    }
                }
            }

            if(count($listaPersonasParticipantes) > 0){
                foreach($listaPersonasParticipantes as $personaParticipante){
                    $sqlPersonaParticipante      = "CALL TbParticipantesCompromisosAgregar('$personaParticipante','$idCompromiso','$usuarioActual')";
                    $consultaPersonaParticipante = $db->consulta(utf8_decode($sqlPersonaParticipante));

                    if ($db->num_rows($consultaPersonaParticipante) != 0) {
                        while ($resultadosPersonaParticipante= $db->fetch_array($consultaPersonaParticipante)) {
                            $idPersonaParticipante = $resultadosPersonaParticipante['Id'];
                            $exito                 = "1";
                        }
                    } else {
                        $exito = "-1";
                    }
                }
            }
        }

        echo $exito;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de ministerios utilizados en los compromisos, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoMinisteriosUtilizadosCombobox') {
    try {
        $sql          = "CALL TbCompromisosListarMinisteriosUtilizados()";
        $consulta     = $db->consulta($sql);
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

// Obtiene el listado de tipos de compromisos utilizados en los compromisos, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoTiposCompromisosUtilizadosCombobox') {
    try {
        $sql          = "CALL TbCompromisosListarTiposCompromisosUtilizados()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdTipoCompromiso'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de compromisos filtrados por estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCompromisosPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sqlCompromiso      = "CALL TbCompromisosListarPorEstado('$estado')";
        $consultaCompromiso = $db->consulta($sqlCompromiso);
        $cadena_datos = "";

        $compromisos = array();

        while($fila = $db->fetch_array($consultaCompromiso))
        {
            $idCompromiso = utf8_encode($fila['IdCompromiso']);
            $descripcion = utf8_encode($fila['Descripcion']);
            $url = "compromisosDetalle.php?IdCompromiso=" . $idCompromiso;
            $fechaInicio = utf8_encode(explode(" ", $fila['FechaInicio'])[0] . 'T' . explode(" ", $fila['FechaInicio'])[1]);
            $fechaFinal = utf8_encode(explode(" ", $fila['FechaFinal'])[0] . 'T' . explode(" ", $fila['FechaFinal'])[1]);

            $compromisos[] = array(
                'title' => $descripcion
                , 'url' => $url
                , 'start' => $fechaInicio
                , 'end' => $fechaFinal
            );
        }

        $compromisosJSON = json_encode($compromisos);

        echo $compromisosJSON;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un compromiso en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarCompromiso') {
    try {
        $idCompromiso = $_POST['idCompromiso'];

        $sql          = "CALL TbTiposCompromisosListarPorIdTipoCompromiso('$idCompromiso')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';


                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdMinisterios">Ministerios:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdMinisterios" id="cboIdMinisterios">';
                $cadena_datos .= '<option value="0">Seleccione</option>';

                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdTiposCompromisos">Tipos compromisos:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdTiposCompromisos" id="cboIdTiposCompromisos">';
                $cadena_datos .= '<option value="0">Seleccione</option>';

                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionCompromiso">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionCompromiso" id="txtDescripcionCompromiso" maxlength="50" data-clear-btn="true"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaInicio">Fecha y hora de inicio:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="datetime-local" name="txtFechaInicio" id="txtFechaInicio" data-clear-btn="true" value="" >';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaFinal">Fecha y hora de fin:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="datetime-local" name="txtFechaFinal" id="txtFechaFinal" data-clear-btn="true" value="" >';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtLugar">Lugar:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtLugar" id="txtLugar" maxlength="100" data-clear-btn="true"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtTipoResponsable">Tipo de responsable:</label>';
                $cadena_datos .= '<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" class="text-center" onchange="CompromisosCambiarTipoReponsable()">';
                $cadena_datos .= '<input type="radio" name="tipoResponsable" id="persona" value="P" checked="checked">';
                $cadena_datos .= '<label for="persona">Personas</label>';
                $cadena_datos .= '<input type="radio" name="tipoResponsable" id="grupo" value="G">';
                $cadena_datos .= '<label for="grupo">Grupos</label>';
                $cadena_datos .= '</fieldset>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<div id="divCompromisosPersonasResponsables">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<label for="CompromisosPersonasResponsables">Personas reponsables:</label>';
                $cadena_datos .= '<select name="CompromisosPersonasResponsables" id="CompromisosPersonasResponsables" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';

                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<div id="divCompromisosGruposResponsables">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<label for="CompromisosGruposResponsables">Grupos responsables:</label>';
                $cadena_datos .= '<select name="CompromisosGruposResponsables" id="CompromisosGruposResponsables" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';

                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div id="divCompromisosPersonasParticipantes">';
                $cadena_datos .= '<label for="CompromisosPersonasParticipantes">Personas participantes:</label>';
                $cadena_datos .= '<select name="CompromisosPersonasParticipantes" id="CompromisosPersonasParticipantes" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';

                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoGrupo">Estado:</label>';
                $cadena_datos .= '<select name="cboEstadoGrupo" id="cboEstadoGrupo" disabled>';
                
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="CompromisoRegistrarCompromiso()" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Agregar</button>';
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