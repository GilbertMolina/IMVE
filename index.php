<!DOCTYPE html>
<html>
    <head>
        <title>IMVE | Iglesia Manantiales de Vida Eterna</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="shorcut icon" href="UI/Includes/images/favicon.ico" />
        <link href="UI/Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="UI/Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <script src="UI/Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="UI/Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <h1>Inicio de sesión</h1>
            </div>
            <div data-role="content">
                <form method="post" action="#" id="inicioSesion">
                    <div>
                        <label for="identificacion">Identificación:</label>
                        <input type="text" name="identificacion" id="identificacion" placeholder="102220333" data-clear-btn="true">
                    </div>
                    <div>
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" name="contrasena" id="contrasena" data-clear-btn="true">
                    </div>
                    <br>
                    <div>
                        <div>
                            <a href="UI/bienvenida.php" style="text-decoration: none" data-transition="pop">
                                <button type="button" id="btnIngresar" data-theme="b">Ingresar</button>
                            </a>
                        </div>
                        <div>
                            <a href="UI/registrarse.php" style="text-decoration: none" data-transition="slidefade">
                                <button type="button" id="btnRegistarse" data-theme="b">Registrarse</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div data-role="footer" data-theme="b" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li>
                            <a href="#acercade" data-icon="info" data-rel="dialog">Acerca de</a>
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