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

setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Costa_Rica');

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
        $usuarioActual = $_SESSION['idPersona'];

        // Compromisos activos que no son del usuario actual
        $sqlCompromisoActivosEcluyendoUsuario      = "CALL TbCompromisosListarExcluyendoUsuario('$usuarioActual','A')";
        $consultaCompromisoActivosEcluyendoUsuario = $db->consulta($sqlCompromisoActivosEcluyendoUsuario);
        $compromisosActivosEcluyendoUsuario        = array();

        // Compromisos inactivos que no son del usuario actual
        $sqlCompromisoInactivosEcluyendoUsuario      = "CALL TbCompromisosListarExcluyendoUsuario('$usuarioActual','I')";
        $consultaCompromisoInactivosEcluyendoUsuario = $db->consulta($sqlCompromisoInactivosEcluyendoUsuario);
        $compromisosInactivosEcluyendoUsuario        = array();

        // Compromisos activos del usuario actual
        $sqlCompromisoActivosIncluyendoUsuario      = "CALL TbCompromisosListarIncluyendoUsuario('$usuarioActual','A')";
        $consultaCompromisoActivosIncluyendoUsuario = $db->consulta($sqlCompromisoActivosIncluyendoUsuario);
        $compromisosActivosIncluyendoUsuario        = array();

        // Compromisos activos del usuario actual
        $sqlCompromisoInactivosIncluyendoUsuario      = "CALL TbCompromisosListarIncluyendoUsuario('$usuarioActual','I')";
        $consultaCompromisoInactivosIncluyendoUsuario = $db->consulta($sqlCompromisoInactivosIncluyendoUsuario);
        $compromisosInactivosIncluyendoUsuario        = array();

        // Arreglo que será la unión de los otros arreglos
        $totalCompromisos = array();

        // Compromisos activos que no son del usuario actual
        while($fila = $db->fetch_array($consultaCompromisoActivosEcluyendoUsuario))
        {
            $idCompromiso = utf8_encode($fila['IdCompromiso']);
            $descripcion = utf8_encode($fila['Descripcion']);
            $url = "compromisosDetalle.php?IdCompromiso=" . $idCompromiso;
            $fechaInicio = utf8_encode(explode(" ", $fila['FechaInicio'])[0] . 'T' . explode(" ", $fila['FechaInicio'])[1]);
            $fechaFinal = utf8_encode(explode(" ", $fila['FechaFinal'])[0] . 'T' . explode(" ", $fila['FechaFinal'])[1]);

            $compromisosActivosEcluyendoUsuario[] = array(
                'title' => $descripcion
                , 'url' => $url
                , 'start' => $fechaInicio
                , 'end' => $fechaFinal
                , 'color' => '#4CAF50'
                , 'textColor' => '#FFFFFF'
            );
        }

        // Compromisos inactivos que no son del usuario actual
        while($fila = $db->fetch_array($consultaCompromisoInactivosEcluyendoUsuario))
        {
            $idCompromiso = utf8_encode($fila['IdCompromiso']);
            $descripcion = utf8_encode($fila['Descripcion']);
            $url = "compromisosDetalle.php?IdCompromiso=" . $idCompromiso;
            $fechaInicio = utf8_encode(explode(" ", $fila['FechaInicio'])[0] . 'T' . explode(" ", $fila['FechaInicio'])[1]);
            $fechaFinal = utf8_encode(explode(" ", $fila['FechaFinal'])[0] . 'T' . explode(" ", $fila['FechaFinal'])[1]);

            $compromisosInactivosEcluyendoUsuario[] = array(
                'title' => $descripcion
                , 'url' => $url
                , 'start' => $fechaInicio
                , 'end' => $fechaFinal
                , 'color' => '#2196F3'
                , 'textColor' => '#FFFFFF'
            );
        }

        // Compromisos activos del usuario actual
        while($fila = $db->fetch_array($consultaCompromisoActivosIncluyendoUsuario))
        {
            $idCompromiso = utf8_encode($fila['IdCompromiso']);
            $descripcion = utf8_encode($fila['Descripcion']);
            $url = "compromisosDetalle.php?IdCompromiso=" . $idCompromiso;
            $fechaInicio = utf8_encode(explode(" ", $fila['FechaInicio'])[0] . 'T' . explode(" ", $fila['FechaInicio'])[1]);
            $fechaFinal = utf8_encode(explode(" ", $fila['FechaFinal'])[0] . 'T' . explode(" ", $fila['FechaFinal'])[1]);

            $compromisosActivosIncluyendoUsuario[] = array(
                'title' => $descripcion
                , 'url' => $url
                , 'start' => $fechaInicio
                , 'end' => $fechaFinal
                , 'color' => '#EF5350'
                , 'textColor' => '#FFFFFF'
            );
        }

        // Compromisos inactivos del usuario actual
        while($fila = $db->fetch_array($consultaCompromisoInactivosIncluyendoUsuario))
        {
            $idCompromiso = utf8_encode($fila['IdCompromiso']);
            $descripcion = utf8_encode($fila['Descripcion']);
            $url = "compromisosDetalle.php?IdCompromiso=" . $idCompromiso;
            $fechaInicio = utf8_encode(explode(" ", $fila['FechaInicio'])[0] . 'T' . explode(" ", $fila['FechaInicio'])[1]);
            $fechaFinal = utf8_encode(explode(" ", $fila['FechaFinal'])[0] . 'T' . explode(" ", $fila['FechaFinal'])[1]);

            $compromisosInactivosIncluyendoUsuario[] = array(
                'title' => $descripcion
                , 'url' => $url
                , 'start' => $fechaInicio
                , 'end' => $fechaFinal
                , 'color' => '#7E57C2'
                , 'textColor' => '#FFFFFF'
            );
        }

        // Se hace un solo arreglo para posteriormente formatearlo a JSON
        $totalCompromisos = array_merge($compromisosActivosEcluyendoUsuario,$compromisosInactivosEcluyendoUsuario,$compromisosActivosIncluyendoUsuario,$compromisosInactivosIncluyendoUsuario);

        $compromisosJSON = json_encode($totalCompromisos);

        echo $compromisosJSON;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCompromisosDeHoy') {
    try {
        $usuarioActual = $_SESSION['idPersona'];

        $sqlCompromiso      = "CALL TbCompromisosListarCompromisosDeHoyPorIdResponsable('$usuarioActual')";
        $consultaCompromiso = $db->consulta($sqlCompromiso);
        $cadena_datos       = "";

        if($db->num_rows($consultaCompromiso) != 0)
        {
            $cadena_datos .= '<ul data-role="listview" id="listaCompromisosDeHoy" data-filter="true" data-input="#filtro" data-inset="true">';

            while($resultadoCompromisos = $db->fetch_array($consultaCompromiso))
            {
                $fechaInicio       = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoCompromisos['FechaInicio'])[0])));
                $fechaFinalizacion = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoCompromisos['FechaFinal'])[0])));

                $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #5CB85C; color: #FFFFFF">' . utf8_encode($resultadoCompromisos['Descripcion']) . '</li>';
                $cadena_datos .= '<li>';
                $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosCompromisosDetalleModificar(' . $resultadoCompromisos['IdCompromiso'] . ')">';
                $cadena_datos .= '<h2>Lugar: ' . utf8_encode($resultadoCompromisos['Lugar']) . '</h2>';
                $cadena_datos .= '<p><span style="font-weight: bold">Fecha de inicio: </span>' . $fechaInicio .'</p>';
                $cadena_datos .= '<p><span style="font-weight: bold">Hora de inicio: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaInicio"])[1]), 'g:ia') .'</p>';
                $cadena_datos .= '<p><span style="font-weight: bold">Fecha de finalización: </span>' . $fechaFinalizacion .'</p>';
                $cadena_datos .= '<p><span style="font-weight: bold">Hora de finalización: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaFinal"])[1]), 'g:ia') .'</p>';
                $cadena_datos .= '</a>';
                $cadena_datos .= '</li>';
            }
            $cadena_datos .= '</ul>';
        }
        else
        {
            $cadena_datos .= '<div class="alert alert-success" role="alert">';
            $cadena_datos .= '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    ';
            $cadena_datos .= 'No tiene ningún compromiso para hoy.';
            $cadena_datos .= '</div>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoCompromisosPendientes') {
    try {
        $usuarioActual = $_SESSION['idPersona'];

        $sqlCompromiso      = "CALL TbCompromisosListarCompromisosPendientesPorIdResponsable('$usuarioActual')";
        $consultaCompromiso = $db->consulta($sqlCompromiso);
        $cadena_datos       = "";

        if($db->num_rows($consultaCompromiso) != 0)
        {
            $cadena_datos .= '<ul data-role="listview" id="listaCompromisosPendientes" data-filter="true" data-input="#filtro" data-inset="true">';

            while($resultadoCompromisos = $db->fetch_array($consultaCompromiso))
            {
                $fechaInicio       = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoCompromisos['FechaInicio'])[0])));
                $fechaFinalizacion = ucfirst(strftime('%A, %d de %B de %Y', strtotime(explode(' ', $resultadoCompromisos['FechaFinal'])[0])));

                $fechaActual          = new DateTime("now");
                $fechaFinalCompromiso = date_create($resultadoCompromisos['FechaFinal']);

                if($fechaFinalCompromiso < $fechaActual)
                {
                    $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #D9534F; color: #FFFFFF">' . utf8_encode($resultadoCompromisos['Descripcion']) . '</li>';
                    $cadena_datos .= '<li>';
                    $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosCompromisosDetalleModificar(' . $resultadoCompromisos['IdCompromiso'] . ')">';
                    $cadena_datos .= '<h2>Lugar: ' . utf8_encode($resultadoCompromisos['Lugar']) . '</h2>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha de inicio: </span>' . $fechaInicio .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Hora de inicio: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaInicio"])[1]), 'g:ia') .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha de finalización: </span>' . $fechaFinalizacion .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Hora de finalización: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaFinal"])[1]), 'g:ia') .'</p>';
                    $cadena_datos .= '</a>';
                    $cadena_datos .= '</li>';
                }
                else
                {
                    $cadena_datos .= '<li data-role="list-divider" style="font-size: 15px; background-color: #337AB7; color: #FFFFFF">' . utf8_encode($resultadoCompromisos['Descripcion']) . '</li>';
                    $cadena_datos .= '<li>';
                    $cadena_datos .= '<a href="#" onclick="UtiProcesosPaginaProcesosCompromisosDetalleModificar(' . $resultadoCompromisos['IdCompromiso'] . ')">';
                    $cadena_datos .= '<h2>Lugar: ' . utf8_encode($resultadoCompromisos['Lugar']) . '</h2>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha de inicio: </span>' . $fechaInicio .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Hora de inicio: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaInicio"])[1]), 'g:ia') .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Fecha de finalización: </span>' . $fechaFinalizacion .'</p>';
                    $cadena_datos .= '<p><span style="font-weight: bold">Hora de finalización: </span>' . date_format(date_create(explode(' ', $resultadoCompromisos["FechaFinal"])[1]), 'g:ia') .'</p>';
                    $cadena_datos .= '</a>';
                    $cadena_datos .= '</li>';
                }
            }
            $cadena_datos .= '</ul>';
        }
        else
        {
            $cadena_datos .= '<div class="alert alert-success" role="alert">';
            $cadena_datos .= '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    ';
            $cadena_datos .= 'Actualmente no tiene compromisos pendientes.';
            $cadena_datos .= '</div>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo compromiso
if (isset($_POST['action']) && $_POST['action'] == 'registrarCompromiso') {
    try {
        $tipoResponsable   = $_POST['tipoResposable'];
        $idMinisterio     = $_POST['idMinisterio'];
        $idTipoCompromiso = $_POST['idTipoCompromiso'];
        $descripcion      = $_POST['descripcion'];
        $fechaInicio      = $_POST['fechaInicio'];
        $fechaFinal       = $_POST['fechaFinal'];
        $lugar            = $_POST['lugar'];

        $listaPersonasResponsables = "";
        $listaGruposResponsables = "";

        if($tipoResponsable == 'P'){
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
            if($tipoResponsable == 'P') {
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
                        $sqlGrupoResponsable        = "CALL TbResponsablesGruposCompromisosAgregar('$grupoResponsable','$idCompromiso','$usuarioActual')";
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

// Se realiza la modificación de un compromiso existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarCompromiso') {
    try {
        $idCompromiso     = $_POST['idCompromiso'];
        $idMinisterio     = $_POST['idMinisterio'];
        $idTipoCompromiso = $_POST['idTipoCompromiso'];
        $descripcion      = $_POST['descripcion'];
        $lugar            = $_POST['lugar'];
        $fechaInicio      = $_POST['fechaInicio'];
        $fechaFinal       = $_POST['fechaFinal'];
        $tipoResponsable  = $_POST['tipoResponsable'];
        $estado           = $_POST['estado'];
        $usuarioActual    = $_SESSION['idPersona'];

        $tipoResponsableInicial = $_POST['tipoResponsableInicial'];

        $listaPersonasResponsablesAgregadas  = "";
        $listaPersonasResponsablesEliminadas = "";
        $listaGruposAgregados                = "";
        $listaGruposEliminados               = "";
        $listaParticipantesAgregados         = "";
        $listaParticipantesEliminados        = "";

        if($tipoResponsable == 'P'){
            $listaPersonasResponsablesAgregadas  = json_decode(stripslashes($_POST['listaPersonasResponsablesAgregadas']));
            $listaPersonasResponsablesEliminadas = json_decode(stripslashes($_POST['listaPersonasResponsablesEliminadas']));
        }
        else{
            $listaGruposAgregados  = json_decode(stripslashes($_POST['listaGruposResponsablesAgregados']));
            $listaGruposEliminados = json_decode(stripslashes($_POST['listaGruposResponsablesEliminados']));
        }
        $listaParticipantesAgregados  = json_decode(stripslashes($_POST['listaParticipantesAgregados']));
        $listaParticipantesEliminados = json_decode(stripslashes($_POST['listaParticipantesEliminados']));

        $sqlCompromiso = "CALL TbCompromisosModificar('$idCompromiso','$idMinisterio','$idTipoCompromiso','$descripcion','$fechaInicio','$fechaFinal','$lugar','$estado','$usuarioActual')";
        $consultaCompromiso = $db->consulta(utf8_decode($sqlCompromiso));

        if($tipoResponsable == 'P'){
            if(count($listaPersonasResponsablesAgregadas) > 0){
                foreach($listaPersonasResponsablesAgregadas as $personaResponsableAgregar){
                    $sqlPersonaResponsable      = "CALL TbResponsablesCompromisosAgregar('$personaResponsableAgregar','$idCompromiso','$usuarioActual')";
                    $consultaPersonaResponsable = $db->consulta(utf8_decode($sqlPersonaResponsable));

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
        else{
            if(count($listaGruposAgregados) > 0){
                foreach($listaGruposAgregados as $grupoResponsableAgregar){
                    $sqlGrupoResponsable        = "CALL TbResponsablesGruposCompromisosAgregar('$grupoResponsableAgregar','$idCompromiso','$usuarioActual')";
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

        if(count($listaParticipantesAgregados) > 0){
            foreach($listaParticipantesAgregados as $personaParticipanteAgregar){
                $sqlPersonaParticipante      = "CALL TbParticipantesCompromisosAgregar('$personaParticipanteAgregar','$idCompromiso','$usuarioActual')";
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

        if($tipoResponsable == 'P'){
            if(count($listaPersonasResponsablesEliminadas) > 0){
                foreach($listaPersonasResponsablesEliminadas as $personaResponsableEliminar){
                    $sqlPersonaResponsableEliminado      = "CALL TbResponsablesCompromisosEliminar('$personaResponsableEliminar','$idCompromiso')";
                    $consultaPersonaResponsableEliminado = $db->consulta(utf8_decode($sqlPersonaResponsableEliminado));
                }
            }
        }
        else{
            if(count($listaGruposEliminados) > 0){
                foreach($listaGruposEliminados as $grupoResponsableEliminar){
                    $sqlGrupoResponsableEliminado      = "CALL TbResponsablesGruposCompromisosEliminar('$grupoResponsableEliminar','$idCompromiso')";
                    $consultaGrupoResponsableEliminado = $db->consulta(utf8_decode($sqlGrupoResponsableEliminado));
                }
            }
        }

        if(count($listaParticipantesEliminados) > 0){
            foreach($listaParticipantesEliminados as $participanteEliminar){
                $sqlParticipanteEliminado      = "CALL TbParticipantesCompromisosEliminar('$participanteEliminar','$idCompromiso')";
                $consultaParticipanteEliminado = $db->consulta(utf8_decode($sqlParticipanteEliminado));
            }
        }

        if($tipoResponsable == 'P'
            && $tipoResponsableInicial == 'G'){
            $sqlGrupoResponsableEliminarTodos      = "CALL TbResponsablesGruposCompromisosEliminarTodosPorIdCompromiso('$idCompromiso')";
            $consultaGrupoResponsableEliminarTodos = $db->consulta(utf8_decode($sqlGrupoResponsableEliminarTodos));
        }

        if($tipoResponsable == 'G'
            && $tipoResponsableInicial == 'P'){
            $sqlPersonaResponsableEliminarTodos      = "CALL TbResponsablesCompromisosEliminarTodosPorIdCompromiso('$idCompromiso')";
            $consultaPersonaResponsableEliminarTodos = $db->consulta(utf8_decode($sqlPersonaResponsableEliminarTodos));
        }

        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un compromiso en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarCompromiso') {
    try {
        $idCompromiso = $_POST['idCompromiso'];

        $sqlCompromiso      = "CALL TbCompromisosListarPorIdCompromiso('$idCompromiso')";
        $consultaCompromiso = $db->consulta($sqlCompromiso);
        $cadena_datos       = "";

        $listaTotalPersonasResponsables = "";
        $listaTotalGruposResponsables   = "";
        $listaTotalParticipantes        = "";
        $tipoResponsableInicial         = "";

        $sqlMinisterios      = "CALL TbMinisteriosListar()";
        $consultaMinisterios = $db->consulta($sqlMinisterios);

        $sqlTipoCompromiso      = "CALL TbTiposCompromisosListar()";
        $consultaTipoCompromiso = $db->consulta($sqlTipoCompromiso);

        $sqlTotalResponsablesCompromiso      = "CALL TbPersonasListar()";
        $consultaTotalResponsablesCompromiso = $db->consulta($sqlTotalResponsablesCompromiso);

        $sqlResponsablesCompromiso      = "CALL TbResponsablesCompromisosListarPorIdCompromiso('$idCompromiso')";
        $consultaResponsablesCompromiso = $db->consulta($sqlResponsablesCompromiso);
        $arregloResponsablesCompromiso  = array();

        $sqlTotalResponsablesGruposCompromiso      = "CALL TbGruposListar()";
        $consultaTotalResponsablesGruposCompromiso = $db->consulta($sqlTotalResponsablesGruposCompromiso);

        $sqlResponsablesGruposCompromiso      = "CALL TbResponsablesGruposCompromisosListarPorIdCompromiso('$idCompromiso')";
        $consultaResponsablesGruposCompromiso = $db->consulta($sqlResponsablesGruposCompromiso);
        $arregloResponsablesGruposCompromiso  = array();

        $sqlParticipantesCompromiso      = "CALL TbParticipantesCompromisosListarPorIdCompromiso('$idCompromiso')";
        $consultaParticipantesCompromiso = $db->consulta($sqlParticipantesCompromiso);
        $arregloParticipantesCompromiso = array();

        $sqlTotalParticipantesCompromiso      = "CALL TbPersonasListar()";
        $consultaTotalParticipantesCompromiso = $db->consulta($sqlTotalParticipantesCompromiso);

        if($db->num_rows($consultaResponsablesCompromiso) != 0)
        {
            while ($resultadosResponsablesCompromiso = $db->fetch_array($consultaResponsablesCompromiso))
            {
                array_push($arregloResponsablesCompromiso, $resultadosResponsablesCompromiso["IdPersona"]);
            }
        }

        if($db->num_rows($consultaResponsablesGruposCompromiso) != 0)
        {
            while($resultadosResponsablesGruposCompromiso = $db->fetch_array($consultaResponsablesGruposCompromiso))
            {
                array_push($arregloResponsablesGruposCompromiso, $resultadosResponsablesGruposCompromiso["IdGrupo"]);
            }
        }

        if($db->num_rows($consultaParticipantesCompromiso) != 0)
        {
            while($resultadosParticipantesGruposCompromiso = $db->fetch_array($consultaParticipantesCompromiso))
            {
                array_push($arregloParticipantesCompromiso, $resultadosParticipantesGruposCompromiso["IdPersona"]);
            }
        }

        if($db->num_rows($consultaCompromiso) != 0)
        {
            while($resultadosCompromiso = $db->fetch_array($consultaCompromiso))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdMinisterios">Ministerio:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdMinisterios" id="cboIdMinisterios">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaMinisterios) != 0)
                {
                    while($resultadosMinisterios = $db->fetch_array($consultaMinisterios))
                    {
                        if ($resultadosMinisterios['IdMinisterio'] == $resultadosCompromiso['IdMinisterio']){
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
                $cadena_datos .= '<label for="cboIdTiposCompromisos">Tipo de compromiso:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdTiposCompromisos" id="cboIdTiposCompromisos">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaTipoCompromiso) != 0)
                {
                    while($resultadosTipoCompromiso = $db->fetch_array($consultaTipoCompromiso))
                    {
                        if ($resultadosTipoCompromiso['IdTipoCompromiso'] == $resultadosCompromiso['IdTipoCompromiso']){
                            $cadena_datos .= '<option value="' . $resultadosTipoCompromiso['IdTipoCompromiso'] . '" selected>' . utf8_encode($resultadosTipoCompromiso['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosTipoCompromiso['IdTipoCompromiso'] . '">' . utf8_encode($resultadosTipoCompromiso['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDescripcionCompromiso">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionCompromiso" id="txtDescripcionCompromiso" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultadosCompromiso['Descripcion']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaInicio">Fecha y hora de inicio:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="datetime-local" name="txtFechaInicio" id="txtFechaInicio" data-clear-btn="true" value="' . explode(' ', utf8_encode($resultadosCompromiso['FechaInicio']))[0] . 'T' . explode(' ', utf8_encode($resultadosCompromiso['FechaInicio']))[1] . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaFinal">Fecha y hora de fin:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="datetime-local" name="txtFechaFinal" id="txtFechaFinal" data-clear-btn="true" value="' . explode(' ', utf8_encode($resultadosCompromiso['FechaFinal']))[0] . 'T' . explode(' ', utf8_encode($resultadosCompromiso['FechaFinal']))[1] . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtLugar">Lugar:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtLugar" id="txtLugar" maxlength="100" data-clear-btn="true" value="' . utf8_encode($resultadosCompromiso['Lugar']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtTipoResponsable">Tipo de responsable:</label>';
                $cadena_datos .= '<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" class="text-center" onchange="CompromisosCambiarTipoResponsable()">';
                if(count($arregloResponsablesCompromiso) > 0
                    && count($arregloResponsablesGruposCompromiso) == 0)
                {
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="persona" value="P" checked="checked">';
                    $cadena_datos .= '<label for="persona">Personas</label>';
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="grupo" value="G">';
                    $cadena_datos .= '<label for="grupo">Grupos</label>';
                    $tipoResponsableInicial = "P";
                }
                elseif(count($arregloResponsablesCompromiso) == 0
                    && count($arregloResponsablesGruposCompromiso) > 0)
                {
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="persona" value="P">';
                    $cadena_datos .= '<label for="persona">Personas</label>';
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="grupo" value="G" checked="checked">';
                    $cadena_datos .= '<label for="grupo">Grupos</label>';
                    $tipoResponsableInicial = "G";
                }
                elseif(count($arregloResponsablesCompromiso) == 0
                    && count($arregloResponsablesGruposCompromiso) == 0)
                {
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="persona" value="P" checked="checked">';
                    $cadena_datos .= '<label for="persona">Personas</label>';
                    $cadena_datos .= '<input type="radio" name="tipoResponsable" id="grupo" value="G">';
                    $cadena_datos .= '<label for="grupo">Grupos</label>';
                    $tipoResponsableInicial = "N";
                }
                $cadena_datos .= '</fieldset>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfTipoResponsable" id="hdfTipoResponsable" value="' . $tipoResponsableInicial .'">';
                $cadena_datos .= '<div id="divCompromisosPersonasResponsables">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<label for="CompromisosPersonasResponsables">Personas reponsables:</label>';
                $cadena_datos .= '<select name="CompromisosPersonasResponsables" id="CompromisosPersonasResponsables" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalResponsablesCompromiso) != 0)
                {
                    while($resultadosResponsablesCompromiso = $db->fetch_array($consultaTotalResponsablesCompromiso))
                    {
                        if(in_array($resultadosResponsablesCompromiso['IdPersona'], $arregloResponsablesCompromiso))
                        {
                            $cadena_datos .= '<option value="' . $resultadosResponsablesCompromiso['IdPersona'] . '" selected>' . utf8_encode($resultadosResponsablesCompromiso['NombreCompleto']) . '</option>';
                            $listaTotalPersonasResponsables .= $resultadosResponsablesCompromiso['IdPersona'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosResponsablesCompromiso['IdPersona'] . '">' . utf8_encode($resultadosResponsablesCompromiso['NombreCompleto']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfPersonasResponsables" id="hdfPersonasResponsables" value="' . substr($listaTotalPersonasResponsables,0,strlen($listaTotalPersonasResponsables)-1) . '">';
                $cadena_datos .= '<div id="divCompromisosGruposResponsables">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<label for="CompromisosGruposResponsables">Grupos responsables:</label>';
                $cadena_datos .= '<select name="CompromisosGruposResponsables" id="CompromisosGruposResponsables" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalResponsablesGruposCompromiso) != 0)
                {
                    while($resultadosResponsablesGruposCompromiso = $db->fetch_array($consultaTotalResponsablesGruposCompromiso))
                    {
                        if(in_array($resultadosResponsablesGruposCompromiso['IdGrupo'], $arregloResponsablesGruposCompromiso))
                        {
                            $cadena_datos .= '<option value="' . $resultadosResponsablesGruposCompromiso['IdGrupo'] . '" selected>' . utf8_encode($resultadosResponsablesGruposCompromiso['Descripcion']) . '</option>';
                            $listaTotalGruposResponsables .= $resultadosResponsablesGruposCompromiso['IdGrupo'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosResponsablesGruposCompromiso['IdGrupo'] . '">' . utf8_encode($resultadosResponsablesGruposCompromiso['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfGruposResponsables" id="hdfGruposResponsables" value="' . substr($listaTotalGruposResponsables,0,strlen($listaTotalGruposResponsables)-1) . '">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div id="divCompromisosPersonasParticipantes">';
                $cadena_datos .= '<label for="CompromisosPersonasParticipantes">Personas participantes:</label>';
                $cadena_datos .= '<select name="CompromisosPersonasParticipantes" id="CompromisosPersonasParticipantes" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalParticipantesCompromiso) != 0)
                {
                    while($resultadosParticipantesCompromiso = $db->fetch_array($consultaTotalParticipantesCompromiso))
                    {
                        if(in_array($resultadosParticipantesCompromiso['IdPersona'], $arregloParticipantesCompromiso))
                        {
                            $cadena_datos .= '<option value="' . $resultadosParticipantesCompromiso['IdPersona'] . '" selected>' . utf8_encode($resultadosParticipantesCompromiso['NombreCompleto']) . '</option>';
                            $listaTotalParticipantes .= $resultadosParticipantesCompromiso['IdPersona'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosParticipantesCompromiso['IdPersona'] . '">' . utf8_encode($resultadosParticipantesCompromiso['NombreCompleto']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfParticipantes" id="hdfParticipantes" value="' . substr($listaTotalParticipantes,0,strlen($listaTotalParticipantes)-1) . '">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoCompromiso">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoCompromiso" id="cboEstadoCompromiso">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultadosCompromiso['Estado'] == 'A'){
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
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="CompromisoModificarCompromiso(' . $resultadosCompromiso['IdCompromiso'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-edit">Modificar</button>';
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