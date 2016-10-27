<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 26/10/16
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registro de usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="shorcut icon" href="Includes/images/favicon.ico" />
        <link href="Includes/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="Includes/jqueryui/jquery-ui-1.12.1.css" rel="stylesheet" type="text/css"/>
        <script src="Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="Includes/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryui/jquery-ui-1.12.1.js"></script>
        <script src="Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../Negocio/RegistrarseCN.js" type="text/javascript"></script>
        <script src="Includes/js/utilitarios.js" type="text/javascript"></script>
        <script>
            $(function() {
                if ( $('[type="date"]').prop('type') != 'date' ) {
                    $('[type="date"]').datepicker();
                }
            });
        </script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <a href="../index.php" data-icon="carat-l" data-transition="slide" data-direction="reverse">Regresar</a>
                <h1>Registro de usuario</h1>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row" >
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                            <form method="post" action="#" id="inicioSesion">
                                <div>
                                    <label for="identificacion">Identificación:</label>
                                    <input type="text" name="identificacion" id="identificacion" placeholder="102220333" maxlength="30" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="apellido1">Primer apellido:</label>
                                    <input type="text" name="apellido1" id="apellido1" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="apellido2">Segundo apellido:</label>
                                    <input type="text" name="apellido2" id="apellido2" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="fechaNacimiento">Fecha de nacimiento:</label>
                                    <input type="date" name="fechaNacimiento" id="fechaNacimiento" value="01/01/1900">
                                </div>
                                <div>
                                    <label for="distrito">Distrito:</label>
                                    <select name="distrito" id="distrito">
                                        <option value="N">Seleccione</option>
                                        <option value="1">Distrito1</option>
                                        <option value="2">Distrito2</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="direccionExacta">Dirección domicilio:</label>
                                    <textarea name="direccionExacta" id="direccionExacta" maxlength="250" data-clear-btn="true"></textarea>
                                </div>
                                <br>
                                <div>
                                    <label for="telefono">Teléfono:</label>
                                    <input type="tel" name="telefono" id="telefono" placeholder="88888888" maxlength="8" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="celular">Celular:</label>
                                    <input type="tel" name="celular" id="celular" placeholder="88888888" maxlength="8" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="sexo">Género:</label>
                                    <select name="sexo" id="sexo">
                                        <option value="N">Seleccione</option>
                                        <option value="F">Femenino</option>
                                        <option value="M">Masculino</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="contrasena">Contraseña:</label>
                                    <input type="password" name="contrasena" id="contrasena" maxlength="50" data-clear-btn="true">
                                </div>
                                <br>
                                <div>
                                    <label for="confirmarContrasena">Confirmar contraseña:</label>
                                    <input type="password" name="confirmarContrasena" id="confirmarContrasena" maxlength="50" data-clear-btn="true">
                                </div>
                                <br>
                                <div>
                                    <div>
                                        <button type="submit" id="btnGuardar" data-theme="b" onclick="">Guardar</button>
                                    </div>
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