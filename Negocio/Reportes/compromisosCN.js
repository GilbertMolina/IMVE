/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 30/10/16
 */

// Función para ingresar a la pantalla de bienvenida
function CompromisosPaginaBienvenida()
{
    RedireccionPagina('../bienvenida.php');
}

// Función para ingresar a la pantalla de mantenimiento de usuarios
function CompromisosPaginaUsuarios()
{
    RedireccionPagina('../Mantenimientos/usuarios.php');
}

// Función para ingresar a la pantalla de personas
function CompromisosPaginaPersonas()
{
    RedireccionPagina('../Procesos/personas.php');
}

// Función para ingresar a la pantalla reporte de grupos
function CompromisosPaginaReporteGrupos()
{
    RedireccionPagina('grupos.php');
}

// Función para ingresar a la pantalla reporte de personas
function CompromisosPaginaReportePersonas()
{
    RedireccionPagina('personas.php');
}

// Función para cerrar sesión en el sistema
function CompromisosCerrarSesion()
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