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
        <link href="UI/Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="UI/Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="UI/Includes/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="UI/Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="UI/Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="Negocio/IndexCN.js" type="text/javascript"></script>
        <script src="UI/Includes/js/utilitarios.js" type="text/javascript"></script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <h1>Inicio de sesión</h1>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row" >
                        <div class="col-sm-2 col-md-2 col-lg-2"></div>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <form method="post" action="#" id="inicioSesion">
                                <div>
                                    <label for="txtIdentificacion">Identificación:</label>
                                    <input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="102220333" maxlength="30" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true">
                                </div>
                                <br>
                                <div>
                                    <label for="txtContrasena">Contraseña:</label>
                                    <input type="password" name="txtContrasena" id="txtContrasena" maxlength="50" data-clear-btn="true">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="#" id="btnIngresar" data-role="button" data-transition="pop" data-theme="b" onclick="javascript:inicioSesion()">Ingresar</a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="UI/registrarse.php" id="btnRegistrarse" data-role="button" data-transition="slidefade" data-theme="b">Registrarse</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2"></div>
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
                <center><h2 style="margin-top: 0px">Iglesia Manantiales de Vida Eterna</h2></center>
                <p style="text-align: justify">
                    <b>Misión:</b> Manantiales de Vida Eterna, ministerio Cristo céntrico, llamado a ganar Cartago y Costa Rica para el reino de Dios. Proclama bajo la unción del Espíritu Santo, el evangelio que salva para vida eterna.
                </p>
                <br>
                <p style="text-align: justify; margin-top: -10px">
                    <b>Visión:</b> Ser una Iglesia reconocida como un ministerio de alcance sólido y edificado conforme al carácter de Jesucristo, logrando la excelencia mediante la dirección del Señor.
                </p>
            </div>
        </div>
    </body>
</html>