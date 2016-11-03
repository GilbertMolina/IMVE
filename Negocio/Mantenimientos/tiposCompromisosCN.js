/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposCompromisosOnLoad(){
    TiposCompromisosCargarTiposCompromisosActivosListado();
}

// Función para obtener todos los tipos de compromisos activos
function TiposCompromisosCargarTiposCompromisosActivosListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposCompromisosActivos";

    // Enviar por Ajax a tiposCompromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposCompromisosCAD.php"
        , success: function(a) {
            $("#listaTiposCompromisos").html(a).listview("refresh");
        }
    })
}

// Función para registrar un tipo de compromiso
function TiposCompromisosRegistrarTipoCompromiso()
{
    var descripcion = $('#txtDescripcionTipoCompromiso').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción del tipo de compromiso'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarTipoCompromiso&descripcion=" + descripcion;

        // Enviar por Ajax a tiposCompromisosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/tiposCompromisosCAD.php"
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
                        , title: 'Nuevo tipo de compromiso'
                        , content: 'El tipo de compromiso se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('tiposCompromisos.php');
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
                        , title: 'Nuevo tipo de compromiso'
                        , content: 'No se pudo agregar el tipo de compromiso, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}