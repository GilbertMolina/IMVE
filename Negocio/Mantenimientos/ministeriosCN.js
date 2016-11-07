/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de ministerios
function MinisteriosOnLoad(){
    MinisteriosCargarMinisteriosListado();
}

// Función que se ejecuta al cargar la pagina de ministerios detalle
function MinisteriosDetalleOnLoad(){
    MinisteriosCargarMinisterioPorId();
}

// Función para obtener todos los ministerios activos o inactivos
function MinisteriosCargarMinisteriosListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoMinisterio');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoMinisteriosPorEstado&estado=" + estado;

    // Enviar por Ajax a ministeriosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
        , success: function(a) {
            $("#listaMinisterios").html(a).listview("refresh");
        }
    })
}

// Función para registrar un ministerio
function MinisteriosRegistrarMinisterio() {
    var descripcion = $('#txtDescripcionMinisterio').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción del ministerio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarMinisterio&descripcion=" + descripcion;

        // Enviar por Ajax a ministeriosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
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
                        , title: 'Nuevo ministerio'
                        , content: 'El ministerio se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('ministerios.php');
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
                        , title: 'Nuevo ministerio'
                        , content: 'No se pudo agregar el ministerio, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para cargar un ministerio por su id
function MinisteriosCargarMinisterioPorId() {
    var idMinisterio = ObtenerParametroPorNombre('IdMinisterio');

    if(idMinisterio != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarMinisterio&idMinisterio=" + idMinisterio;

        // Enviar por Ajax a ministeriosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
            , success: function(a) {
                $("#ministeriosDetalle").html(a).trigger( "create" );
            }
        });
    }
}

// Función para modificar un ministerio
function MinisteriosModificarMinisterio(p_idMinisterio) {
    var idMinisterio = p_idMinisterio;
    var descripcion = $('#txtDescripcionMinisterio').val();
    var estado = $('#cboEstadoMinisterio').val();

    if(descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción y el estado del ministerio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarMinisterio&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&estado=" + estado;

        // Enviar por Ajax a ministeriosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
            , success: function(a)
            {
                // Se obtiene el resultado.
                if (a == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Modificar ministerio'
                        , content: 'El ministerio se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('ministerios.php');
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
                        , title: 'Modificar ministerio'
                        , content: 'No se pudo modificar el ministerio, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}