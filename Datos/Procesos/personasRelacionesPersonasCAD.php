<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 01/11/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();



// Obtiene el listado de tipos de relaciones de una persona en específico para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasRelacionesPorIdPersona') {
    try {
        $idPersonaRelacionado2 = $_POST['idPersonaRelacionado2'];

        $sqlRelacionPersona      = "CALL TbTiposRelacionesPersonasListarPorPersona('$idPersonaRelacionado2')";
        $consultaRelacionPersona = $db->consulta($sqlRelacionPersona);
        $consultaAcciones        = $db->consulta($sqlRelacionPersona);
        $cadena_datos            = "";

        $cadena_datos .= '<ul data-role="listview" id="listaRelacionesPersonas" data-filter="true" data-input="#filtro" data-split-icon="delete" data-autodividers="false" data-inset="true">';

        if($db->num_rows($consultaRelacionPersona) != 0)
        {
            while($resultadosPersona = $db->fetch_array($consultaRelacionPersona))
            {
                $cadena_datos .= '<li><a href="#acciones_'. $resultadosPersona['IdPersonaRelacionado1'] . '" data-rel="popup" data-position-to="window" data-transition="pop">' . utf8_encode($resultadosPersona['Relacion']) . ' - ' . utf8_encode($resultadosPersona['NombrePersonaRelacionado1']) . '</a><a href="#" onclick="PersonasRelacionesPersonalesEliminar(' . $resultadosPersona['IdTipoRelacion'] . ',\'' . $resultadosPersona['TipoRelacion'] . '\',' . $resultadosPersona['IdPersonaRelacionado1'] . ',' . $idPersonaRelacionado2 . ')">Eliminar</a></li>';
            }
            $cadena_datos .= '</ul>';

            if($db->num_rows($consultaAcciones) != 0)
            {
                while($resultadosAcciones = $db->fetch_array($consultaAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadosAcciones['IdPersonaRelacionado1'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';
                    $cadena_datos .= '<hr>';

                    if($resultadosAcciones['Telefono'] == ""
                        && $resultadosAcciones['Celular'] == ""
                        && $resultadosAcciones['Correo'] == ""){
                        $cadena_datos .= '<p>Lo sentimos, ' . $resultadosAcciones['NombrePersonaRelacionado1'] . ' no tiene asociado un número de teléfono fijo, un número de teléfono móvil, ni un correo electrónico con el cual se pueda contactar.</p>';
                    }
                    else{
                        $cadena_datos .= '<p>Estas son las acciones disponibles para ' . $resultadosAcciones['NombrePersonaRelacionado1'] . ':</p>';
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
            $cadena_datos .= '<li>No hay personas relacionadas.</li>';
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de una relacion de una persona en específico
if (isset($_POST['action']) && $_POST['action'] == 'registrarTipoRelacionPersona') {
    try {
        $idTipoRelacion        = $_POST['idTipoRelacion'];
        $idPersonaRelacionado1 = $_POST['idPersonaRelacionado1'];
        $idPersonaRelacionado2 = $_POST['idPersonaRelacionado2'];
        $usuarioActual         = $_SESSION['idPersona'];

        $sql = "CALL TbTiposRelacionesPersonasAgregar('$idTipoRelacion','$idPersonaRelacionado1','$idPersonaRelacionado2','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idTipoRelacion = $resultados['Id'];
                $exito          = "1";
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

// Se realiza la eliminación de una relacion de una persona en específico
if (isset($_POST['action']) && $_POST['action'] == 'eliminarTipoRelacionPersona') {
    try {
        $idTipoRelacion        = $_POST['idTipoRelacion'];
        $idPersonaRelacionado1 = $_POST['idPersonaRelacionado1'];
        $idPersonaRelacionado2 = $_POST['idPersonaRelacionado2'];

        $sql = "CALL TbTiposRelacionesPersonasEliminar('$idTipoRelacion','$idPersonaRelacionado1','$idPersonaRelacionado2')";
        $consulta = $db->consulta(utf8_decode($sql));

        $resultado = '';

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $resultado = $resultados['Resultado'];
            }
        } else {
            $resultado = "-1";
        }
        echo $resultado;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}