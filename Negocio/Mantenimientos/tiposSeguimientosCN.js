/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposSeguimientosOnLoad(){
    TiposSeguimientosCargarTiposSeguimientosActivosListado();
}

// Función para obtener todos los tipos de seguimientos activos
function TiposSeguimientosCargarTiposSeguimientosActivosListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposSeguimientosActivos";

    // Enviar por Ajax a tiposSeguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposSeguimientosCAD.php"
        , success: function(a) {
            $("#listaTiposSeguimientos").html(a).listview("refresh");
        }
    })
}

// Función para registrar un tipo de seguimiento
function TiposSeguimientosRegistrarTipoSeguimiento()
{
    var descripcion = $('#txtDescripcionTipoSeguimiento').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción del tipo de seguimiento'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarTipoSeguimiento&descripcion=" + descripcion;

        // Enviar por Ajax a tiposSeguimientosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/tiposSeguimientosCAD.php"
            , success: function(a)
            {
                // Se divide la variable separandola por comas.
                var resultado = a.split(',');

                if(resultado[0] == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Nuevo tipo de seguimiento'
                        , content: 'El tipo de seguimiento se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('tiposSeguimientos.php');
                        }
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Nuevo tipo de seguimiento'
                        , content: 'No se pudo agregar el tipo de seguimiento, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}
