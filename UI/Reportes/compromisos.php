<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 30/10/16
 */

/**
 * ob_start(): Se utiliza para limpiar las cabeceras puesto que daban conflicto a la hora de redireccionar al index,
 * si el usuario no habia iniciado sesión en la aplicación
 */
ob_start();

// Se realiza el llamado a la clase de obtener datos de la sesion actual
require("../Includes/utilitarios/reportes.php");
$utilitarios = new UtilitariosReportes();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sistema IMVE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="shorcut icon" href="../Includes/images/favicon.ico" />
        <link href="../Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/css/fonts/Lato.css" rel="stylesheet" type="text/css">
        <link href="../Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="../Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../Includes/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="../Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../../Negocio/Utilitarios/reportes.js" type="text/javascript"></script>
        <script src="../../Negocio/Mantenimientos/usuariosCN.js" type="text/javascript"></script>
        <script src="../../Negocio/Reportes/compromisosCN.js" type="text/javascript"></script>
        <script src="../Includes/js/utilitarios.js" type="text/javascript"></script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <a href="#menuIzquierda" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-btn-icon-notext ui-icon-bars"></a>
                <h1>Sistema IMVE</h1>
                <a href="#menuDerecha" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-btn-icon-notext ui-icon-user"></a>
            </div>
            <div data-role="panel" id="menuIzquierda" data-theme="b" data-display="reveal" data-dismissible="true">
                <ul data-role="listview" data-inset="true">
                    <li>
                        <a href="#" class="menu-inicio" data-transition="slidedown" onclick="UtiReportesPaginaBienvenida()">Inicio</a>
                    </li>
                </ul>
                <div data-role="collapsible" data-theme="a">
                    <h3>Mantenimientos</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaMantenimientosUsuarios()">Usuarios</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="">Mantenimiento #2</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="">Mantenimiento #3</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="">Mantenimiento #4</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="">Mantenimiento #5</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="">Mantenimiento N</a>
                        </li>
                    </ul>
                </div>
                <div data-role="collapsible" data-theme="a">
                    <h3>Procesos</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaProcesosCompromisos()">Compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaProcesosGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaProcesosPersonas()">Personas</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaProcesosSeguimientos()">Seguimientos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaProcesosVisitas()">Visitas</a>
                        </li>
                    </ul>
                </div>
                <div data-role="collapsible" data-theme="a">
                    <h3>Reportes</h3>
                    <ul data-role="listview">
                        <li class="menu-actual">
                            Compromisos
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaReportesGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiReportesPaginaReportesPersonas()">Personas</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="panel" id="menuDerecha" data-position="right" data-theme="b" data-display="reveal" data-dismissible="true">
                <div data-role="collapsible" data-theme="a">
                    <h3><?php echo $utilitarios->ObtenerNombreUsuario() ?></h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-edit ui-btn-icon-right ui-btn-b" onclick="UtiReportesPaginaCambiarContrasena()">Cambiar contraseña</a>
                        </li>
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-power ui-btn-icon-right ui-btn-b" onclick="UtiReportesCerrarSesion()">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-sm-1"></div>
                        <div class="col-xs-12 col-sm-10">
                            <h3 class="text-center">Reportes de Compromisos</h3>
                            <hr>
                            <div class="jumbotron">
                                <img src="../Includes/images/documentPDF.png" alt="Reporte 1">
                                <h2>Título Reporte 1</h2>
                                <p><strong>Descripción: </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="col-xs-2 col-sm-4"></div>
                                <div class="col-xs-8 col-sm-4">
                                    <button type="button" class="btn btn-primary btn-lg col-sx-4">
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generar
                                    </button>
                                </div>
                                <div class="col-xs-2 col-sm-4"></div>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-1"></div>
                        <div class="col-xs-12 col-sm-10">
                            <div class="jumbotron">
                                <img src="../Includes/images/documentPDF.png" alt="Reporte 2">
                                <h2>Título Reporte 3</h2>
                                <p><strong>Descripción: </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="col-xs-2 col-sm-4"></div>
                                <div class="col-xs-8 col-sm-4">
                                    <button type="button" class="btn btn-primary btn-lg col-sx-4">
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generar
                                    </button>
                                </div>
                                <div class="col-xs-2 col-sm-4"></div>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-1"></div>
                        <div class="col-xs-12 col-sm-10">
                            <div class="jumbotron">
                                <img src="../Includes/images/documentPDF.png" alt="Reporte 3">
                                <h2>Título Reporte 3</h2>
                                <p><strong>Descripción: </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <div class="col-xs-2 col-sm-4"></div>
                                <div class="col-xs-8 col-sm-4">
                                    <button type="button" class="btn btn-primary btn-lg col-sx-4">
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generar
                                    </button>
                                </div>
                                <div class="col-xs-2 col-sm-4"></div>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </div>
            <div data-role="footer" data-theme="b" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li>
                            <h6 style="text-align: center">&nbsp;</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
/**
 * ob_end_flush(): Se utilza para limpiar las cabeceras puesto que daban conflicto a la hora de redireccionar al index,
 * si el usuario no habia iniciado sesión en la aplicación
 */
ob_end_flush();
?>