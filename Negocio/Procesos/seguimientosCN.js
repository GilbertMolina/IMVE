/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de seguimientos
function SeguimientosOnLoad() {
    SeguimientosCargarSeguimientosListado();
}

// Función que se ejecuta al cargar la pagina de seguimientos detalle
function SeguimientosDetalleOnLoad() {
    SeguimientosCargarSeguimientoPorId();
    SeguimientosCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function SeguimientosCambiarBarraNavegacionFooter() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){
        $('#NuevoSeguimiento').hide();
    }
    else{
        $('#DetalleSeguimiento').hide();
    }
}

// Función que carga la fecha actual mas 7 días del seguimiento en el campo de fecha propuesta
function SeguimientosAsignarFechaPropuesta(){
    var fechaPropuesta = SumarRestaFecha(0);
    $("#txtFechaPropuesta").attr("value", fechaPropuesta);
}

// Función para cargar un seguimiento por su id
function SeguimientosCargarSeguimientoPorId() {
    var idSeguimiento = ObtenerParametroPorNombre('IdSeguimiento');

    if(idSeguimiento != ''){
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarSeguimiento&idSeguimiento=" + idSeguimiento;

        // Enviar por Ajax a seguimientosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
            , success: function(a) {
                $("#seguimientosDetalle").html(a).trigger( "create" );
            }
        });
    }
    else{
        SeguimientosCargarTiposSeguimientosComboBox();
        SeguimientosAsignarFechaPropuesta();
    }
}

// Función para obtener todos los seguimientos activos o inactivos para la visita seleccionada
function SeguimientosCargarSeguimientosListado() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');
    var estado   = ObtenerValorRadioButtonPorNombre('estadoSeguimientos');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoSeguimientosPorVisitaEstado&IdVisita=" + IdVisita + "&estado=" + estado;

    // Enviar por Ajax a seguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
        , success: function(a) {
            $("#listaSeguimientos").html(a).listview("refresh");
        }
    })
}

// Función para obtener todos los ministerios activos
function SeguimientosCargarTiposSeguimientosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposSeguimientosActivosCombobox";

    // Enviar por Ajax a tiposSeguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposSeguimientosCAD.php"
        , success: function(a) {
            $("#cboIdTipoSeguimiento").html(a).trigger("create");
        }
    })
}

// Función para registrar un seguimiento
function SeguimientosRegistrarSeguimiento(p_idVisita) {
    var idVisita = p_idVisita;
    var tipoSeguimiento = $('#cboIdTipoSeguimiento').val();
    var descripcion = $('#txtDescripcionSeguimiento').val();
    var fechaPropuesta = $('#txtFechaPropuesta').val();
    var observaciones = $('#txtObservacionesSeguimiento').val();
    var estado = $('#cboEstadoSeguimiento').val();

    if(tipoSeguimiento == "0"
        || descripcion == ""
        || fechaPropuesta == ""
        || observaciones == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de ingresar los datos que son necesarios del formulario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarSeguimiento&idVisita=" + idVisita + "&tipoSeguimiento=" + tipoSeguimiento + "&descripcion=" + descripcion + "&fechaPropuesta=" + fechaPropuesta
            + "&observaciones=" + observaciones + "&estado=" + estado;

        // Enviar por Ajax a seguimientosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
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
                        , content: 'El seguimiento se registró satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('seguimientos.php?IdVisita=' + p_idVisita);
                        }
                    });
                }
                else if(a.includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'Un seguimiento con la misma descripción ya se encuentra registrado.'
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
                        , content: 'No se pudo registrar el seguimiento, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para modificar un seguimiento
function SeguimientosModificarSeguimiento(p_idVisita,p_idSeguimiento) {
    var idVisita = p_idVisita;
    var idSeguimiento = p_idSeguimiento;
    var tipoSeguimiento = $('#cboIdTipoSeguimiento').val();
    var descripcion = $('#txtDescripcionSeguimiento').val();
    var fechaPropuesta = $('#txtFechaPropuesta').val();
    var fechaRealizacion = $('#txtFechaRealizacion').val();
    var observaciones = $('#txtObservacionesSeguimiento').val();
    var estado = $('#cboEstadoSeguimiento').val();

    if(tipoSeguimiento == "0"
        || descripcion == ""
        || fechaPropuesta == ""
        || estado == 0)
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de ingresar los datos que son necesarios del formulario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    if(fechaRealizacion == ''
        && estado == "S")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Si el seguimiento está siendo cerrado, debe de ingresar la fecha de realización.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarSeguimiento&idVisita=" + idVisita + "&idSeguimiento=" + idSeguimiento + "&tipoSeguimiento=" + tipoSeguimiento + "&descripcion=" + descripcion + "&fechaPropuesta=" + fechaPropuesta
            + "&fechaRealizacion=" + fechaRealizacion + "&observaciones=" + observaciones + "&estado=" + estado;

        // Enviar por Ajax a seguimientosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
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
                        , content: 'El seguimiento se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('seguimientos.php?IdVisita=' + p_idVisita);
                        }
                    });
                }
                else if(a.includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'Un seguimiento con la misma descripción ya se encuentra registrado.'
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
                        , content: 'No se pudo modificar el seguimiento, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}