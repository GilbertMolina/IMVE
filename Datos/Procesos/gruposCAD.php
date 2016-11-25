<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 11/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de grupos del sistema para mostrarlos en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoGruposPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sqlGrupo         = "CALL TbGruposListarPorEstado('$estado')";
        $consultaGrupo    = $db->consulta($sqlGrupo);
        $consultaAcciones = $db->consulta($sqlGrupo);
        $cadena_datos     = "";

        $cadena_datos .= '<ul data-role="listview" id="listaGrupos" data-filter="true" data-input="#filtro" data-split-icon="gear" data-autodividers="true" data-inset="true">';
        
        if($db->num_rows($consultaGrupo) != 0)
        {
            while($resultados = $db->fetch_array($consultaGrupo))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosGruposDetalleModificar(' . $resultados['IdGrupo'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a><a href="#acciones_'. $resultados['IdGrupo'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a></li>';
            }
            $cadena_datos .= '</ul>';

            while($resultadosGrupo = $db->fetch_array($consultaAcciones))
            {
                $idGrupo             = $resultadosGrupo['IdGrupo'];
                $smsPersonas         = "";
                $smsFinalPersonas    = "";
                $correoPersonas      = "";
                $correoFinalPersonas = "";
                $nombreGrupo         = "";

                $sqlPersonasGrupo      = "CALL TbGruposPersonasListarPersonasPorIdGrupo('$idGrupo')";
                $consultaPersonasGrupo = $db->consulta($sqlPersonasGrupo);
                $arregloPersonasGrupo  = array();

                if($db->num_rows($consultaPersonasGrupo) != 0)
                {
                    while($resultadosPersonasGrupo = $db->fetch_array($consultaPersonasGrupo))
                    {
                        $nombreGrupo = $resultadosPersonasGrupo["Descripcion"];

                        if ($resultadosPersonasGrupo["Celular"] != "")
                        {
                            $smsPersonas .= $resultadosPersonasGrupo["Celular"] . ';';
                        }
                        if ($resultadosPersonasGrupo["Correo"] != "")
                        {
                            $correoPersonas .= $resultadosPersonasGrupo["Correo"] . ';';
                        }
                    }

                    // Quitar el punto y coma del final
                    $smsFinalPersonas = substr($smsPersonas,0,strlen($smsPersonas)-1);
                    $correoFinalPersonas = substr($correoPersonas,0,strlen($correoPersonas)-1);

                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $idGrupo . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';
                    $cadena_datos .= '<hr>';

                    if($smsFinalPersonas == ""
                        && $correoFinalPersonas == ""){
                        $cadena_datos .= '<p>Lo sentimos, las personas de ' . $nombreGrupo . ' no tiene asociado un número de teléfono móvil, ni un correo electrónico con el cual se puedan contactar.</p>';
                    }
                    else{
                        $cadena_datos .= '<p>Estas son las acciones disponibles para ' . $nombreGrupo . ':</p>';
                    }

                    if($smsFinalPersonas != ""){
                        $cadena_datos .= '<p style="margin-bottom: -15px;"><a href="sms:' . $smsFinalPersonas . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-comment ui-btn-icon-left ui-btn-inline ui-mini">Enviar SMS a todos los integrantes</a></p>';
                    }
                    if($correoFinalPersonas != ""){
                        $cadena_datos .= '<p><a href="mailto:' . $correoFinalPersonas . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Enviar Correo a todos los integrantes</a></p>';
                    }
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';
                    $cadena_datos .= '</div>';
                }
                else
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $idGrupo . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';
                    $cadena_datos .= '<hr>';
                    $cadena_datos .= '<p>Lo sentimos, el grupo no tiene líderes, ni participantes.</p>';
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';
                    $cadena_datos .= '</div>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay grupos para mostrar en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de personas de los grupos filtrados por si es lider o no para mostrarlas en un campo de select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoGruposPersonasEsLider') {
    try {
        $contacto       = $_POST['contacto'];
        $tipoIntegrante = $_POST['tipoIntegrante'];

        $sqlGrupo      = "CALL TbGruposPersonasListarPorEsLider('$tipoIntegrante')";
        $consultaGrupo = $db->consulta($sqlGrupo);
        $cadena_datos  = "";

        $mensajeDinamico = "";

        if($tipoIntegrante == 'S')
        {
            $mensajeDinamico = "todos los líderes";
        }
        elseif($tipoIntegrante == 'N')
        {
            $mensajeDinamico = "todos los participantes";
        }
        else
        {
            $mensajeDinamico = "todos los líderes y participantes";
        }

        $cadena_datos .= '<label for="accionesSeleccionGrupos" style="margin-top: 30px">Lista de ' . $mensajeDinamico . ' para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionGrupos" id="accionesSeleccionGrupos" data-filter="true" data-input="#filtroSeleccion" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="GruposAccionesSeleccionarIntegrantes()">';

        if($db->num_rows($consultaGrupo) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultadosGrupo = $db->fetch_array($consultaGrupo))
            {
                if ($contacto == 'S'){
                    if($resultadosGrupo['Celular'] != ''){
                        $cadena_datos .= '<option value="' . $resultadosGrupo['Celular'] . '">' . utf8_encode($resultadosGrupo['NombreCompleto']) . '</option>';
                    }
                }
                else{
                    if($resultadosGrupo['Correo'] != ''){
                        $cadena_datos .= '<option value="' . $resultadosGrupo['Correo'] . '">' . utf8_encode($resultadosGrupo['NombreCompleto']) . '</option>';
                    }
                }
            }
            $cadena_datos .= '</select>';
        }
        else
        {
            $cadena_datos .= '<option>No hay personas para mostrar</option>';
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
        $idCategoriaGrupo           = $_POST['idCategoriaGrupo'];
        $idMinisterio               = $_POST['idMinisterio'];
        $descripcion                = $_POST['descripcion'];
        $listaPersonasLideres       = json_decode(stripslashes($_POST['listaPersonasLideres']));
        $listaPersonasParticipantes = json_decode(stripslashes($_POST['listaPersonasParticipantes']));
        $usuarioActual              = $_SESSION['idPersona'];
        $idGrupo                    = "";

        $sqlGrupo = "CALL TbGruposAgregar('$idCategoriaGrupo','$idMinisterio','$descripcion','$usuarioActual')";
        $consultaGrupo = $db->consulta(utf8_decode($sqlGrupo));

        if ($db->num_rows($consultaGrupo) != 0) {
            while ($resultados = $db->fetch_array($consultaGrupo)) {
                $idGrupo = $resultados['Id'];
                $exito   = "1";
            }

        } else {
            $exito = "-1";
        }

        if ($exito == "1"){
            if(count($listaPersonasLideres) > 0){
                foreach($listaPersonasLideres as $personaLider){
                    $sqlGrupoPersona              = "CALL TbGruposPersonasAgregar('$personaLider','$idGrupo','S','$usuarioActual')";
                    $consultaGrupoPersonasLideres = $db->consulta(utf8_decode($sqlGrupoPersona));

                    if ($db->num_rows($consultaGrupoPersonasLideres) != 0) {
                        while ($resultadosGrupoPersonaLider = $db->fetch_array($consultaGrupoPersonasLideres)) {
                            $idGrupoPersona = $resultadosGrupoPersonaLider['Id'];
                            $exito          = "1";
                        }
                    } else {
                        $exito = "-1";
                    }
                }
            }

            if(count($listaPersonasParticipantes) > 0){
                foreach($listaPersonasParticipantes as $personaParticipante){
                    $sqlGrupoPersona                    = "CALL TbGruposPersonasAgregar('$personaParticipante','$idGrupo','N','$usuarioActual')";
                    $consultaGrupoPersonasParticipantes = $db->consulta(utf8_decode($sqlGrupoPersona));

                    if ($db->num_rows($consultaGrupoPersonasParticipantes) != 0) {
                        while ($resultadosGrupoPersonaParticipante = $db->fetch_array($consultaGrupoPersonasParticipantes)) {
                            $idGrupoPersona = $resultadosGrupoPersonaParticipante['Id'];
                            $exito          = "1";
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

// Se realiza la modificación de un grupo existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarGrupo') {
    try {
        $idGrupo          = $_POST['idGrupo'];
        $idCategoriaGrupo = $_POST['idCategoriaGrupo'];
        $idMinisterio     = $_POST['idMinisterio'];
        $descripcion      = $_POST['descripcion'];
        $estado           = $_POST['estado'];
        $usuarioActual    = $_SESSION['idPersona'];

        $listaPersonasLideresAgregado         = json_decode(stripslashes($_POST['listaPersonasLideresAgregado']));
        $listaPersonasParticipantesAgregado   = json_decode(stripslashes($_POST['listaPersonasParticipantesAgregado']));
        $listaPersonasLideresEliminados       = json_decode(stripslashes($_POST['listaPersonasLideresEliminados']));
        $listaPersonasParticipantesEliminados = json_decode(stripslashes($_POST['listaPersonasParticipantesEliminados']));

        $sqlGrupo = "CALL TbGruposModificar('$idGrupo', '$idCategoriaGrupo','$idMinisterio','$descripcion','$estado','$usuarioActual')";
        $consultaGrupo = $db->consulta(utf8_decode($sqlGrupo));

        if(count($listaPersonasLideresAgregado) > 0){
            foreach($listaPersonasLideresAgregado as $personaGrupoLiderAgregar){
                $sqlPersonaGrupoLiderAgregar  = "CALL TbGruposPersonasAgregar('$personaGrupoLiderAgregar','$idGrupo','S','$usuarioActual')";
                $consultaPersonasLiderAgregar = $db->consulta(utf8_decode($sqlPersonaGrupoLiderAgregar));

                if ($db->num_rows($consultaPersonasLiderAgregar) != 0) {
                    while ($resultadosPersonaGruposLiderAgregar = $db->fetch_array($consultaPersonasLiderAgregar)) {
                        $idPersonaGrupoLiderAgregado = $resultadosPersonaGruposLiderAgregar['Id'];
                        $exito                       = "1";
                    }
                } else {
                    $exito = "-1";
                }
            }
        }

        if(count($listaPersonasParticipantesAgregado) > 0){
            foreach($listaPersonasParticipantesAgregado as $personaGrupoParticipanteAgregar){
                $sqlPersonaGrupoParticipanteAgregar  = "CALL TbGruposPersonasAgregar('$personaGrupoParticipanteAgregar','$idGrupo','N','$usuarioActual')";
                $consultaPersonasParticipanteAgregar = $db->consulta(utf8_decode($sqlPersonaGrupoParticipanteAgregar));

                if ($db->num_rows($consultaPersonasParticipanteAgregar) != 0) {
                    while ($resultadosPersonaGruposParticipanteAgregar = $db->fetch_array($consultaPersonasParticipanteAgregar)) {
                        $idPersonaGrupoParticipanteAgregado = $resultadosPersonaGruposParticipanteAgregar['Id'];
                        $exito                              = "1";
                    }
                } else {
                    $exito = "-1";
                }
            }
        }

        if(count($listaPersonasLideresEliminados) > 0){
            foreach($listaPersonasLideresEliminados as $personaGrupoLiderEliminado){
                $sqlPersonaGrupoLiderEliminado = "CALL TbGruposPersonasModificar('$personaGrupoLiderEliminado','$idGrupo','S','$usuarioActual')";
                $consultaPersonaLiderEliminado = $db->consulta(utf8_decode($sqlPersonaGrupoLiderEliminado));
            }
        }

        if(count($listaPersonasParticipantesEliminados) > 0){
            foreach($listaPersonasParticipantesEliminados as $personaGrupoParticipanteEliminado){
                $sqlPersonaGrupoParticipanteEliminado = "CALL TbGruposPersonasModificar('$personaGrupoParticipanteEliminado','$idGrupo','N','$usuarioActual')";
                $consultaPersonaParticipanteEliminado = $db->consulta(utf8_decode($sqlPersonaGrupoParticipanteEliminado));
            }
        }
        
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

        $sqlGrupo      = "CALL TbGruposListarPorIdGrupo('$idGrupo')";
        $consultaGrupo = $db->consulta($sqlGrupo);
        $cadena_datos  = "";

        $listaTodalGruposPersonasLider = "";
        $listaTodalGruposPersonasParticipante = "";

        $smsLideres               = "";
        $smsFinalLideres          = "";
        $correoLideres            = "";
        $correoFinalLideres       = "";
        $smsParticipantes         = "";
        $smsFinalParticipantes    = "";
        $correoParticipantes      = "";
        $correoFinalParticipantes = "";

        $sqlCategoriasGrupos      = "CALL TbCategoriasGruposListar()";
        $consultaCategoriasGrupos = $db->consulta($sqlCategoriasGrupos);

        $sqlMinisterios      = "CALL TbMinisteriosListar()";
        $consultaMinisterios = $db->consulta($sqlMinisterios);

        $sqlTotalPersonasLideres      = "CALL TbPersonasListar()";
        $consultaTotalPersonasLideres = $db->consulta($sqlTotalPersonasLideres);

        $sqlTotalPersonasParticipantes      = "CALL TbPersonasListar()";
        $consultaTotalPersonasParticipantes = $db->consulta($sqlTotalPersonasParticipantes);

        $sqlPersonasLideres      = "CALL TbGruposPersonasListarPorIdGrupoLideres('$idGrupo')";
        $consultaPersonasLideres = $db->consulta($sqlPersonasLideres);
        $arregloPersonasLideres  = array();

        $sqlPersonasParticipantes      = "CALL TbGruposPersonasListarPorIdGrupoParticipantes('$idGrupo')";
        $consultaPersonasParticipantes = $db->consulta($sqlPersonasParticipantes);
        $arregloPersonasParticipantes  = array();

        if($db->num_rows($consultaPersonasLideres) != 0)
        {
            while($resultadosPersonasLideres = $db->fetch_array($consultaPersonasLideres))
            {
                array_push($arregloPersonasLideres, $resultadosPersonasLideres["PersonaLider"]);
                if ($resultadosPersonasLideres["Celular"] != "")
                {
                    $smsLideres .= $resultadosPersonasLideres["Celular"] . ';';
                }
                if ($resultadosPersonasLideres["Correo"] != "")
                {
                    $correoLideres .= $resultadosPersonasLideres["Correo"] . ';';
                }
            }
            // Quitar el punto y coma del final
            $smsFinalLideres = substr($smsLideres,0,strlen($smsLideres)-1);
            $correoFinalLideres = substr($correoLideres,0,strlen($correoLideres)-1);
        }

        if($db->num_rows($consultaPersonasParticipantes) != 0)
        {
            while($resultadosPersonasParticipantes = $db->fetch_array($consultaPersonasParticipantes))
            {
                array_push($arregloPersonasParticipantes, $resultadosPersonasParticipantes["PersonaParticipante"]);
                if ($resultadosPersonasParticipantes["Celular"] != "")
                {
                    $smsParticipantes .= $resultadosPersonasParticipantes["Celular"] . ';';
                }
                if ($resultadosPersonasParticipantes["Correo"] != "")
                {
                    $correoParticipantes .= $resultadosPersonasParticipantes["Correo"] . ';';
                }
            }
            // Quitar el punto y coma del final
            $smsFinalParticipantes = substr($smsParticipantes,0,strlen($smsParticipantes)-1);
            $correoFinalParticipantes = substr($correoParticipantes,0,strlen($correoParticipantes)-1);
        }

        if($db->num_rows($consultaGrupo) != 0)
        {
            while($resultados = $db->fetch_array($consultaGrupo))
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
                $cadena_datos .= '<div id="divGrupoPersonasLider">';
                $cadena_datos .= '<label for="GrupoPersonasLideres">Personas que son lideres del grupo:</label>';
                $cadena_datos .= '<select name="GrupoPersonasLideres" id="GrupoPersonasLideres" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalPersonasLideres) != 0)
                {
                    while($resultadosPersonasLideres= $db->fetch_array($consultaTotalPersonasLideres))
                    {
                        if(in_array($resultadosPersonasLideres['IdPersona'], $arregloPersonasLideres))
                        {
                            $cadena_datos .= '<option value="' . $resultadosPersonasLideres['IdPersona'] . '" selected>' . utf8_encode($resultadosPersonasLideres['NombreCompleto']) . '</option>';
                            $listaTodalGruposPersonasLider .= $resultadosPersonasLideres['IdPersona'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosPersonasLideres['IdPersona'] . '">' . utf8_encode($resultadosPersonasLideres['NombreCompleto']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfGruposPersonaLider" id="hdfGruposPersonaLider" value="' . substr($listaTodalGruposPersonasLider,0,strlen($listaTodalGruposPersonasLider)-1) . '">';
                $cadena_datos .= '<br>';
                if($smsFinalLideres != ""
                    || $correoFinalLideres != ""){
                    $cadena_datos .= '<div>';
                    $cadena_datos .= '<label for="ContactoLideres">Contactar a los líderes:</label>';
                    $cadena_datos .= '<div class="text-center" style="margin-top: -5px">';

                    if($smsFinalLideres != ""){
                        $cadena_datos .= '<a href="sms:' . $smsFinalLideres . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">SMS</a>';
                    }

                    if($correoFinalLideres != ""){
                        $cadena_datos .= '<a href="mailto:' . $correoFinalLideres . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Correo</a>';
                    }
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '<br>';
                }
                $cadena_datos .= '<div id="divGrupoPersonasParticipantes">';
                $cadena_datos .= '<label for="GrupoPersonasParticipantes">Personas que participan en el grupo:</label>';
                $cadena_datos .= '<select name="GrupoPersonasParticipantes" id="GrupoPersonasParticipantes" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalPersonasParticipantes) != 0)
                {
                    while($resultadosGruposParticipantes= $db->fetch_array($consultaTotalPersonasParticipantes))
                    {
                        if(in_array($resultadosGruposParticipantes['IdPersona'], $arregloPersonasParticipantes))
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposParticipantes['IdPersona'] . '" selected>' . utf8_encode($resultadosGruposParticipantes['NombreCompleto']) . '</option>';
                            $listaTodalGruposPersonasParticipante .= $resultadosGruposParticipantes['IdPersona'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposParticipantes['IdPersona'] . '">' . utf8_encode($resultadosGruposParticipantes['NombreCompleto']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfGruposPersonaParticipante" id="hdfGruposPersonaParticipante" value="' . substr($listaTodalGruposPersonasParticipante,0,strlen($listaTodalGruposPersonasParticipante)-1) . '">';
                $cadena_datos .= '<br>';
                if($smsFinalParticipantes != ""
                    || $correoFinalParticipantes != ""){
                    $cadena_datos .= '<div>';
                    $cadena_datos .= '<label for="ContactoLideres">Contactar a los participantes:</label>';
                    $cadena_datos .= '<div class="text-center" style="margin-top: -5px">';
                    if($smsFinalParticipantes != ""){
                        $cadena_datos .= '<a href="sms:' . $smsFinalParticipantes . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">SMS</a>';
                    }

                    if($correoFinalParticipantes != ""){
                        $cadena_datos .= '<a href="mailto:' . $correoFinalParticipantes . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Correo</a>';
                    }
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '<br>';
                }
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
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="GruposModificarGrupo(' . $resultados['IdGrupo'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-edit">Modificar</button>';
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

// Obtiene los grupos activos del sistema para mostrarlos en el select de participantes
if (isset($_POST['action']) && $_POST['action'] == 'obtenerGruposParticipantesListado') {
    try {
        $sqlGrupo      = "CALL TbGruposListar()";
        $consultaGrupo = $db->consulta($sqlGrupo);
        $cadena_datos  = "";

        if($db->num_rows($consultaGrupo) != 0)
        {
            $cadena_datos = '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consultaGrupo))
            {
                $cadena_datos .= '<option value="' . $resultados['IdGrupo'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene los grupos activos del sistema para mostrarlos en el select de lideres
if (isset($_POST['action']) && $_POST['action'] == 'obtenerGruposLideresListado') {
    try {
        $sqlGrupo      = "CALL TbGruposListar()";
        $consultaGrupo = $db->consulta($sqlGrupo);
        $cadena_datos  = "";

        if($db->num_rows($consultaGrupo) != 0)
        {
            $cadena_datos = '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consultaGrupo))
            {
                $cadena_datos .= '<option value="' . $resultados['IdGrupo'] . '">' . utf8_encode($resultados['Descripcion']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

