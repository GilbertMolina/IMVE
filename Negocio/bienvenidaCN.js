/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

// Función para cerrar sesión en el sistema
function CerrarSesion()
{
    $.confirm({
        theme: 'material'
        , animationBounce: 1.5
        , animation: 'rotate'
        , closeAnimation: 'rotate'
        , title: '<span class="jconfirmCustomize">Cerrar sesión</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
        , content: '<span class="jconfirmCustomize">¿Esta seguro que desea cerrar la sesión?</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
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
                , url: "../Datos/indexCAD.php"
                , success: function(a)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: '<span class="jconfirmCustomize">Ha cerrado la sesión</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
                        , content: '<span class="jconfirmCustomize">Esperamos que vuelva pronto.</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('../index.php');
                        }
                    });
                }
            });
        }
    });
}