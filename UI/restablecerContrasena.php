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
        <link rel="shorcut icon" href="Includes/images/favicon.ico"/>
        <link href="Includes/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryui/jquery-ui-1.12.1.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="Includes/css/fonts/Lato.css" rel="stylesheet" type="text/css">
        <link href="Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="Includes/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryui/jquery-ui-1.12.1.js" type="text/javascript"></script>
        <script src="Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../Negocio/registrarseCN.js" type="text/javascript"></script>
        <script src="Includes/js/utilitarios.js" type="text/javascript"></script>
        <script src="../Negocio/restablecerContrasenaCN.js" type="text/javascript"></script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <a href="#" data-icon="carat-l" data-transition="slide" data-direction="reverse" onclick="IndexRegresar()">Regresar</a>
                <h1>Restablecer Contraseña</h1>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row" >
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                            <form method="post" action="#" id="restablecerContrasena">
                                <div>
                                    <label for="txtIdentificacionRestablecer">Identificación:<img src="Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <input type="text" name="txtIdentificacionRestablecer" id="txtIdentificacionRestablecer" placeholder="102220333" maxlength="30" onKeyPress="return soloNumeros(event)" data-clear-btn="true">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-6">
                                        <a href="#" id="btnRestablecer" data-role="button" data-theme="b" onclick="RestablecerContrasena()">Restablecer</a>
                                    </div>
                                    <div class="col-xs-3"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
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
        </div>
    </body>
</html>