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

        $sql               = "CALL TbPersonasListarPorOrdenamientoEstado('$ordenamiento', '$estado')";
        $consulta          = $db->consulta($sql);
        $consultaAcciones  = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<ul data-role="listview" id="listaPersonas" data-filter="true" data-input="#filtro" data-split-icon="gear" data-autodividers="true" data-inset="true">';

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</a><a href="#acciones_'. $resultados['IdPersona'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a></li>';
            }
            $cadena_datos .= '</ul>';

            if($db->num_rows($consultaAcciones) != 0)
            {
                while($resultadosAcciones = $db->fetch_array($consultaAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadosAcciones['IdPersona'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';

                    if($resultadosAcciones['Telefono'] == ""
                        && $resultadosAcciones['Celular'] == ""
                        && $resultadosAcciones['Correo'] == ""){
                        $cadena_datos .= '<p>' . $resultadosAcciones['NombreCompleto'] . ' no tiene asociado un número de teléfono, celular ni un correo electrónico, con el cual se pueda contactar.</p>';
                    }
                    else{
                        $cadena_datos .= '<p>Estas son las acciones disponibles para ' . $resultadosAcciones['NombreCompleto'] . ':</p>';
                    }

                    if($resultadosAcciones['Telefono'] != ""){
                        $cadena_datos .= '<a href="tel:' . $resultadosAcciones['Telefono'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Teléfono</a>';
                    }
                    if($resultadosAcciones['Celular'] != ""){
                        $cadena_datos .= '<a href="tel:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Celular</a>';
                        $cadena_datos .= '<a href="sms:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-comment ui-btn-icon-left ui-btn-inline ui-mini">SMS</a>';
                    }
                    if($resultadosAcciones['Correo'] != ""){
                        $cadena_datos .= '<a href="mailto:' . $resultadosAcciones['Correo'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Correo</a>';
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

        $sql               = "CALL TbPersonasListarCelularesCorreos('$accion')";
        $consulta          = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonas" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonas" id="accionesSeleccionPersonas" data-filter="true" data-input="#filtroSeleccion" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarPersonas()">';

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                if ($accion == 'S'){
                    $cadena_datos .= '<option value="' . $resultados['Celular'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
                }
                else{
                    $cadena_datos .= '<option value="' . $resultados['Correo'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
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

        $sql               = "CALL TbPersonasListarActivosInactivos('$estado')";
        $consulta          = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonasActivarDesactivar" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonasActivarDesactivar" id="accionesSeleccionPersonasActivarDesactivar" data-filter="true" data-input="#filtroSeleccionActivasDesactivas" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarActivarDesactivarPersonas()">';

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
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
            $sql      = "CALL TbPersonasActualizarEstado('$estado','$persona','$usuarioActual')";
            $consulta = $db->consulta(utf8_decode($sql));
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
        $identificacion       = $_POST['identificacion'];
        $nombre               = $_POST['nombre'];
        $apellido1            = $_POST['apellido1'];
        $apellido2            = $_POST['apellido2'];
        $fechaNacimiento      = $_POST['fechaNacimiento'];
        $distrito             = $_POST['distrito'];
        $direccionDomicilio   = $_POST['direccionDomicilio'];
        $telefono             = $_POST['telefono'];
        $celular              = $_POST['celular'];
        $correo               = $_POST['correo'];
        $sexo                 = $_POST['sexo'];
        $usuarioActual        = $_SESSION['idPersona'];

        $sql = "CALL TbPersonasAgregar('$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$correo','$sexo','$usuarioActual')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona = $resultados['Id'];
                $exito     = "1";
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
