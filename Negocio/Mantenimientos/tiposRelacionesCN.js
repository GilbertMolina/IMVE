/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de tipos de relaciones
function TiposRelacionesOnLoad(){
    TiposRelacionesCargarTiposRelacionesListado();
}

// Función que se ejecuta al cargar la pagina de tipos de relaciones detalle
function TiposRelacionesDetalleOnLoad(){
    TiposRelacionesCargarTipoRelacionPorId();
}

// Función para obtener todos los tipos de relaciones activas o inactivas
function TiposRelacionesCargarTiposRelacionesListado() {
    var tipoRelacion = ObtenerValorRadioButtonPorNombre('tipoRelacion');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRelacionesPorTipoRelacion&tipoRelacion=" + tipoRelacion;

    // Enviar por Ajax a tiposRelacionesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
        , success: function(a) {
            $("#listaTiposRelaciones").html(a).listview("refresh");
        }
    })
}

// Función para registrar un tipo de relacion
function TiposRelacionesRegistrarTipoRelacion() {
    var tipoRelacion           = ObtenerValorRadioButtonPorNombre('tipoRelacion');
    var nombreMasculino        = $('#txtNombreMasculino').val();
    var nombreFemenino         = $('#txtNombreFemenino').val();
    var nombreInversoMasculino = $('#txtNombreInversoMasculino').val();
    var nombreInversoFemenino  = $('#txtNombreInversoFemenino').val();

    if (tipoRelacion == 'V')
    {
        if(nombreMasculino == ""
            || nombreFemenino == ""
            || nombreInversoMasculino == ""
            || nombreInversoFemenino == "")
        {
            $.alert({
                theme: 'material'
                , animationBounce: 1.5
                , animation: 'rotate'
                , closeAnimation: 'rotate'
                , title: 'Datos incompletos'
                , content: 'Debe de ingresar todos los campos del formulario'
                , confirmButton: 'Aceptar'
                , confirmButtonClass: 'btn-warning'
            });
            return false;
        }
    }
    else
    {
        if(nombreMasculino == ""
            || nombreFemenino == "")
        {
            $.alert({
                theme: 'material'
                , animationBounce: 1.5
                , animation: 'rotate'
                , closeAnimation: 'rotate'
                , title: 'Datos incompletos'
                , content: 'Debe de ingresar todos los campos del formulario'
                , confirmButton: 'Aceptar'
                , confirmButtonClass: 'btn-warning'
            });
            return false;
        }
    }

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=registrarTipoRelacion&nombreMasculino=" + nombreMasculino + "&nombreFemenino=" + nombreFemenino + "&nombreInversoMasculino=" + nombreInversoMasculino + "&nombreInversoFemenino=" + nombreInversoFemenino;

    // Enviar por Ajax a tiposRelacionesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
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
                    , title: 'Nuevo tipo de relación'
                    , content: 'El tipo de relación se agregó satisfactoriamente.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-success'
                    , confirm: function(){
                        RedireccionPagina('tiposRelaciones.php');
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
                    , title: 'Nuevo tipo de relación'
                    , content: 'No se pudo agregar el tipo de relación, intente de nuevo.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-danger'
                });
            }
        }
    });
}

// Función para cargar un tipo de relacion por su id
function TiposRelacionesCargarTipoRelacionPorId() {
    var idTipoRelacion = ObtenerParametroPorNombre('IdTipoRelacion');

    if(idTipoRelacion != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarTipoRelacion&idTipoRelacion=" + idTipoRelacion;

        // Enviar por Ajax a tiposRelacionesCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
            , success: function(a) {
                $("#tiposRelacionesDetalle").html(a).trigger( "create" );
            }
        });
    }
}

// Función para modificar un tipo de relacion
function TiposRelacionesModificarTipoRelacion(p_idTipoRelacion) {
    var idTipoRelacion         = p_idTipoRelacion;
    var nombreMasculino        = $('#txtNombreMasculino').val();
    var nombreFemenino         = $('#txtNombreFemenino').val();
    var nombreInversoMasculino = $('#txtNombreInversoMasculino').val();
    var nombreInversoFemenino  = $('#txtNombreInversoFemenino').val();
    var estado                 = $('#cboEstadoTipoCompromiso').val();

    if(nombreMasculino == ""
        || nombreFemenino == ""
        || nombreInversoMasculino == ""
        || nombreInversoFemenino == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar todos los campos del formulario'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarTipoRelacion&idTipoRelacion=" + idTipoRelacion + "&nombreMasculino=" + nombreMasculino + "&nombreFemenino=" + nombreFemenino + "&nombreInversoMasculino=" + nombreInversoMasculino + "&nombreInversoFemenino=" + nombreInversoFemenino;

        // Enviar por Ajax a tiposRelacionesCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
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
                        , title: 'Modificar tipo de relación'
                        , content: 'El tipo de relación se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('tiposRelaciones.php');
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
                        , title: 'Modificar tipo de relación'
                        , content: 'No se pudo modificar el tipo de relación, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función que se oculta los input de nombre relación inversa masculino y nombre relación inversa femenino
function TiposRelacionesDetalleOcultarCamposRelacionesLineal(){
    var tipoRelacion = ObtenerValorRadioButtonPorNombre('tipoRelacion');

    if(tipoRelacion == 'H')
    {
        $('#tipoRelacionNoLineal').hide();
    }
    else
    {
        $('#tipoRelacionNoLineal').show();
    }
}
