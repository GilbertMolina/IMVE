<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 29/10/16
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <title>IMVE | Iglesia Manantiales de Vida Eterna</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <!-- Forzar a no cargar datos de la caché -->
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <!-- Fin forzar a no cargar datos de la caché -->
        <!-- Se carga el favicon -->
        <link rel="shorcut icon" href="Includes/images/favicon.ico"/>
        <!-- Fin carga el favicon -->
        <!-- Se cargan las hojas de estilo -->
        <link href="Includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryui/jquery-ui-1.12.1.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/css/fonts/Lato.css" rel="stylesheet" type="text/css">
        <link href="Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <!-- Fin carga de las hojas de estilo -->
        <!-- Se cargan los archivos javascript -->
        <script src="Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryui/jquery-ui-1.12.1.js" type="text/javascript"></script>
        <script src="Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="Includes/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../Negocio/restablecerContrasenaCN.js" type="text/javascript"></script>
        <script src="Includes/js/utilitarios.js" type="text/javascript"></script>
        <!-- Fin carga de los archivos javascript -->
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <h3>Sistema IMVE</h3>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                            <h3 class="text-center">Restablecer su contraseña</h3>
                            <hr>
                            <form method="post" action="#" id="restablecerContrasena">
                                <div>
                                    <label for="txtIdentificacionRestablecer">Identificación:<img src="Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <input type="text" name="txtIdentificacionRestablecer" id="txtIdentificacionRestablecer" placeholder="Ejm: 102220333" maxlength="30" onKeyPress="return SoloNumeros(event)" data-clear-btn="true">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-1"></div>
                                    <div class="col-xs-10">
                                        <a href="#" id="btnRestablecer" data-role="button" data-theme="b" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-alert" onclick="RestablecerContrasena()">Restablecer</a>
                                    </div>
                                    <div class="col-xs-1"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                    </div>
                </div>
                <div data-role="footer" data-theme="b" data-position="fixed">
                    <div data-role="navbar">
                        <ul>
                            <li><a href="#" data-transition="flip" data-icon="carat-l" data-theme="b" onclick="PaginaIndex()">Atrás</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>





















