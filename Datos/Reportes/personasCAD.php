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

// Obtiene el listado de personas del sistema para mostrarlas en un ListView
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    try {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin    = $_GET['fechaFin'];

        $sqlPersona      = "CALL TbPersonasReportePersonasVisitas('$fechaInicio', '$fechaFin')";
        $consultaPersona = $db->consulta($sqlPersona);
        $cadena_datos    = "";

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
                                    <th colspan="2" class="text-center" style="background-color: #008200; color: #FFFFFF">Filtros proporcionados</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF">Fecha inicio</th>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF">Fecha fin</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="text-center">' . $fechaInicio . '</td>
                                    <td class="text-center">' . $fechaFin . '</td>
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
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Persona</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Teléfono fijo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Celular móvil</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Género</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Visita</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Ministerio</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Fecha de la visita</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle">Estado de la visita</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">';
                    if($db->num_rows($consultaPersona) != 0)
                    {
                        while($resultadosPersona = $db->fetch_array($consultaPersona))
                        {
                            $html .= '<tr>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Persona"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Telefono"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Celular"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Sexo"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Visita"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Ministerio"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["FechaVisita"]) . '</td>
                                        <td class="text-center">' . utf8_encode($resultadosPersona["Estado"]) . '</td>
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
        $mpdf->setFooter('|' . $nombreIglesia . '|');
        // Se configura el CSS a utilizar
        $css = file_get_contents('../../UI/Includes/bootstrap/css/bootstrap.min.css');
        $mpdf->writeHTML($css, 1);
        $mpdf->writeHTML($html);
        // Se configura el nombre del reporte cuando se vaya a descargar
        $mpdf->Output('ReportePersonas.pdf', 'I');

    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}