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

// Función para ingresar a la pantalla de mantenimiento de categorias personas
function UtiProcesosPaginaMantenimientosCategoriasPersonas()
{
    RedireccionPagina('../Mantenimientos/categorias.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias personas detalle
function UtiProcesosPaginaMantenimientosCategoriasPersonasDetalle()
{
    RedireccionPagina('../Mantenimientos/categoriasDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos
function UtiProcesosPaginaMantenimientosCategoriasGrupos()
{
    RedireccionPagina('../Mantenimientos/categoriasGrupos.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos detalle
function UtiProcesosPaginaMantenimientosCategoriasGruposDetalle()
{
    RedireccionPagina('../Mantenimientos/categoriasGruposDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios
function UtiProcesosPaginaMantenimientosMinisterios()
{
    RedireccionPagina('../Mantenimientos/ministerios.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios detalle
function UtiProcesosPaginaMantenimientosMinisteriosDetalle()
{
    RedireccionPagina('../Mantenimientos/ministeriosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario
function UtiProcesosPaginaMantenimientosRolesUsuarios()
{
    RedireccionPagina('../Mantenimientos/rolesUsuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario detalle
function UtiProcesosPaginaMantenimientosRolesUsuariosDetalle()
{
    RedireccionPagina('../Mantenimientos/rolesUsuariosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos
function UtiProcesosPaginaMantenimientosTiposCompromisos()
{
    RedireccionPagina('../Mantenimientos/tiposCompromisos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos detalle
function UtiProcesosPaginaMantenimientosTiposCompromisosDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposCompromisosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones
function UtiProcesosPaginaMantenimientosTiposRelaciones()
{
    RedireccionPagina('../Mantenimientos/tiposRelaciones.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones detalle
function UtiProcesosPaginaMantenimientosTiposRelacionesDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposRelacionesDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos
function UtiProcesosPaginaMantenimientosTiposSeguimientos()
{
    RedireccionPagina('../Mantenimientos/tiposSeguimientos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos detalle
function UtiProcesosPaginaMantenimientosTiposSeguimientosDetalle()
{
    RedireccionPagina('../Mantenimientos/tiposSeguimientosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiProcesosPaginaMantenimientosUsuarios()
{
    RedireccionPagina('../Mantenimientos/usuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiProcesosPaginaMantenimientosUsuariosDetale()
{
    RedireccionPagina('../Mantenimientos/usuariosDetalle.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de proceso de compromisos
function UtiProcesosPaginaProcesosCompromisos()
{
    RedireccionPagina('compromisos.php');
}

// Función para ingresar a la pantalla de proceso de compromisos detalle para agregar
function UtiProcesosPaginaProcesosCompromisosDetalleAgregar()
{
    RedireccionPagina('compromisosDetalle.php');
}

// Función para ingresar a la pantalla de proceso de compromisos detalle para agregar
function UtiProcesosPaginaProcesosCompromisosDetalleAgregarDesdeGrupo(p_IdGrupo)
{
    RedireccionPagina('compromisosDetalle.php?IdGrupo=' + p_IdGrupo);
}

// Función para ingresar a la pantalla de proceso de compromisos detalle para modificar
function UtiProcesosPaginaProcesosCompromisosDetalleModificar(p_IdCompromiso)
{
    RedireccionPagina('compromisosDetalle.php?IdCompromiso=' + p_IdCompromiso);
}

// Función para ingresar a la pantalla de proceso de grupos
function UtiProcesosPaginaProcesosGrupos()
{
    RedireccionPagina('grupos.php');
}

// Función para ingresar a la pantalla de proceso de grupos detalle agregar
function UtiProcesosPaginaProcesosGruposDetalleAgregar()
{
    RedireccionPagina('gruposDetalle.php');
}

// Función para ingresar a la pantalla de proceso de grupos detalle para modificar
function UtiProcesosPaginaProcesosGruposDetalleModificar(p_IdGrupo)
{
    RedireccionPagina('gruposDetalle.php?IdGrupo=' + p_IdGrupo);
}

// Función para ingresar a la pantalla de proceso de grupos detalle para modificar
function UtiProcesosPaginaProcesosGruposDetalleRegresar(p_IdGrupo)
{
    RedireccionPagina('gruposDetalle.php?IdGrupo=' + p_IdGrupo);
}

// Función para ingresar a la pantalla de proceso de personas
function UtiProcesosPaginaProcesosPersonas()
{
    RedireccionPagina('personas.php');
}

// Función para ingresar a la pantalla de proceso de personas detalle agregar
function UtiProcesosPaginaProcesosPersonasDetalleAgregar()
{
    RedireccionPagina('personasDetalle.php');
}

// Función para ingresar a la pantalla de proceso de personas detalle para modificar
function UtiProcesosPaginaProcesosPersonasDetalleModificar(p_IdPersona)
{
    RedireccionPagina('personasDetalle.php?IdPersona=' + p_IdPersona);
}

// Función para ingresar a la pantalla de proceso de seguimientos
function UtiProcesosPaginaProcesosSeguimientos()
{
    RedireccionPagina('seguimientos.php');
}

// Función para ingresar a la pantalla de proceso de seguimientos detalle agregar
function UtiProcesosPaginaProcesosSeguimientosDetalleAgregar()
{
    RedireccionPagina('seguimientosDetalle.php');
}

// Función para ingresar a la pantalla de proceso de seguimientos detalle modificar
function UtiProcesosPaginaProcesosSeguimientosDetalleModificar(p_IdSeguimiento)
{
    RedireccionPagina('seguimientosDetalle.php?IdSeguimiento=' + p_IdSeguimiento);
}

// Función para ingresar a la pantalla de proceso de visitas
function UtiProcesosPaginaProcesosVisitas()
{
    RedireccionPagina('visitas.php');
}

// Función para ingresar a la pantalla de proceso de visitas detalle agregar
function UtiProcesosPaginaProcesosVisitasDetalleAgregar()
{
    RedireccionPagina('visitasDetalle.php');
}

// Función para ingresar a la pantalla de proceso de visitas detalle modificar
function UtiProcesosPaginaProcesosVisitasDetalleModificar(p_IdVisita)
{
    RedireccionPagina('visitasDetalle.php?IdVisita=' + p_IdVisita);
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
        , title: '<span class="jconfirm-customize">Confirmación</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
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
                        , title: '<span class="jconfirm-customize">Información</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
                        , content: '<span class="jconfirm-customize">Ha cerrado la sesión, esperamos que vuelva pronto.</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
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
