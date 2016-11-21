<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 17/11/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Se realiza la llamada de la librería para generar PDF
require_once('../Utilitarios/MPDF57/mpdf.php');

// Genera el reporte de actividades de grupos
if (isset($_GET['reporte']) && ($_GET['reporte'] == 1) && isset($_GET['fechaInicio']) && isset($_GET['fechaFin']) && isset($_GET['tipoCompromiso']) && isset($_GET['ministerio'])) {
    try {
        $fechaInicio      = $_GET['fechaInicio'];
        $fechaFin         = $_GET['fechaFin'];
        $idTipoCompromiso = $_GET['tipoCompromiso'];
        $idMinisterio     = $_GET['ministerio'];

        $nombreTipoCompromiso = "";
        $nombreMinisterio     = "";

        if($idTipoCompromiso != 0)
        {
            $sqlTipoCompromiso      = "CALL TbTiposCompromisosListarPorIdTipoCompromiso('$idTipoCompromiso')";
            $consultaTipoCompromiso = $db->consulta($sqlTipoCompromiso);

            if($db->num_rows($consultaTipoCompromiso) != 0)
            {
                while($resultados = $db->fetch_array($consultaTipoCompromiso))
                {
                    $nombreTipoCompromiso = utf8_encode($resultados["Descripcion"]);
                }
            }
        }
        else
        {
            $nombreTipoCompromiso = "Ninguno";
        }

        if($idMinisterio != 0)
        {
            $sqlMinisterio      = "CALL TbMinisteriosListarPorIdMinisterio('$idMinisterio')";
            $consultaMinisterio = $db->consulta($sqlMinisterio);

            if($db->num_rows($consultaMinisterio) != 0)
            {
                while($resultados = $db->fetch_array($consultaMinisterio))
                {
                    $nombreMinisterio = utf8_encode($resultados["Descripcion"]);
                }
            }
        }
        else
        {
            $nombreMinisterio = "Ninguno";
        }

        $sqlGrupo      = "CALL ReporteGruposReporte1('$fechaInicio','$fechaFin','$idTipoCompromiso','$idMinisterio')";
        $consultaGrupo = $db->consulta($sqlGrupo);

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
                        <h3 class="text-center">Reporte de actividad de grupos</h3>
                        <hr>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center" style="background-color: #008200; color: #FFFFFF; height: 30px">Filtros proporcionados</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Fecha inicio</th>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Fecha fin</th>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Tipo de compromiso</th>
                                    <th class="text-center" style="background-color: #1164b4; color: #FFFFFF; height: 30px">Ministerio</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td class="text-center" style="height: 30px">' . date_format(date_create($fechaInicio), 'd-m-Y') . '</td>
                                    <td class="text-center" style="height: 30px">' . date_format(date_create($fechaFin), 'd-m-Y') . '</td>
                                    <td class="text-center" style="height: 30px">' . $nombreTipoCompromiso . '</td>
                                    <td class="text-center" style="height: 30px">' . $nombreMinisterio . '</td>
                                </tr>
                                </tr>
                            </tbody>
                        </table>';

        // Contenido del reporte
        if($db->num_rows($consultaGrupo) != 0)
        {
            $html .=
                '<table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Grupo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Compromiso</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Tipo de compromiso</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Ministerio</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de inicio</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de finalización</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Lugar</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Estado del compromiso</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">';
            if($db->num_rows($consultaGrupo) != 0)
            {
                while($resultadosGrupo = $db->fetch_array($consultaGrupo))
                {
                    $html .= '<tr>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["Grupo"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["Compromiso"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["TipoCompromiso"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["Ministerio"]) . '</td>
                                <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosGrupo["FechaInicio"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosGrupo["FechaInicio"])[1]), 'g:ia') . '</td>
                                <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosGrupo["FechaFinal"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosGrupo["FechaFinal"])[1]), 'g:ia') . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["Lugar"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupo["Estado"]) . '</td>
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
        $mpdf->Output('ReporteGruposActividades.pdf', 'I');
        // Se coloca el nombre del reporte, y configura para que sea descargado inmediantamente
        //$mpdf->Output('ReporteGruposActividades.pdf', 'D');

    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Genera el reporte de integrantes por grupo
if (isset($_GET['reporte']) && ($_GET['reporte'] == 2)) {
    try {
        $sqlGrupoMaestro      = "CALL ReporteGruposReporte2Encabezado()";
        $consultaGrupoMaestro = $db->consulta($sqlGrupoMaestro);

        $sqlGrupoDetalle      = "CALL ReporteGruposReporte2Detalle()";
        $consultaGrupoDetalle = $db->consulta($sqlGrupoDetalle);

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
                        <h3 class="text-center">Reporte de grupos con sus integrantes actuales</h3>
                        <hr>';

        // Contenido del reporte
        if($db->num_rows($consultaGrupoMaestro) != 0)
        {
            $html .=
                '<table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Grupo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Categoría de grupo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Persona</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Rol</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de ingreso</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">';
            if($db->num_rows($consultaGrupoMaestro) != 0)
            {
                while($resultadosGrupoMaestro = $db->fetch_array($consultaGrupoMaestro))
                {
                    $html .= '<tr>
                                <td class="text-center" width="170px" style="font-weight: bold; height: 30px">' . utf8_encode($resultadosGrupoMaestro["Grupo"]) . '</td>
                                <td class="text-center" width="120px" style="font-weight: bold; height: 30px">' . utf8_encode($resultadosGrupoMaestro["CategoriaGrupo"]) . '</td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                            </tr>';

                    while($resultadosGrupoDetalle = $db->fetch_array($consultaGrupoDetalle))
                    {
                        if($resultadosGrupoDetalle["Grupo"] == $resultadosGrupoMaestro["Grupo"])
                        {
                            $html .= '<tr>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["NombreCompleto"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["Rol"]) . '</td>
                                <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosGrupoDetalle["FechaInicio"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosGrupoDetalle["FechaInicio"])[1]), 'g:ia') . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["Estado"]) . '</td>
                            </tr>';
                        }
                    }
                    $sqlGrupoDetalle      = "CALL ReporteGruposReporte2Detalle()";
                    $consultaGrupoDetalle = $db->consulta($sqlGrupoDetalle);
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
        $mpdf->Output('ReporteGruposIntegrantes.pdf', 'I');
        // Se coloca el nombre del reporte, y configura para que sea descargado inmediantamente
        //$mpdf->Output('ReporteGruposIntegrantes.pdf', 'D');

    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Genera el reporte de integrantes por grupo histórico
if (isset($_GET['reporte']) && ($_GET['reporte'] == 3)) {
    try {
        $sqlGrupoMaestro      = "CALL ReporteGruposReporte3Encabezado()";
        $consultaGrupoMaestro = $db->consulta($sqlGrupoMaestro);

        $sqlGrupoDetalle      = "CALL ReporteGruposReporte3Detalle()";
        $consultaGrupoDetalle = $db->consulta($sqlGrupoDetalle);

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
                        <h3 class="text-center">Reporte de grupos con el histórico de sus integrantes</h3>
                        <hr>';

        // Contenido del reporte
        if($db->num_rows($consultaGrupoMaestro) != 0)
        {
            $html .=
                '<table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Grupo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Categoría de grupo</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Persona</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Rol</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de ingreso</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Fecha y hora de salida</th>
                            <th class="text-center" style="background-color: #008200; color: #FFFFFF; vertical-align: middle; height: 50px">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">';
            if($db->num_rows($consultaGrupoMaestro) != 0)
            {
                while($resultadosGrupoMaestro = $db->fetch_array($consultaGrupoMaestro))
                {
                    $html .= '<tr>
                                <td class="text-center" width="170px" style="font-weight: bold; height: 30px">' . utf8_encode($resultadosGrupoMaestro["Grupo"]) . '</td>
                                <td class="text-center" width="120px" style="font-weight: bold; height: 30px">' . utf8_encode($resultadosGrupoMaestro["CategoriaGrupo"]) . '</td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                            </tr>';

                    while($resultadosGrupoDetalle = $db->fetch_array($consultaGrupoDetalle))
                    {
                        if($resultadosGrupoDetalle["Grupo"] == $resultadosGrupoMaestro["Grupo"])
                        {
                            $html .= '<tr>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="background-color: #E5E5E5; height: 30px"></td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["NombreCompleto"]) . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["Rol"]) . '</td>
                                <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosGrupoDetalle["FechaInicio"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosGrupoDetalle["FechaInicio"])[1]), 'g:ia') . '</td>
                                <td class="text-center" style="height: 30px">' . date_format(date_create($resultadosGrupoDetalle["FechaFinal"]), 'd-m-Y') . ' ' . date_format(date_create(explode(' ', $resultadosGrupoDetalle["FechaFinal"])[1]), 'g:ia') . '</td>
                                <td class="text-center" style="height: 30px">' . utf8_encode($resultadosGrupoDetalle["Estado"]) . '</td>
                            </tr>';
                        }
                    }
                    $sqlGrupoDetalle      = "CALL ReporteGruposReporte3Detalle()";
                    $consultaGrupoDetalle = $db->consulta($sqlGrupoDetalle);
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
        $mpdf->Output('ReporteGruposIntegrantesHistorico.pdf', 'I');
        // Se coloca el nombre del reporte, y configura para que sea descargado inmediantamente
        //$mpdf->Output('ReporteGruposIntegrantesHistorico.pdf', 'D');

    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}



