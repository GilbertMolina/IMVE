/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

// Función para ingresar a la pantalla de bienvenida
function UtiProcesosPaginaBienvenida()
{
    RedireccionPagina('../bienvenida.php');
}

// Función para ingresar a la pantalla de cambiar contraseña
function UtiProcesosPaginaCambiarContrasena()
{
    RedireccionPagina('../cambiarContrasena.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiProcesosPaginaMantenimientosUsuarios()
{
    RedireccionPagina('../Mantenimientos/usuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios detalle
function UtiProcesosPaginaMantenimientosUsuariosDetalle()
{
    RedireccionPagina('../Mantenimientos/usuariosDetalle.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de proceso de compromisos
function UtiProcesosPaginaProcesosCompromisos()
{
    RedireccionPagina('compromisos.php');
}

// Función para ingresar a la pantalla de proceso de grupos
function UtiProcesosPaginaProcesosGrupos()
{
    RedireccionPagina('grupos.php');
}

// Función para ingresar a la pantalla de proceso de personas
function UtiProcesosPaginaProcesosPersonas()
{
    RedireccionPagina('personas.php');
}

// Función para ingresar a la pantalla de proceso de personas detalle
function UtiProcesosPaginaProcesosPersonasDetalle()
{
    RedireccionPagina('personasDetalle.php');
}

// Función para ingresar a la pantalla de proceso de seguimientos
function UtiProcesosPaginaProcesosSeguimientos()
{
    RedireccionPagina('seguimientos.php');
}

// Función para ingresar a la pantalla de proceso de visitas
function UtiProcesosPaginaProcesosVisitas()
{
    RedireccionPagina('visitas.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla reporte de compromisos
function UtiProcesosPaginaReportesCompromisos()
{
    RedireccionPagina('../Reportes/compromisos.php');
}

// Función para ingresar a la pantalla reporte de grupos
function UtiProcesosPaginaReportesGrupos()
{
    RedireccionPagina('../Reportes/grupos.php');
}

// Función para ingresar a la pantalla reporte de personas
function UtiProcesosPaginaReportesPersonas()
{
    RedireccionPagina('../Reportes/personas.php');
}

// -----------------------------------------------------------------

// Función para cerrar sesión en el sistema
function UtiProcesosCerrarSesion()
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
