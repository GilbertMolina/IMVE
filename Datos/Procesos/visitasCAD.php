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

// Obtiene el listado de visitas filtradas por el estado
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoVisitasPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql          = "CALL TbVisitasListarPorEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosVisitasDetalleModificar(' . $resultados['IdVisita'] . ')">' . utf8_encode($resultados['Descripcion']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay visitas en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga una visita en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarVisitas') {
    try {
        $idVisita = $_POST['idVisita'];

        $sql          = "CALL TbVisitasListarPorIdVisita('$idVisita')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        $listaTodalVisitasPersonasVisitantes = "";
        
        $sqlMinisterios      = "CALL TbMinisteriosListar()";
        $consultaMinisterios = $db->consulta($sqlMinisterios);

        $sqlTotalPersonas      = "CALL TbPersonasListar()";
        $consultaTotalPersonas = $db->consulta($sqlTotalPersonas);

        $sqlTotalPersonasVisitantes      = "CALL TbPersonasVisitasPorIdVisita('$idVisita')";
        $consultaTotalPersonasVisitantes = $db->consulta($sqlTotalPersonasVisitantes);
        $arregloPersonasVisitantes       = array();

        if($db->num_rows($consultaTotalPersonasVisitantes) != 0)
        {
            while($resultadosPersonasVisitas = $db->fetch_array($consultaTotalPersonasVisitantes))
            {
                array_push($arregloPersonasVisitantes, $resultadosPersonasVisitas["IdPersona"]);
            }
        }

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdMinisterios">Ministerio:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdMinisterios" id="cboIdMinisterios">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaMinisterios) != 0)
                {
                    while($resultadosMinisterios = $db->fetch_array($consultaMinisterios))
                    {
                        if ($resultadosMinisterios['IdMinisterio'] == $resultados['IdMinisterio']){
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
                $cadena_datos .= '<label for="txtDescripcionVisita">Descripción:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtDescripcionVisita" id="txtDescripcionVisita" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['Descripcion']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaVisita">Fecha de visita:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="date" name="txtFechaVisita" id="txtFechaVisita" data-clear-btn="true" value="' . explode(" ", $resultados['FechaVisita'])[0] . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div id="divVisitasPersonasVisitas">';
                $cadena_datos .= '<label for="VisitasPersonasVisitas">Personas visitantes:</label>';
                $cadena_datos .= '<select name="VisitasPersonasVisitas" id="VisitasPersonasVisitas" multiple="multiple" data-native-menu="false">';
                $cadena_datos .= '<option>Seleccione</option>';
                if($db->num_rows($consultaTotalPersonas) != 0)
                {
                    while($resultadosPersonasVisitantes = $db->fetch_array($consultaTotalPersonas))
                    {
                        if(in_array($resultadosPersonasVisitantes['IdPersona'], $arregloPersonasVisitantes))
                        {
                            $cadena_datos .= '<option value="' . $resultadosPersonasVisitantes['IdPersona'] . '" selected>' . utf8_encode($resultadosPersonasVisitantes['NombreCompleto']) . '</option>';
                            $listaTodalVisitasPersonasVisitantes .= $resultadosPersonasVisitantes['IdPersona'] . ',';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosPersonasVisitantes['IdPersona'] . '">' . utf8_encode($resultadosPersonasVisitantes['NombreCompleto']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<input type="hidden" name="hdfVisitasPersonasVisitantes" id="hdfVisitasPersonasVisitantes" value="' . substr($listaTodalVisitasPersonasVisitantes,0,strlen($listaTodalVisitasPersonasVisitantes)-1) . '">';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoVisita">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoVisita" id="cboEstadoVisita">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultados['Estado'] == 'N'){
                    $cadena_datos .= '<option value="N" selected>Abierta</option>';
                    $cadena_datos .= '<option value="S">Cerrada</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="N">Abierta</option>';
                    $cadena_datos .= '<option value="S" selected>Cerrada</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="VisitasModificarVisita(' . $resultados['IdVisita'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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

// Se realiza el registro de un nuevo grupo
if (isset($_POST['action']) && $_POST['action'] == 'registrarVisita') {
    try {
        $idMinisterio           = $_POST['idMinisterio'];
        $descripcion            = $_POST['descripcion'];
        $fechaVisita            = $_POST['fechaVisita'];
        $listaPersonasVisitante = json_decode(stripslashes($_POST['listaPersonasParticipantes']));
        $usuarioActual          = $_SESSION['idPersona'];
        $idVisita               = "";

        $sqlVisita      = "CALL TbVisitasAgregar('$idMinisterio','$descripcion','$fechaVisita','$usuarioActual')";
        $consultaVisita = $db->consulta(utf8_decode($sqlVisita));

        if ($db->num_rows($consultaVisita) != 0) {
            while ($resultados = $db->fetch_array($consultaVisita)) {
                $idVisita = $resultados['Id'];
                $exito    = "1";
            }

        } else {
            $exito = "-1";
        }

        if ($exito == "1"){
            if(count($listaPersonasVisitante) > 0){
                foreach($listaPersonasVisitante as $personaVisitante){
                    $sqlPersonaVisitante      = "CALL TbPersonasVisitasAgregar('$idVisita','$personaVisitante','$usuarioActual')";
                    $consultaPersonaVisitante = $db->consulta(utf8_decode($sqlPersonaVisitante));

                    if ($db->num_rows($consultaPersonaVisitante) != 0) {
                        while ($resultadosPersonaVisitante = $db->fetch_array($consultaPersonaVisitante)) {
                            $idPersonaVisitante = $resultadosPersonaVisitante['Id'];
                            $exito              = "1";
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

// Se realiza la modificación de una visita existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarVisita') {
    try {
        $idVisita         = $_POST['idVisita'];
        $idMinisterio     = $_POST['idMinisterio'];
        $descripcion      = $_POST['descripcion'];
        $fechaVisita      = $_POST['fechaVisita'];
        $estado           = $_POST['estado'];
        $usuarioActual    = $_SESSION['idPersona'];

        $listaPersonasVisitasAgregado   = json_decode(stripslashes($_POST['listaPersonasVisitantesAgregado']));
        $listaPersonasVisitasEliminados = json_decode(stripslashes($_POST['listaPersonasVisitantesEliminados']));

        $sqlVisita = "CALL TbVisitasModificar('$idVisita', '$idMinisterio','$descripcion','$fechaVisita','$estado','$usuarioActual')";
        $consultaVisita = $db->consulta(utf8_decode($sqlVisita));

        if(count($listaPersonasVisitasAgregado) > 0){
            foreach($listaPersonasVisitasAgregado as $personaVisitaAgregar){
                $sqlPersonaVisitanteAgregar  = "CALL TbPersonasVisitasAgregar('$idVisita','$personaVisitaAgregar','$usuarioActual')";
                $consultaPersonaVisitanteAgregar = $db->consulta(utf8_decode($sqlPersonaVisitanteAgregar));

                if ($db->num_rows($consultaPersonaVisitanteAgregar) != 0) {
                    while ($resultadosPersonaVisitanteAgregar = $db->fetch_array($consultaPersonaVisitanteAgregar)) {
                        $idPersonaVisitanteAgregado = $resultadosPersonaVisitanteAgregar['Id'];
                        $exito                       = "1";
                    }
                } else {
                    $exito = "-1";
                }
            }
        }

        if(count($listaPersonasVisitasEliminados) > 0){
            foreach($listaPersonasVisitasEliminados as $personaVisitaEliminar){
                $sqlPersonaVisitanteEliminado = "CALL TbPersonasVisitasEliminar('$idVisita','$personaVisitaEliminar')";
                $consultaPersonaVisitanteEliminado = $db->consulta(utf8_decode($sqlPersonaVisitanteEliminado));
            }
        }

        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}