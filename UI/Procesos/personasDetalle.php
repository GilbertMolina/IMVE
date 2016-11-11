<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

/**
 * ob_start(): Se utiliza para limpiar las cabeceras puesto que daban conflicto a la hora de redireccionar al index,
 * si el usuario no habia iniciado sesión en la aplicación
 */
ob_start();

// Se realiza el llamado a la clase de obtener datos de la sesion actual
require("../Includes/utilitarios/procesos.php");
$utilitarios = new UtilitariosProcesos();

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
        <!-- Fin carga el favicon -->
        <!-- Se cargan las hojas de estilo -->
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
        <script src="../../Negocio/Utilitarios/procesos.js" type="text/javascript"></script>
        <script src="../../Negocio/Procesos/personasCN.js" type="text/javascript"></script>
        <script src="../../Negocio/Mantenimientos/provinciasCN.js" type="text/javascript"></script>
        <script src="../../Negocio/Mantenimientos/cantonesCN.js" type="text/javascript"></script>
        <script src="../../Negocio/Mantenimientos/distritosCN.js" type="text/javascript"></script>
        <script src="../Includes/js/utilitarios.js" type="text/javascript"></script>
        <!-- Fin carga de los archivos javascript -->
        <script>
            $(function () {
                if ($('[type="date"]').prop('type') != 'date') {
                    $('[type="date"]').datepicker();
                }
            });
        </script>
    </head>
    <body onload="PersonasDetalleOnLoad()">
        <div data-role="page">
            <div data-role="header" data-theme="b" data-position="fixed">
                <a href="#menuIzquierda" class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-btn-icon-notext ui-icon-bars"></a>
                <h1>Sistema IMVE</h1>
                <a href="#menuDerecha" class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-btn-icon-notext ui-icon-user"></a>
            </div>
            <div data-role="panel" id="menuIzquierda" data-theme="b" data-display="reveal" data-dismissible="true">
                <ul data-role="listview" data-inset="true" data-icon="false" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-home">
                    <li>
                        <a href="#" class="menu-inicio" data-transition="slidedown" onclick="UtiProcesosPaginaBienvenida()">Inicio</a>
                    </li>
                </ul>
                <?php if($utilitarios->ObtenerRolUsuario() == "SuperAdmin" || $utilitarios->ObtenerRolUsuario() == "Administrador"){ ?>
                    <div data-role="collapsible" data-theme="a">
                        <h3>Mantenimientos</h3>
                        <ul data-role="listview">
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosCategoriasPersonas()">Categorías de personas</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosCategoriasGrupos()">Categorías de grupos</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosMinisterios()">Ministerios</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosRolesUsuarios()">Roles de usuarios</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosTiposCompromisos()">Tipos de compromisos</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosTiposRelaciones()">Tipos de relaciones</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosTiposSeguimientos()">Tipos de seguimientos</a>
                            </li>
                            <li>
                                <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaMantenimientosUsuarios()">Usuarios</a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <div data-role="collapsible" data-theme="a">
                    <h3>Procesos</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaProcesosCompromisos()">Compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaProcesosGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaProcesosPersonas()">Personas</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaProcesosVisitas()">Visitas</a>
                        </li>
                    </ul>
                </div>
                <div data-role="collapsible" data-theme="a">
                    <h3>Reportes</h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaReportesCompromisos()">Compromisos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaReportesGrupos()">Grupos</a>
                        </li>
                        <li>
                            <a href="#" data-transition="slidedown" onclick="UtiProcesosPaginaReportesPersonas()">Personas</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="panel" id="menuDerecha" data-position="right" data-theme="b" data-display="reveal" data-dismissible="true">
                <div data-role="collapsible" data-theme="a">
                    <h3><?php echo $utilitarios->ObtenerNombreUsuario() ?></h3>
                    <ul data-role="listview">
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-edit ui-btn-icon-right ui-btn-b" onclick="UtiProcesosPaginaCambiarContrasena()">Cambiar contraseña</a>
                        </li>
                        <li>
                            <a href="#" style="font-size: 15px" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-power ui-btn-icon-right ui-btn-b" onclick="UtiProcesosCerrarSesion()">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-role="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                            <h3 class="text-center">Mantenimiento de Personas</h3>
                            <hr>
                            <form method="post" action="#" id="personasDetalle">
                                <div>
                                    <label for="txtIdentificacion">Identificación:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="102220333" maxlength="30" onKeyPress="return SoloNumeros(event)" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="txtNombre">Nombre:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <input type="text" name="txtNombre" id="txtNombre" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="txtApellido1">Primer apellido:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <input type="text" name="txtApellido1" id="txtApellido1" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="txtApellido2">Segundo apellido:</label>
                                    <input type="text" name="txtApellido2" id="txtApellido2" maxlength="20" data-clear-btn="true"/>
                                </div>
                                <br>
                                <div>
                                    <label for="txtFechaNacimiento">Fecha de nacimiento:</label>
                                    <input type="date" name="txtFechaNacimiento" id="txtFechaNacimiento" value="">
                                </div>
                                <br>
                                <div>
                                    <label for="cboIdProvincia">Provincia:</label>
                                    <select name="cboIdProvincia" id="cboIdProvincia" onchange="PersonasOnSelectedChangeProvincias()">
                                        <option value="0">Seleccione</option>
                                        <!-- Aquí se insertan los datos dinámicamente -->
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="cboIdCanton">Cantón:</label>
                                    <select name="cboIdCanton" id="cboIdCanton" onchange="PersonasOnSelectedChangeCantones()">
                                        <option value="0">Seleccione</option>
                                        <!-- Aquí se insertan los datos dinámicamente -->
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="cboIdDistrito">Distrito:</label>
                                    <select name="cboIdDistrito" id="cboIdDistrito">
                                        <option value="0">Seleccione</option>
                                        <!-- Aquí se insertan los datos dinámicamente -->
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="txtDireccionDomicilio">Dirección domicilio:</label>
                                    <textarea name="txtDireccionDomicilio" id="txtDireccionDomicilio" maxlength="250" placeholder="Dirección exacta de su domicilio." data-clear-btn="true"></textarea>
                                </div>
                                <br>
                                <div>
                                    <label for="txtTelefono">Teléfono: </label>
                                    <input type="tel" name="txtTelefono" id="txtTelefono" placeholder="88888888" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true"/>
                                    <p class="bg-danger text-justify">Nota: Si proporciona el número de teléfono podrá ser contactado por medio de una llamada.</p>
                                </div>
                                <br>
                                <div>
                                    <label for="txtCelular">Celular:</label>
                                    <input type="tel" name="txtCelular" id="txtCelular" placeholder="88888888" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true"/>
                                    <p class="bg-danger text-justify">Nota: Si proporciona el número de celular podrá ser contactado por medio de una llamada o un mensaje de texto.</p>
                                </div>
                                <br>
                                <div>
                                    <label for="txtCorreo">Correo eléctronico:</label>
                                    <input type="text" name="txtCorreo" id="txtCorreo" placeholder="correo@ejemplo.com" maxlength="50" onblur="PersonasValidarCorreo()" data-clear-btn="true"/>
                                    <p class="bg-danger text-justify">Nota: Si proporciona el correo electrónico podrá ser contactado por medio del mismo.</p>
                                </div>
                                <br>
                                <div>
                                    <label for="cboSexo">Género:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>
                                    <select name="cboSexo" id="cboSexo">
                                        <option value="0">Seleccione</option>
                                        <option value="F">Femenino</option>
                                        <option value="M">Masculino</option>
                                    </select>
                                </div>
                                <br>
                                <div>
                                    <label for="cboEstadoPersona">Estado:</label>
                                    <select name="cboEstadoPersona" id="cboEstadoPersona" disabled>
                                        <option value="0">Seleccione</option>
                                        <option value="A" selected>Activo</option>
                                        <option value="I">Inactivo</option>
                                    </select>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-1"></div>
                                    <div class="col-xs-10">
                                        <button type="button" id="btnAceptar" data-theme="b" onclick="PersonasRegistrarPersona()" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Agregar</button>
                                    </div>
                                    <div class="col-xs-1"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 col-md-3 col-lg-3"></div>
                    </div>
                </div>
            </div>
            <div data-role="footer" data-theme="b" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#" data-transition="flip" data-icon="carat-l" data-theme="b" onclick="UtiProcesosPaginaProcesosPersonas()">Atrás</a></li>
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