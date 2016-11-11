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

// Función para ingresar a la pantalla de cambiar contraseña
function UtiMantenimientosPaginaCambiarContrasena()
{
    RedireccionPagina('../cambiarContrasena.php');
}

// -----------------------------------------------------------------

// Función para ingresar a la pantalla de mantenimiento de categorias personas
function UtiMantenimientosPaginaMantenimientosCategoriasPersonas()
{
    RedireccionPagina('categorias.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias personas detalle para agregar
function UtiMantenimientosPaginaMantenimientosCategoriasPersonasDetalleAgregar()
{
    RedireccionPagina('categoriasDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias personas detalle para modificar
function UtiMantenimientosPaginaMantenimientosCategoriasPersonasDetalleModificar(p_idCategoria)
{
    RedireccionPagina('categoriasDetalle.php?idCategoria=' + p_idCategoria);
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos
function UtiMantenimientosPaginaMantenimientosCategoriasGrupos()
{
    RedireccionPagina('categoriasGrupos.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos detalle para agregar
function UtiMantenimientosPaginaMantenimientosCategoriasGruposDetalleAgregar()
{
    RedireccionPagina('categoriasGruposDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de categorias de grupos detalle para modificar
function UtiMantenimientosPaginaMantenimientosCategoriasGruposDetalleModificar(p_idCategoriaGrupo)
{
    RedireccionPagina('categoriasGruposDetalle.php?IdCategoriaGrupo=' + p_idCategoriaGrupo);
}

// Función para ingresar a la pantalla de mantenimiento de ministerios
function UtiMantenimientosPaginaMantenimientosMinisterios()
{
    RedireccionPagina('ministerios.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios detalle para agregar
function UtiMantenimientosPaginaMantenimientosMinisteriosDetalleAgregar()
{
    RedireccionPagina('ministeriosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de ministerios detalle para modificar
function UtiMantenimientosPaginaMantenimientosMinisteriosDetalleModificar(p_IdMinisterio)
{
    RedireccionPagina('ministeriosDetalle.php?IdMinisterio=' + p_IdMinisterio);
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario
function UtiMantenimientosPaginaMantenimientosRolesUsuarios()
{
    RedireccionPagina('rolesUsuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario detalle para agregar
function UtiMantenimientosPaginaMantenimientosRolesUsuariosDetalleAgregar()
{
    RedireccionPagina('rolesUsuariosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de roles de usuario detalle para modificar
function UtiMantenimientosPaginaMantenimientosRolesUsuariosDetalleModificar(p_IdRolUsuario)
{
    RedireccionPagina('rolesUsuariosDetalle.php?IdRolUsuario=' + p_IdRolUsuario);
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos
function UtiMantenimientosPaginaMantenimientosTiposCompromisos()
{
    RedireccionPagina('tiposCompromisos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos detalle para agregar
function UtiMantenimientosPaginaMantenimientosTiposCompromisosDetalleAgregar()
{
    RedireccionPagina('tiposCompromisosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de compromisos detalle para modificar
function UtiMantenimientosPaginaMantenimientosTiposCompromisosDetalleModificar(p_IdTipoCompromiso)
{
    RedireccionPagina('tiposCompromisosDetalle.php?IdTipoCompromiso=' + p_IdTipoCompromiso);
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones
function UtiMantenimientosPaginaMantenimientosTiposRelaciones()
{
    RedireccionPagina('tiposRelaciones.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones detalle para agregar
function UtiMantenimientosPaginaMantenimientosTiposRelacionesDetalleAgregar()
{
    RedireccionPagina('tiposRelacionesDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de relaciones detalle para modificar
function UtiMantenimientosPaginaMantenimientosTiposRelacionesDetalleModificar(p_IdTipoRelacion)
{
    RedireccionPagina('tiposRelacionesDetalle.php?IdTipoRelacion=' + p_IdTipoRelacion);
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos
function UtiMantenimientosPaginaMantenimientosTiposSeguimientos()
{
    RedireccionPagina('tiposSeguimientos.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos detalle para agregar
function UtiMantenimientosPaginaMantenimientosTiposSeguimientosDetalleAgregar()
{
    RedireccionPagina('tiposSeguimientosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de tipos de seguimientos detalle para modificar
function UtiMantenimientosPaginaMantenimientosTiposSeguimientosDetalleModificar(p_IdTipoSeguimiento)
{
    RedireccionPagina('tiposSeguimientosDetalle.php?IdTipoSeguimiento=' + p_IdTipoSeguimiento);
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function UtiMantenimientosPaginaMantenimientosUsuarios()
{
    RedireccionPagina('usuarios.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios detalle para agregar
function UtiMantenimientosPaginaMantenimientosUsuariosDetalleAgregar()
{
    RedireccionPagina('usuariosDetalle.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios detalle para modificar
function UtiMantenimientosPaginaMantenimientosUsuariosDetalleModificar(p_IdPersona)
{
    RedireccionPagina('usuariosDetalle.php?IdPersona=' + p_IdPersona);
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
