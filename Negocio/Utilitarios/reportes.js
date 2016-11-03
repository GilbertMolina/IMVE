/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

// Función para ingresar a la pantalla de bienvenida
function UtiReportesPaginaBienvenida()
{
    RedireccionPagina('../bienvenida.php');
}

// Función para ingresar a la pantalla de cambiar contraseña
function UtiReportesPaginaCambiarContrasena()
{
    RedireccionPagina('../cambiarContrasena.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de mantenimiento de categorias personas
function UtiReportesPaginaMantenimientosCategoriasPersonas()
{
    RedireccionPagina('../Mantenimientos/categorias.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias personas detalle
function UtiReportesPaginaMantenimientosCategoriasPersonasDetalle()
{
    RedireccionPagina('../Mantenimientos/categoriasDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos
function UtiReportesPaginaMantenimientosCategoriasGrupos()
{
    RedireccionPagina('../Mantenimientos/categoriasGrupos.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos detalle
function UtiReportesPaginaMantenimientosCategoriasGruposDetalle()
{
    RedireccionPagina('../Mantenimientos/categoriasGruposDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios
function UtiReportesPaginaMantenimientosMinisterios()
{
    RedireccionPagina('../Mantenimientos/ministerios.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios detalle
function UtiReportesPaginaMantenimientosMinisteriosDetalle()
{
    RedireccionPagina('../Mantenimientos/ministeriosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario
function UtiReportesPaginaMantenimientosRolesUsuarios()
{
    RedireccionPagina('../Mantenimientos/rolesUsuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario detalle
function UtiReportesPaginaMantenimientosRolesUsuariosDetalle()
{
    RedireccionPagina('../Mantenimientos/rolesUsuariosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos
function UtiReportesPaginaMantenimientosTiposCompromisos()
{
    RedireccionPagina('../Mantenimientos/tiposCompromisos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos detalle
function UtiReportesPaginaMantenimientosTiposCompromisosDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposCompromisosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones
function UtiReportesPaginaMantenimientosTiposRelaciones()
{
    RedireccionPagina('../Mantenimientos/tiposRelaciones.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones detalle
function UtiReportesPaginaMantenimientosTiposRelacionesDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposRelacionesDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos
function UtiReportesPaginaMantenimientosTiposSeguimientos()
{
    RedireccionPagina('../Mantenimientos/tiposSeguimientos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos detalle
function UtiReportesPaginaMantenimientosTiposSeguimientosDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposSeguimientosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiReportesPaginaMantenimientosUsuarios()
{
    RedireccionPagina('../Mantenimientos/usuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiReportesPaginaMantenimientosUsuariosDetale()
{
    RedireccionPagina('../Mantenimientos/usuariosDetalle.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de proceso de compromisos
function UtiReportesPaginaProcesosCompromisos()
{
    RedireccionPagina('../Procesos/compromisos.php');
}

// Función para ingresar a la pantalla de proceso de grupos
function UtiReportesPaginaProcesosGrupos()
{
    RedireccionPagina('../Procesos/grupos.php');
}

// Función para ingresar a la pantalla de proceso de personas
function UtiReportesPaginaProcesosPersonas()
{
    RedireccionPagina('../Procesos/personas.php');
}

// Función para ingresar a la pantalla de proceso de personas detalle
function UtiReportesPaginaProcesosPersonasDetalle()
{
    RedireccionPagina('../Procesos/personasDetalle.php');
}

// Función para ingresar a la pantalla de proceso de seguimientos
function UtiReportesPaginaProcesosSeguimientos()
{
    RedireccionPagina('../Procesos/seguimientos.php');
}

// Función para ingresar a la pantalla de proceso de visitas
function UtiReportesPaginaProcesosVisitas()
{
    RedireccionPagina('../Procesos/visitas.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla reporte de compromisos
function UtiReportesPaginaReportesCompromisos()
{
    RedireccionPagina('compromisos.php');
}

// Función para ingresar a la pantalla reporte de grupos
function UtiReportesPaginaReportesGrupos()
{
    RedireccionPagina('grupos.php');
}

// Función para ingresar a la pantalla reporte de personas
function UtiReportesPaginaReportesPersonas()
{
    RedireccionPagina('personas.php');
}

// -----------------------------------------------------------------

// Función para cerrar sesión en el sistema
function UtiReportesCerrarSesion()
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
