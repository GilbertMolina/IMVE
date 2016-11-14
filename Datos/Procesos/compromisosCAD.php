<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

session_start();

error_reporting(11);
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