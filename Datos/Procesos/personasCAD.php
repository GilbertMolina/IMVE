<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de personas del sistema para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasPorOrdenamientoEstado') {
    try {
        $ordenamiento = $_POST['ordenamiento'];
        $estado       = $_POST['estado'];

        $sqlPersona        = "CALL TbPersonasListarPorOrdenamientoEstado('$ordenamiento', '$estado')";
        $consultaPersona   = $db->consulta($sqlPersona);
        $consultaAcciones  = $db->consulta($sqlPersona);
        $cadena_datos      = "";

        $cadena_datos .= '<ul data-role="listview" id="listaPersonas" data-filter="true" data-input="#filtro" data-split-icon="gear" data-autodividers="true" data-inset="true">';

        if($db->num_rows($consultaPersona) != 0)
        {
            while($resultadosPersona = $db->fetch_array($consultaPersona))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosPersonasDetalleModificar(' . $resultadosPersona['IdPersona'] . ')">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</a><a href="#acciones_'. $resultadosPersona['IdPersona'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a></li>';
            }
            $cadena_datos .= '</ul>';

            if($db->num_rows($consultaAcciones) != 0)
            {
                while($resultadosAcciones = $db->fetch_array($consultaAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadosAcciones['IdPersona'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';
                    $cadena_datos .= '<hr>';

                    if($resultadosAcciones['Telefono'] == ""
                        && $resultadosAcciones['Celular'] == ""
                        && $resultadosAcciones['Correo'] == ""){
                        $cadena_datos .= '<p>Lo sentimos, ' . $resultadosAcciones['NombreCompleto'] . ' no tiene asociado un número de teléfono fijo, un número de teléfono móvil, ni un correo electrónico con el cual se pueda contactar.</p>';
                    }
                    else{
                        $cadena_datos .= '<p>Estas son las acciones disponibles para ' . $resultadosAcciones['NombreCompleto'] . ':</p>';
                    }

                    if($resultadosAcciones['Telefono'] != ""){
                        $cadena_datos .= '<p style="margin-bottom: -15px;"><a href="tel:' . $resultadosAcciones['Telefono'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Llamar a teléfono fijo</a></p>';
                    }
                    if($resultadosAcciones['Celular'] != ""){
                        $cadena_datos .= '<p style="margin-bottom: -15px;"><a href="tel:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Llamar a teléfono móvil</a></p>';
                        $cadena_datos .= '<p style="margin-bottom: -15px;"><a href="sms:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-comment ui-btn-icon-left ui-btn-inline ui-mini">Enviar SMS</a></p>';
                    }
                    if($resultadosAcciones['Correo'] != ""){
                        $cadena_datos .= '<p><a href="mailto:' . $resultadosAcciones['Correo'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Enviar Correo</a></p>';
                    }
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';
                    $cadena_datos .= '</div>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay personas para mostrar en la agenda en este estado.</li>';
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de personas del sistema para mostrarlas en un campo de select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasCelularesCorreos') {
    try {
        $accion = $_POST['accion'];

        $sqlPersona        = "CALL TbPersonasListarCelularesCorreos('$accion')";
        $consultaPersona   = $db->consulta($sqlPersona);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonas" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonas" id="accionesSeleccionPersonas" data-filter="true" data-input="#filtroSeleccion" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarPersonas()">';

        if($db->num_rows($consultaPersona) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultadosPersona = $db->fetch_array($consultaPersona))
            {
                if ($accion == 'S'){
                    $cadena_datos .= '<option value="' . $resultadosPersona['Celular'] . '">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</option>';
                }
                else{
                    $cadena_datos .= '<option value="' . $resultadosPersona['Correo'] . '">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</option>';
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

// Obtiene el listado de personas filtradas por estado para mostrarlas en un campo de select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasFiltradasPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sqlPersona        = "CALL TbPersonasListarActivosInactivos('$estado')";
        $consultaPersona   = $db->consulta($sqlPersona);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonasActivarDesactivar" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonasActivarDesactivar" id="accionesSeleccionPersonasActivarDesactivar" data-filter="true" data-input="#filtroSeleccionActivasDesactivas" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarActivarDesactivarPersonas()">';

        if($db->num_rows($consultaPersona) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultadosPersona = $db->fetch_array($consultaPersona))
            {
                $cadena_datos .= '<option value="' . $resultadosPersona['IdPersona'] . '">' . utf8_encode($resultadosPersona['NombreCompleto']) . '</option>';
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

// Se actualiza el estado de personas
if (isset($_POST['action']) && $_POST['action'] == 'modificarEstadoPersonas') {
    try {
        $estado        = $_POST['estado'];
        $listaPersonas = json_decode(stripslashes($_POST['listaPersonas']));
        $usuarioActual = $_SESSION['idPersona'];

        foreach($listaPersonas as $persona){
            $sqlPersona      = "CALL TbPersonasActualizarEstado('$estado','$persona','$usuarioActual')";
            $consultaPersona = $db->consulta(utf8_decode($sqlPersona));
        }
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de una nueva persona en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'registrarPersona') {
    try {
        $identificacion          = $_POST['identificacion'];
        $nombre                  = $_POST['nombre'];
        $apellido1               = $_POST['apellido1'];
        $apellido2               = $_POST['apellido2'];
        $fechaNacimiento         = $_POST['fechaNacimiento'];
        $distrito                = $_POST['distrito'];
        $direccionDomicilio      = $_POST['direccionDomicilio'];
        $telefono                = $_POST['telefono'];
        $celular                 = $_POST['celular'];
        $correo                  = $_POST['correo'];
        $sexo                    = $_POST['sexo'];
        $listaGruposLider        = json_decode(stripslashes($_POST['listaGruposLider']));
        $listaGruposParticipante = json_decode(stripslashes($_POST['listaGruposParticipante']));
        $usuarioActual           = $_SESSION['idPersona'];
        $idPersona               = "";

        $sqlPersona      = "CALL TbPersonasAgregar('$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$correo','$sexo','$usuarioActual')";
        $consultaPersona = $db->consulta($sqlPersona);

        if ($db->num_rows($consultaPersona) != 0) {
            while ($resultadosPersona = $db->fetch_array($consultaPersona)) {
                $idPersona = $resultadosPersona['Id'];
                $exito     = "1";
            }

        } else {
            $exito = "-1";
        }

        if ($exito == "1"){
            if(count($listaGruposLider) > 0){
                foreach($listaGruposLider as $grupoPersonaLider){
                    $sqlGrupoPersona     = "CALL TbGruposPersonasAgregar('$idPersona','$grupoPersonaLider','S',$usuarioActual)";
                    $consultaGruposLider = $db->consulta(utf8_decode($sqlGrupoPersona));

                    if ($db->num_rows($consultaGruposLider) != 0) {
                        while ($resultadosGruposPersonaLider = $db->fetch_array($consultaGruposLider)) {
                            $idGrupoPersona = $resultadosGruposPersonaLider['Id'];
                            $exito          = "1";
                        }
                    } else {
                        $exito = "-1";
                    }
                }
            }

            if(count($listaGruposParticipante) > 0) {
                foreach($listaGruposParticipante as $grupoPersonaParticipante){
                    $sqlGrupoPersona            = "CALL TbGruposPersonasAgregar('$idPersona','$grupoPersonaParticipante','N',$usuarioActual)";
                    $consultaGruposParticipante = $db->consulta(utf8_decode($sqlGrupoPersona));

                    if ($db->num_rows($consultaGruposParticipante) != 0) {
                        while ($resultadosGruposPersonaParticipante = $db->fetch_array($consultaGruposParticipante)) {
                            $idGrupoPersona = $resultadosGruposPersonaParticipante['Id'];
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

// Se realiza la modificación de una persona existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarPersona') {
    try {
        $idPersona           = $_POST['idPersona'];
        $identificacion      = $_POST['identificacion'];
        $nombre              = $_POST['nombre'];
        $apellido1           = $_POST['apellido1'];
        $apellido2           = $_POST['apellido2'];
        $fechaNacimiento     = $_POST['fechaNacimiento'];
        $distrito            = $_POST['distrito'];
        $direccionDomicilio  = $_POST['direccionDomicilio'];
        $telefono            = $_POST['telefono'];
        $celular             = $_POST['celular'];
        $correo              = $_POST['correo'];
        $sexo                = $_POST['sexo'];
        $estado              = $_POST['estado'];
        $usuarioActual       = $_SESSION['idPersona'];

        $listaGruposLideresAgregado         = json_decode(stripslashes($_POST['listaGruposLideresAgregado']));
        $listaGruposParticipantesAgregado   = json_decode(stripslashes($_POST['listaGruposParticipantesAgregado']));
        $listaGruposLideresEliminados       = json_decode(stripslashes($_POST['listaGruposLideresEliminados']));
        $listaGruposParticipantesEliminados = json_decode(stripslashes($_POST['listaGruposParticipantesEliminados']));

        $sqlPersona      = "CALL TbPersonasModificar('$idPersona', '$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$correo','$sexo','$estado','$usuarioActual')";
        $consultaPersona = $db->consulta(utf8_decode($sqlPersona));

        if(count($listaGruposLideresAgregado) > 0){
            foreach($listaGruposLideresAgregado as $grupoPersonaLiderAgregar){
                $sqlGrupoPersonaLiderAgregar = "CALL TbGruposPersonasAgregar('$idPersona','$grupoPersonaLiderAgregar','S',$usuarioActual)";
                $consultaGruposLiderAgregar  = $db->consulta(utf8_decode($sqlGrupoPersonaLiderAgregar));

                if ($db->num_rows($consultaGruposLiderAgregar) != 0) {
                    while ($resultadosGruposPersonaLiderAgregar = $db->fetch_array($consultaGruposLiderAgregar)) {
                        $idGrupoPersonaLiderAgregado = $resultadosGruposPersonaLiderAgregar['Id'];
                        $exito                       = "1";
                    }
                } else {
                    $exito = "-1";
                }
            }
        }

        if(count($listaGruposParticipantesAgregado) > 0){
            foreach($listaGruposParticipantesAgregado as $grupoPersonaParticipanteAgregar){
                $sqlGrupoPersonaParticipanteAgregar = "CALL TbGruposPersonasAgregar('$idPersona','$grupoPersonaParticipanteAgregar','N',$usuarioActual)";
                $consultaGruposParticipanteAgregar  = $db->consulta(utf8_decode($sqlGrupoPersonaParticipanteAgregar));

                if ($db->num_rows($consultaGruposParticipanteAgregar) != 0) {
                    while ($resultadosGruposPersonaParticipanteAgregar = $db->fetch_array($consultaGruposParticipanteAgregar)) {
                        $idGrupoPersonaParticipanteAgregado = $resultadosGruposPersonaParticipanteAgregar['Id'];
                        $exito                              = "1";
                    }
                } else {
                    $exito = "-1";
                }
            }
        }

        if(count($listaGruposLideresEliminados) > 0){
            foreach($listaGruposLideresEliminados as $grupoPersonaLiderEliminado){
                $sqlGrupoPersonaLiderEliminado = "CALL TbGruposPersonasModificar('$idPersona','$grupoPersonaLiderEliminado','S',$usuarioActual)";
                $consultaGruposLiderEliminado  = $db->consulta(utf8_decode($sqlGrupoPersonaLiderEliminado));
            }
        }

        if(count($listaGruposParticipantesEliminados) > 0){
            foreach($listaGruposParticipantesEliminados as $grupoPersonaParticipanteEliminado){
                $sqlGrupoPersonaParticipanteEliminado = "CALL TbGruposPersonasModificar('$idPersona','$grupoPersonaParticipanteEliminado','N',$usuarioActual)";
                $consultaGruposParticipanteEliminado  = $db->consulta(utf8_decode($sqlGrupoPersonaParticipanteEliminado));
            }
        }

        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga una persona en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarPersona') {
    try {
        $idPersona = $_POST['IdPersona'];
        
        $utilizarCantones = false;
        $utilizarDistritos = false;

        $listaTodalPersonasGruposLider = "";
        $listaTodalPersonasGruposParticipante = "";

        $sqlPersona      = "CALL TbPersonasListarPorIdPersona('$idPersona')";
        $consultaPersona = $db->consulta($sqlPersona);
        $cadena_datos    = "";

        $sqlProvincias      = "CALL TbProvinciasListar()";
        $consultaProvincias = $db->consulta($sqlProvincias);

        $sqlTotalGruposLider      = "CALL TbGruposListar()";
        $consultaTotalGruposLider = $db->consulta($sqlTotalGruposLider);

        $sqlTotalGruposParticipante      = "CALL TbGruposListar()";
        $consultaTotalGruposParticipante = $db->consulta($sqlTotalGruposParticipante);

        $sqlGruposLider             = "CALL TbGruposPersonasListarPorIdPersonaLider('$idPersona')";
        $consultaGruposLider        = $db->consulta($sqlGruposLider);
        $arregloGruposPersonaLider  = array();

        $sqlGruposParticipante      = "CALL TbGruposPersonasListarPorIdPersonaParticipante('$idPersona')";
        $consultaGruposParticipante = $db->consulta($sqlGruposParticipante);
        $arregloGruposPersonaParticipante  = array();

        if($db->num_rows($consultaGruposLider) != 0)
        {
            while($resultadosGruposPersonaLider = $db->fetch_array($consultaGruposLider))
            {
                array_push($arregloGruposPersonaLider, $resultadosGruposPersonaLider["GrupoLider"]);
            }
        }

        if($db->num_rows($consultaGruposParticipante) != 0)
        {
            while($resultadosGruposPersonaParticipante = $db->fetch_array($consultaGruposParticipante))
            {
                array_push($arregloGruposPersonaParticipante, $resultadosGruposPersonaParticipante["GrupoParticipante"]);
            }
        }

        if($db->num_rows($consultaPersona) != 0)
        {
            while($resultadosPersona = $db->fetch_array($consultaPersona))
            {
                if($resultadosPersona['Provincia'] != null){
                    $sqlCantones      = "CALL TbCantonesListarFiltrado(". $resultadosPersona['Provincia'] . ")";
                    $consultaCantones = $db->consulta($sqlCantones);
                    $utilizarCantones = true;
                }

                if($resultadosPersona['Provincia'] != null
                    && $resultadosPersona['Canton'] != null){
                    $sqlDistritos      = "CALL TbDistritosListarFiltrado(" . $resultadosPersona['Provincia'] . "," . $resultadosPersona['Canton'] . ")";
                    $consultaDistritos = $db->consulta($sqlDistritos);
                    $utilizarDistritos = true;
                }

                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtIdentificacion">Identificación:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="Ejm: 102220333" maxlength="30" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultadosPersona['Identificacion'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtNombre">Nombre:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtNombre" id="txtNombre" maxlength="20" data-clear-btn="true" value="' . $resultadosPersona['Nombre'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtApellido1">Primer apellido:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtApellido1" id="txtApellido1" maxlength="20" data-clear-btn="true" value="' . $resultadosPersona['Apellido1'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtApellido2">Segundo apellido:</label>';
                $cadena_datos .= '<input type="text" name="txtApellido2" id="txtApellido2" maxlength="20" data-clear-btn="true" value="' . $resultadosPersona['Apellido2'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaNacimiento">Fecha de nacimiento:</label>';
                $cadena_datos .= '<input type="date" name="txtFechaNacimiento" id="txtFechaNacimiento" value="' . explode(" ", $resultadosPersona['FechaNacimiento'])[0] . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdProvincia">Provincia:</label>';
                $cadena_datos .= '<select name="cboIdProvincia" id="cboIdProvincia" onchange="PersonasOnSelectedChangeProvincias()">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaProvincias) != 0)
                {
                    while($resultadosProvincias= $db->fetch_array($consultaProvincias))
                    {
                        if ($resultadosProvincias['IdProvincia'] == $resultadosPersona['Provincia']){
                            $cadena_datos .= '<option value="' . $resultadosProvincias['IdProvincia'] . '" selected>' . utf8_encode($resultadosProvincias['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosProvincias['IdProvincia'] . '">' . utf8_encode($resultadosProvincias['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdCanton">Cantón:</label>';
                $cadena_datos .= '<select name="cboIdCanton" id="cboIdCanton" onchange="PersonasOnSelectedChangeCantones()">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($utilizarCantones){
                    if($db->num_rows($consultaCantones) != 0)
                    {
                        while($resultadosCantones= $db->fetch_array($consultaCantones))
                        {
                            if ($resultadosCantones['IdCanton'] == $resultadosPersona['Canton']){
                                $cadena_datos .= '<option value="' . $resultadosCantones['IdCanton'] . '" selected>' . utf8_encode($resultadosCantones['Descripcion']) . '</option>';
                            }
                            else
                            {
                                $cadena_datos .= '<option value="' . $resultadosCantones['IdCanton'] . '">' . utf8_encode($resultadosCantones['Descripcion']) . '</option>';
                            }
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdDistrito">Distrito:</label>';
                $cadena_datos .= '<select name="cboIdDistrito" id="cboIdDistrito">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($utilizarDistritos){
                    if($db->num_rows($consultaDistritos) != 0)
                    {
                        while($resultadosDistritos= $db->fetch_array($consultaDistritos))
                        {
                            if ($resultadosDistritos['IdDistrito'] == $resultadosPersona['Distrito']){
                                $cadena_datos .= '<option value="' . $resultadosDistritos['IdDistrito'] . '" selected>' . utf8_encode($resultadosDistritos['Descripcion']) . '</option>';
                            }
                            else
                            {
                                $cadena_datos .= '<option value="' . $resultadosDistritos['IdDistrito'] . '">' . utf8_encode($resultadosDistritos['Descripcion']) . '</option>';
                            }
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDireccionDomicilio">Dirección domicilio:</label>';
                $cadena_datos .= '<textarea name="txtDireccionDomicilio" id="txtDireccionDomicilio" maxlength="250" placeholder="Dirección exacta de su domicilio.">' . utf8_encode($resultadosPersona['DireccionDomicilio']) . '</textarea>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                if($resultadosPersona['Telefono'] != '')
                {
                    $cadena_datos .= '<label for="txtTelefono">Teléfono fijo:<a style="margin-top: -4px; float: right; margin-right: 0px; height: 27px; padding-top: 5px" href="tel:' . $resultadosPersona['Telefono']  . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Llamar</a></label>';
                }
                else
                {
                    $cadena_datos .= '<label for="txtTelefono">Teléfono fijo:</label>';
                }
                $cadena_datos .= '<input type="tel" name="txtTelefono" id="txtTelefono" placeholder="Ejm: 405893685" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultadosPersona['Telefono'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el número de teléfono podrá ser contactado por medio de una llamada.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                if($resultadosPersona['Celular'] != '')
                {
                    $cadena_datos .= '<label for="txtCelular">Teléfono celular:<a style="margin-top: -4px; float: right; margin-right: 0px; height: 27px; padding-top: 5px" href="tel:' . $resultadosPersona['Celular']  . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-comment ui-btn-icon-left ui-btn-inline ui-mini">Llamar</a><a style="margin-top: -4px; float: right; margin-right: 2px; height: 27px; padding-top: 6px" href="sms:' . $resultadosPersona['Celular']  . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">SMS</a></label>';
                }
                else
                {
                    $cadena_datos .= '<label for="txtCelular">Teléfono celular:</label>';
                }
                $cadena_datos .= '<input type="tel" name="txtCelular" id="txtCelular" placeholder="Ejm: 86736592" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultadosPersona['Celular'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el número de celular podrá ser contactado por medio de una llamada o un mensaje de texto.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                if($resultadosPersona['Correo'] != '')
                {
                    $cadena_datos .= '<label for="txtCorreo">Correo eléctronico:<a style="margin-top: -4px; float: right; margin-right: 0px; height: 27px; padding-top: 5px" href="mailto:' . $resultadosPersona['Correo']  . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Correo</a></label>';
                }
                else
                {
                    $cadena_datos .= '<label for="txtCorreo">Correo eléctronico:</label>';
                }
                $cadena_datos .= '<input type="text" name="txtCorreo" id="txtCorreo" placeholder="Ejm: correo@ejemplo.com" maxlength="50" onblur="PersonasValidarCorreo()" data-clear-btn="true" value="' . $resultadosPersona['Correo'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el correo electrónico podrá ser contactado por medio del mismo.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboSexo">Género:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboSexo" id="cboSexo">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultadosPersona['Sexo'] == 'F'){
                    $cadena_datos .= '<option value="F" selected>Femenino</option>';
                    $cadena_datos .= '<option value="M">Masculino</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="F">Femenino</option>';
                    $cadena_datos .= '<option value="M" selected>Masculino</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div id="divPersonaGruposLider">';
                $cadena_datos .= '<label for="PersonaGruposLider">Grupos en los cuales es líder:</label>';
                $cadena_datos .= '<select name="PersonaGruposLider" id="PersonaGruposLider" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalGruposLider) != 0)
                {
                    while($resultadosGruposLider= $db->fetch_array($consultaTotalGruposLider))
                    {
                        if(in_array($resultadosGruposLider['IdGrupo'], $arregloGruposPersonaLider))
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposLider['IdGrupo'] . '" selected>' . utf8_encode($resultadosGruposLider['Descripcion']) . '</option>';
                            $listaTodalPersonasGruposLider .= $resultadosGruposLider['IdGrupo'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposLider['IdGrupo'] . '">' . utf8_encode($resultadosGruposLider['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfPersonasLider" id="hdfPersonasLider" value="' . substr($listaTodalPersonasGruposLider,0,strlen($listaTodalPersonasGruposLider)-1) . '">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div id="divPersonaGruposParticipante">';
                $cadena_datos .= '<label for="PersonaGruposParticipante">Grupos en los cuales es participante:</label>';
                $cadena_datos .= '<select name="PersonaGruposParticipante" id="PersonaGruposParticipante" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalGruposParticipante) != 0)
                {
                    while($resultadosGruposParticipante= $db->fetch_array($consultaTotalGruposParticipante))
                    {
                        if(in_array($resultadosGruposParticipante['IdGrupo'], $arregloGruposPersonaParticipante))
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposParticipante['IdGrupo'] . '" selected>' . utf8_encode($resultadosGruposParticipante['Descripcion']) . '</option>';
                            $listaTodalPersonasGruposParticipante .= $resultadosGruposParticipante['IdGrupo'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosGruposParticipante['IdGrupo'] . '">' . utf8_encode($resultadosGruposParticipante['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfPersonasParticipante" id="hdfPersonasParticipante" value="' . substr($listaTodalPersonasGruposParticipante,0,strlen($listaTodalPersonasGruposParticipante)-1) . '">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoPersona">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoPersona" id="cboEstadoPersona">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultadosPersona['Estado'] == 'A'){
                    $cadena_datos .= '<option value="A" selected>Activo</option>';
                    $cadena_datos .= '<option value="I">Inactivo</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="A">Activo</option>';
                    $cadena_datos .= '<option value="I" selected>Inactivo</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="PersonasModificarPersona(' . $resultadosPersona['IdPersona'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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

// Obtiene las personas que son lideres de un grupo para mostrarlos en el select de lideres
if (isset($_POST['action']) && $_POST['action'] == 'obtenerPersonasLideresListado') {
    try {
        $sql          = "CALL TbPersonasListar()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene las personas que son participantes de un grupo para mostrarlos en el select de participantes
if (isset($_POST['action']) && $_POST['action'] == 'obtenerPersonasParticipantesListado') {
    try {
        $sql          = "CALL TbPersonasListar()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene las personas que son visitasntes en la iglesia para mostrarlas en el select de visitantes
if (isset($_POST['action']) && $_POST['action'] == 'obtenerPersonasVisitantesListado') {
    try {
        $sql          = "CALL TbPersonasListar()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}