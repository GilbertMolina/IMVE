/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

// Función que se ejecuta al cargar la pagina
function PersonasRelacionesPersonalesOnLoad() {
    PersonasRelacionesPersonalesCargarTiposRelaciones();
    PersonasRelacionesPersonalesCargarPersonas();
    PersonasRelacionesPersonalesCargarRelacionesPersonalesListado();
}

// Función para obtener todas las personas
function PersonasRelacionesPersonalesCargarPersonas() {
    var idPersonaRelacionado2 = ObtenerParametroPorNombre('IdPersona');
    
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasRelacionesPersonales&idPersonaRelacionado2=" + idPersonaRelacionado2;

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#cboIdPersona").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todas los tipos de relaciones
function PersonasRelacionesPersonalesCargarTiposRelaciones() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposRelaciones";

    // Enviar por Ajax a tiposRelacionesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
        , success: function(a) {
            $("#cboIdTipoRelacion").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todos las relaciones personales de la persona específicada 
function PersonasRelacionesPersonalesCargarRelacionesPersonalesListado() {
    var idPersonaRelacionado2 = ObtenerParametroPorNombre('IdPersona');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoPersonasRelacionesPorIdPersona&idPersonaRelacionado2=" + idPersonaRelacionado2;

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasRelacionesPersonasCAD.php"
        , success: function(a) {
            $("#divListaRelacionesPersonales").html(a).trigger("create");
        }
    })
}

// Función para registrar un tipo de relacion persona
function PersonasRelacionesPersonalesRegistrarRelacion() {
    var idTipoRelacionUnidos  = $('#cboIdTipoRelacion').val();
    var idPersonaRelacionado1 = $('#cboIdPersona').val();
    var idPersonaRelacionado2 = ObtenerParametroPorNombre('IdPersona');

    if (idTipoRelacionUnidos == 0
        || idPersonaRelacionado1 == 0)
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar tanto el tipo de relación, como la persona que va a relacionar.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
        return false;
    }

    var idTipoRelacion = idTipoRelacionUnidos.split('-')[0];
    var tipoRelacion = idTipoRelacionUnidos.split('-')[1];
    var d;

    // Se define el action que será consultado desde la clase de acceso a datos
    if(tipoRelacion == 'R'){
        d = "action=registrarTipoRelacionPersona&idTipoRelacion=" + idTipoRelacion + "&idPersonaRelacionado1=" + idPersonaRelacionado1 + "&idPersonaRelacionado2=" + idPersonaRelacionado2;
    }
    else{
        d = "action=registrarTipoRelacionPersona&idTipoRelacion=" + idTipoRelacion + "&idPersonaRelacionado1=" + idPersonaRelacionado2 + "&idPersonaRelacionado2=" + idPersonaRelacionado1;
    }

    // Enviar por Ajax a personasRelacionesPersonasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasRelacionesPersonasCAD.php"
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
                    , title: 'Información'
                    , content: 'La relación se registró satisfactoriamente.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-success'
                    , confirm: function(){
                        PersonasRelacionesPersonalesOnLoad();
                    }
                });
            }
            else if(resultado[0].includes("Duplicate"))
            {
                $.alert({
                    theme: 'material'
                    , animationBounce: 1.5
                    , animation: 'rotate'
                    , closeAnimation: 'rotate'
                    , title: 'Advertencia'
                    , content: 'La relación ya se encuentra registrada.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-warning'
                });
            }
            else
            {
                $.alert({
                    theme: 'material'
                    , animationBounce: 1.5
                    , animation: 'rotate'
                    , closeAnimation: 'rotate'
                    , title: 'Error'
                    , content: 'No se pudo agregar la relación, intente de nuevo.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-danger'
                });
            }
        }
    });
}

// Función que se ejecuta al presionar el botón de eliminar
function PersonasRelacionesPersonalesEliminar(p_IdTipoRelacion, p_TipoRelacion, p_IdPersonaRelacionado1, p_IdPersonaRelacionado2){
    var idTipoRelacion = p_IdTipoRelacion;
    var tipoRelacion = p_TipoRelacion;
    var idPersonaRelacionado1 = p_IdPersonaRelacionado1;
    var idPersonaRelacionado2 = p_IdPersonaRelacionado2;

    $.confirm({
        theme: 'material'
        , animationBounce: 1.5
        , animation: 'rotate'
        , closeAnimation: 'rotate'
        , title: '<span class="jconfirm-customize">Confirmación</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
        , content: '<span class="jconfirm-customize">¿Esta seguro que desea eliminar la relación seleccionada?</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
        , confirmButton: 'Aceptar'
        , confirmButtonClass: 'btn-success'
        , cancelButton: 'Cancelar'
        , cancelButtonClass: 'btn-danger'
        , confirm: function(){
            var d;

            // Se define el action que será consultado desde la clase de acceso a datos
            if(tipoRelacion == 'R'){
                d = "action=eliminarTipoRelacionPersona&idTipoRelacion=" + idTipoRelacion + "&idPersonaRelacionado1=" + idPersonaRelacionado1 + "&idPersonaRelacionado2=" + idPersonaRelacionado2;
            }else{
                d = "action=eliminarTipoRelacionPersona&idTipoRelacion=" + idTipoRelacion + "&idPersonaRelacionado1=" + idPersonaRelacionado2 + "&idPersonaRelacionado2=" + idPersonaRelacionado1;
            }

            // Enviar por Ajax a personasRelacionesPersonasCAD.php
            $.ajax({
                type: "POST"
                , data: d
                , url: "../../../IMVE/Datos/Procesos/personasRelacionesPersonasCAD.php"
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
                            , title: 'Información'
                            , content: 'La relación se eliminó satisfactoriamente.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-success'
                            , confirm: function(){
                                PersonasRelacionesPersonalesCargarRelacionesPersonalesListado();
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
                            , title: 'Error'
                            , content: 'No se pudo eliminar la relación.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-danger'
                        });
                    }
                }
            });
        }
    });
}