<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

// Se realiza el llamado a la clase de obtener datos de la sesion actual
require("UI/Includes/utilitarios/VERSION.php");
$versionApp = new VersionAPP();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>IMVE | Iglesia Manantiales de Vida Eterna</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="shorcut icon" href="UI/Includes/images/favicon.ico" />
        <link href="UI/Includes/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="UI/Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="UI/Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="UI/Includes/css/fonts/Lato.css" rel="stylesheet" type="text/css">
        <link href="UI/Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="UI/Includes/css/animate.css" rel="stylesheet" type="text/css"/>
        <script src="UI/Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="UI/Includes/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="UI/Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="UI/Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="Negocio/indexCN.js" type="text/javascript"></script>
        <script src="Negocio/registrarseCN.js" type="text/javascript"></script>
        <script src="UI/Includes/js/utilitarios.js" type="text/javascript"></script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <h1>Sistema IMVE</h1>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                            <div>
                                <h3 style="text-align: center;">Inicio de sesión</h3>
                                <br>
                                <form method="post" action="#" id="inicioSesion">
                                    <div>
                                        <label for="txtIdentificacion">Identificación:<img src="UI/Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                        <input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="102220333" maxlength="30" onKeyPress="return soloNumeros(event)" data-clear-btn="true">
                                    </div>
                                    <br>
                                    <div>
                                        <label for="txtContrasena">Contraseña:<img src="UI/Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                        <input type="password" name="txtContrasena" id="txtContrasena" maxlength="50" data-clear-btn="true">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a href="#" id="btnIngresar" data-role="button" data-transition="pop" data-theme="b" onclick="IniciarSesion()">Ingresar</a>
                                        </div>
                                        <div class="col-xs-6">
                                            <a href="#" id="btnRegistrarse" data-role="button" data-transition="slidefade" data-theme="b" onclick="PaginaRegistrarse()">Registrarse</a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
                                        <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6" style="text-align: center">
                                            <a href="#" id="btnRecordar" onclick="PaginaRestablecerContrasena()">¿Olvidó su contraseña?</a>
                                        </div>
                                        <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                    </div>
                </div>
            </div>
            <div data-role="footer" data-theme="b" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li>
                            <a href="#acercade" data-icon="info" data-rel="dialog" data-transition="slidedown">Acerca de</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div data-role="page" id="acercade" data-theme="a">
            <div data-role="header" data-theme="b">
                <h1>Acerca de</h1>
            </div>
            <div data-role="content">
                <center>
                    <h2 style="margin-top: 0px">Iglesia Manantiales de Vida Eterna</h2>
                </center>
                <p style="text-align: justify">
                    <b>Misión:</b> Manantiales de Vida Eterna, ministerio Cristo céntrico, llamado a ganar Cartago y Costa Rica para el reino de Dios. Proclama bajo la unción del Espíritu Santo, el evangelio que salva para vida eterna.
                </p>
                <br>
                <p style="text-align: justify; margin-top: -10px">
                    <b>Visión:</b> Ser una Iglesia reconocida como un ministerio de alcance sólido y edificado conforme al carácter de Jesucristo, logrando la excelencia mediante la dirección del Señor.
                </p>
                <br>
                <center>
                    <p style="text-align: center; margin-top: 10px">
                        <b><?php echo $versionApp->obtenerNombreApp() . ' ' . $versionApp->obtenerVersionApp()?></b>
                    </p>
                </center>
            </div>
        </div>
    </body>
</html>