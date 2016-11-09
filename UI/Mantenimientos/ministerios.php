<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 02/11/16
 */

/**
 * ob_start(): Se utiliza para limpiar las cabeceras puesto que daban conflicto a la hora de redireccionar al index,
 * si el usuario no habia iniciado sesión en la aplicación
 */
ob_start();

// Se realiza el llamado a la clase de obtener datos de la sesion actual
require("../Includes/utilitarios/mantenimientos.php");
$utilitarios = new UtilitariosMantenimientos();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sistema IMVE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <!-- Forzar a no cargar datos de la caché -->
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <!-- Fin forzar a no cargar datos de la caché -->
        <!-- Se carga el favicon -->
        <link rel="shorcut icon" href="../Includes/images/favicon.ico" />
        <link href="../Includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="../Includes/css/fonts/Lato.css" rel="stylesheet" type="text/css">
        <link href="../Includes/css/styles.css" rel="stylesheet" type="text/css"/>
        <!-- Fin carga de las hojas de estilo -->
        <!-- Se cargan los archivos javascript -->
        <script src="../Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../Includes/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
        <script src="../Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../../Negocio/Utilitarios/mantenimientos.js" type="text/javascript"></script>
        <script src="../../Negocio/Mantenimientos/ministeriosCN.js" type="text/javascript"></script>
        <script src="../Includes/js/utilitarios.js" type="text/javascript"></script>
        <!-- Fin carga de los archivos javascript -->
    </head>
    <body onload="MinisteriosOnLoad()">
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <a href="#menuIzquierda" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-btn-icon-notext ui-icon-bars"></a>
                <h1>Sistema IMVE</h1>
                <a href="#menuDerecha" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-btn-icon-notext ui-icon-user"></a>
            </div>
            <div data-role="panel" id="menuIzquierda" data-theme="b" data-display="reveal" data-dismissible="true">
                <ul data-role="listview" data-inset="true" data-icon="false" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-home">
                    <li>
                        <a href="#" class="menu-inicio" data-transition="slidedown" onclick="UtiMantenimientosPaginaBienvenida()">Inicio</a>
                    </li>
                </ul>
                <div data-role="collapsible" data-theme="a">
                    <h3>Mantenimientos</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosCategoriasPersonas()">Categorías de personas</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosCategoriasGrupos()">Categorías de grupos</a>
                        </li>
                        <li class="menu-actual">
                            Ministerios
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosRolesUsuarios()">Roles de usuarios</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosTiposCompromisos()">Tipos de compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosTiposRelaciones()">Tipos de relaciones</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosTiposSeguimientos()">Tipos de seguimientos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaMantenimientosUsuarios()">Usuarios</a>
                        </li>
                    </ul>
                </div>
                <div data-role="collapsible" data-theme="a">
                    <h3>Procesos</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaProcesosCompromisos()">Compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaProcesosGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaProcesosPersonas()">Personas</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaProcesosVisitas()">Visitas</a>
                        </li>
                    </ul>
                </div>
                <div data-role="collapsible" data-theme="a">
                    <h3>Reportes</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaReportesCompromisos()">Compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaReportesGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiMantenimientosPaginaReportesPersonas()">Personas</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="panel" id="menuDerecha" data-position="right" data-theme="b" data-display="reveal" data-dismissible="true">
                <div data-role="collapsible" data-theme="a">
                    <h3><?php echo $utilitarios->ObtenerNombreUsuario() ?></h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-edit ui-btn-icon-right ui-btn-b" onclick="UtiMantenimientosPaginaCambiarContrasena()">Cambiar contraseña</a>
                        </li>
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-power ui-btn-icon-right ui-btn-b" onclick="UtiMantenimientosCerrarSesion()">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content">
                <div class="container">
                    <h3 class="text-center">Listado de Ministerios</h3>
                    <hr>
                    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" class="text-right" onchange="MinisteriosCargarMinisteriosListado()">
                        <input type="radio" name="estadoMinisterio" id="activas" value="A" checked="checked">
                        <label for="activas">Activos</label>
                        <input type="radio" name="estadoMinisterio" id="inactivas" value="I">
                        <label for="inactivas">Inactivos</label>
                    </fieldset>
                    <form class="ui-filterable">
                        <input id="filtro" data-type="search" placeholder="Búsqueda">
                    </form>
                    <ul data-role="listview" id="listaMinisterios" data-filter="true" data-input="#filtro" data-autodividers="true" data-inset="true">
                        <!-- Aquí se insertan los datos dinámicamente -->
                    </ul>
                </div>
            </div>
            <div data-role="footer" data-theme="b" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#" data-transition="flip" data-icon="plus" data-theme="b" onclick="UtiMantenimientosPaginaMantenimientosMinisteriosDetalleAgregar()">Agregar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
/**
 * ob_end_flush(): Se utiliza para limpiar las cabeceras puesto que daban conflicto a la hora de redireccionar al index,
 * si el usuario no habia iniciado sesión en la aplicación
 */
ob_end_flush();
?>