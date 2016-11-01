/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

// Función para ingresar a la pantalla de bienvenida
function UtiMantenimientosPaginaBienvenida()
{
    RedireccionPagina('../bienvenida.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiMantenimientosPaginaMantenimientosUsuarios()
{
    RedireccionPagina('usuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios detalle
function UtiMantenimientosPaginaMantenimientosUsuariosDetalle()
{
    RedireccionPagina('usuariosDetalle.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de proceso de compromisos
function UtiMantenimientosPaginaProcesosCompromisos()
{
    RedireccionPagina('../Procesos/compromisos.php');
}

// Función para ingresar a la pantalla de proceso de grupos
function UtiMantenimientosPaginaProcesosGrupos()
{
    RedireccionPagina('../Procesos/grupos.php');
}

// Función para ingresar a la pantalla de proceso de personas
function UtiMantenimientosPaginaProcesosPersonas()
{
    RedireccionPagina('../Procesos/personas.php');
}

// Función para ingresar a la pantalla de proceso de personas detalle
function UtiMantenimientosPaginaProcesosPersonasDetalle()
{
    RedireccionPagina('../Procesos/personasDetalle.php');
}

// Función para ingresar a la pantalla de proceso de seguimientos
function UtiMantenimientosPaginaProcesosSeguimientos()
{
    RedireccionPagina('../Procesos/seguimientos.php');
}

// Función para ingresar a la pantalla de proceso de visitas
function UtiMantenimientosPaginaProcesosVisitas()
{
    RedireccionPagina('../Procesos/visitas.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla reporte de compromisos
function UtiMantenimientosPaginaReportesCompromisos()
{
    RedireccionPagina('../Reportes/compromisos.php');
}

// Función para ingresar a la pantalla reporte de grupos
function UtiMantenimientosPaginaReportesGrupos()
{
    RedireccionPagina('../Reportes/grupos.php');
}

// Función para ingresar a la pantalla reporte de personas
function UtiMantenimientosPaginaReportesPersonas()
{
    RedireccionPagina('../Reportes/personas.php');
}

// -----------------------------------------------------------------

// Función para cerrar sesión en el sistema
function UtiMantenimientosCerrarSesion()
{
    $.confirm({
        theme: 'material'
        , animationBounce: 1.5
        , animation: 'rotate'
        , closeAnimation: 'rotate'
        , title: '<span class="jconfirm-customize">Cerrar sesión</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
        , content: '<span class="jconfirm-customize">¿Esta seguro que desea cerrar la sesión?</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
        , confirmButton: 'Aceptar'
        , confirmButtonClass: 'btn-success'
        , cancelButton: 'Cancelar'
        , cancelButtonClass: 'btn-danger'
        , confirm: function(){
            // Se define el action que será consultado desde la clase de acceso a datos
            var d = "action=cerrarSesion";

            // Enviar por Ajax a indexCAD.php
            $.ajax({
                type: "POST"
                , data: d
                , url: "../../Datos/indexCAD.php"
                , success: function(a)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: '<span class="jconfirm-customize">Ha cerrado la sesión</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
                        , content: '<span class="jconfirm-customize">Esperamos que vuelva pronto.</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('../../index.php');
                        }
                    });
                }
            });
        }
    });
}
