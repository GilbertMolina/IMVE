<?php

/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 16/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Se realiza la llamada de la librería para generar PDF
require_once('../Utilitarios/MPDF57/mpdf.php');

// Genera el reporte de visitas por persona
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    try {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin    = $_GET['fechaFin'];

        $sqlPersona      = "CALL ReportePersonasFechasVisitas('$fechaInicio', '$fechaFin')";
        $consultaPersona = $db->consulta($sqlPersona);

        // Encabezado del reporte
        $html =
            '<div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 style="margin-top: 13px" class="text-center">Iglesia Manantiales de Vida Eterna</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-ws-12 col-sm-10">
                        <h3 class="text-center">Reporte de personas por fechas de ingreso de visita</h3>
                        <hr>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center" style="background-color: #008200; color: #FFFFFF; height: 30px">Filtros proporcionados</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Fecha inicio</th>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Fecha fin</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="text-center" style="height: 30px">' . date_format(date_create($fechaInicio), 'd-m-Y') . '</td>
                                    <td class="text-center" style="height: 30px">' . date_format(date_create($fechaFin), 'd-m-Y'). '</td>
                                </tr>
                            </tbody>
                        </table>';

        // Contenido del reporte
        if($db->num_rows($consultaPersona) != 0)
        {
            $html .=
                '<table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Persona</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Teléfono fijo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Teléfono móvil</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Género</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Visita</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Ministerio</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de la visita</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Estado de la visita</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">';
                    if($db->num_rows($consultaPersona) != 0)
                    {
                        while($resultadosPersona = $db->fetch_array($consultaPersona))
                        {
                            $html .= '<tr>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Persona"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Telefono"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Celular"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Sexo"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Visita"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Ministerio"]) . '</td>
                                        <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosPersona["FechaVisita"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosPersona["FechaVisita"])[1]), 'g:ia') . '</td>
                                        <td class="text-center" style="height: 30px">' . utf8_encode($resultadosPersona["Estado"]) . '</td>
                                    </tr>';
                        }
                    }
        $html .= '</tbody>
                    </table>
            </div>';
        }
        else
        {
            $html .=
                '<h4 class="text-center"><b>Lo sentimos, no hay datos para los filtros proporcionados.</b></h4>
                    </div>
                    <div class="col-sm-1"></div>
                </div>';
        }

        // Final del reporte
        $html .= '</div>
                <div class="col-sm-1"></div>
            </div>';

        // Variables utilizadas en el header y footer
        $nombreSistema = 'Sistema IMVE';
        $nombreIglesia = 'Iglesia Manantiales de Vida Eterna';

        // Se procede a generar el PDF con el header, el contenido y footer
        $mpdf = new mPDF('c', 'Letter-L');
        $mpdf->setHeader('|' . $nombreSistema . '|');
        date_default_timezone_set('America/Costa_Rica');
        $mpdf->setFooter('|' . $nombreIglesia . '|' . date('m/d/Y g:ia'));
        // Se configura el CSS a utilizar
        $css = file_get_contents('../../UI/Includes/bootstrap/css/bootstrap.min.css');
        $mpdf->writeHTML($css, 1);
        $mpdf->writeHTML($html);
        // Se coloca el nombre del reporte, y configura para que sea desplegado en el navegador web
        $mpdf->Output('ReportePersonas.pdf', 'I');
        // Se coloca el nombre del reporte, y configura para que sea descargado inmediantamente
        //$mpdf->Output('ReportePersonas.pdf', 'D');

    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}