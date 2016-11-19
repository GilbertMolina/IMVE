/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de compromisos
function CompromisosOnLoad() {
    var listadoCompromisosJSON = CompromisosListarCompromisos();

    listadoCompromisosJSON.success(function(listadoCompromisos) {
        CompromisosCargarCalendario(jQuery.parseJSON(listadoCompromisos));
    });
}

// Función que se ejecuta al cargar la pagina de compromisos detalle
function CompromisosDetalleOnLoad() {
    CompromisosCambiarBarraNavegacionFooter();
    CompromisosCambiarTipoReponsable();
    CompromisosCargarCompromisoPorId();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function CompromisosCambiarBarraNavegacionFooter() {
    var IdGrupo = ObtenerParametroPorNombre('IdGrupo');
    var IdCompromiso = ObtenerParametroPorNombre('IdCompromiso');

    if(IdCompromiso != ''){
        $('#DesdeGrupos').hide();
    }

    if(IdGrupo != ''){
        $('#DesdeListaCompromisos').hide();
        $('#DesdeGrupos').css("display", "");
    }
    else{
        $('#DesdeGrupos').hide();
    }
}

// Función que carga el calendario según los eventos que le son pasados de un JSON
function CompromisosCargarCalendario(eventosCompromisos){
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today'
            , center: 'title'
            , right: 'month,agendaWeek,agendaDay'
        }
        , editable: false
        , eventLimit: true
        , events: eventosCompromisos
        , loading: function(bool) {
            $('#loading').toggle(bool);
        }
    });
}

// Función que obtiene todos los compromisos en formato JSON filtrados por estado
function CompromisosListarCompromisos(){
    var estado = "A";

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCompromisosPorEstado&estado=" + estado;

    // Enviar por Ajax a compromisosCAD.php
    return $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
    })
}

// Función para cargar un compromiso por su id
function CompromisosCargarCompromisoPorId() {
    var IdCompromiso = ObtenerParametroPorNombre('IdCompromiso');

    if(IdCompromiso != ''){

        console.log("Debo cargar el detalle del compromiso");

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarCompromiso&idCompromiso=" + IdCompromiso;

        // Enviar por Ajax a usuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
            , success: function(a) {
                $("#compromisosDetalle").html(a).trigger("create");
            }
        });
    }
    else
    {
        CompromisosAsignarFechaInicioFinal();
        CompromisosCargarMinisteriosComboBox();
        CompromisosCargarTiposCompromisosComboBox();
        CompromisosCargarPersonasResponsables();
        CompromisosCargarGruposResponsables();
        CompromisosCargarPersonasParticipantes();
    }
}

// Función para cambiar el tipo de responsable del compromiso
function CompromisosCambiarTipoReponsable(){
    var tipoResposable = ObtenerValorRadioButtonPorNombre('tipoResponsable');
    
    if(tipoResposable == 'P'){
        $('#divCompromisosPersonasResponsables').show();
        $('#divCompromisosGruposResponsables').hide();
    }
    else{
        $('#divCompromisosPersonasResponsables').hide();
        $('#divCompromisosGruposResponsables').show();
    }

    // Al cambiar el tipo de integrante se vuelven a cargar los select de personas y grupos responsables para limpiar los valores selecccionados
    CompromisosCargarPersonasResponsables();
    CompromisosCargarGruposResponsables();
}

// Función que carga la fecha actual en el campo de fecha de inicio y fecha final
function CompromisosAsignarFechaInicioFinal()
{
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth() + 1;
    var a = date.getFullYear();
    var h = date.getHours();
    var mi = date.getMinutes();
    var fechaCompleta = a + '-' + m + '-' + d + 'T' + h + ':' + mi;

    document.getElementById("txtFechaInicio").defaultValue = fechaCompleta;
}

// Función para obtener todos los ministerios activos
function CompromisosCargarMinisteriosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoMinisteriosActivosCombobox";

    // Enviar por Ajax a ministeriosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
        , success: function(a) {
            $("#cboIdMinisterios").html(a).trigger("create");
        }
    })
}

// Función para obtener todos los tipos compromisos activos
function CompromisosCargarTiposCompromisosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposCompromisosActivosCombobox";

    // Enviar por Ajax a tiposCompromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposCompromisosCAD.php"
        , success: function(a) {
            $("#cboIdTiposCompromisos").html(a).trigger("create");
        }
    })
}

// Función para obtener todas las personas activos y mostrarlas al usuarios para que seleccione cual de ellas son responsables
function CompromisosCargarPersonasResponsables()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasResponsablesGruposListado";

    // Limpiar el valor del select cuando se hace el cambio del tipo de integrante
    $("#CompromisosPersonasResponsables").html("<option>Seleccione</option>").selectmenu('refresh');

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#CompromisosPersonasResponsables").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todos los grupos activos y mostrarlos al usuarios para que seleccione cual de ellos son responsables
function CompromisosCargarGruposResponsables()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerGruposParticipantesListado";

    // Limpiar el valor del select cuando se hace el cambio del tipo de integrante
    $("#CompromisosGruposResponsables").html("<option>Seleccione</option>").selectmenu('refresh');

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        , success: function(a) {
            $("#CompromisosGruposResponsables").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todas las personas activos y mostrarlas al usuarios para que seleccione cual de ellas son participantes
function CompromisosCargarPersonasParticipantes()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasLideresListado";

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#CompromisosPersonasParticipantes").html(a).selectmenu('refresh');
        }
    })
}

// Función para registrar un compromiso
function CompromisoRegistrarCompromiso() {
    var tipoResposable   = ObtenerValorRadioButtonPorNombre('tipoResponsable');

    var idMinisterio     = $('#cboIdMinisterios').val();
    var idTipoCompromiso = $('#cboIdTiposCompromisos').val();
    var descripcion      = $('#txtDescripcionCompromiso').val();
    var lugar            = $('#txtLugar').val();
    var fechaInicio      = $('#txtFechaInicio').val();
    var fechaFinal       = $('#txtFechaFinal').val();

    var personasResponsables;
    var listaPersonasResponsablesJson;
    var gruposResponsables;
    var listaGruposResponsablesJson;

    if(tipoResposable == 'P'){
        personasResponsables          = $('#CompromisosPersonasResponsables').val();
        listaPersonasResponsablesJson = JSON.stringify(personasResponsables);
    }
    else{
        gruposResponsables          = $('#CompromisosGruposResponsables').val();
        listaGruposResponsablesJson = JSON.stringify(gruposResponsables);
    }

    var personasParticipantes          = $('#CompromisosPersonasParticipantes').val();
    var listaPersonasParticipantesJson = JSON.stringify(personasParticipantes);

    if(idMinisterio == 0
        && idTipoCompromiso == 0
        && descripcion == ""
        && fechaInicio == ""
        && fechaFinal == ""
        && lugar == "")
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
        // Se define el action que será consultado desde la clase de acceso a datos dependiendo del tipo de resposable
        var d = "";

        if(tipoResposable == 'P'){
            d = "action=registrarCompromiso&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar + "&fechaInicio=" + fechaInicio
                + "&fechaFinal=" + fechaFinal + "&listaPersonasResponsables=" + listaPersonasResponsablesJson + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson + "&tipoResposable=" + tipoResposable;
        }
        else{
            d = "action=registrarCompromiso&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar + "&fechaInicio=" + fechaInicio
                + "&fechaFinal=" + fechaFinal + "&listaGruposResponsables=" + listaGruposResponsablesJson + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson + "&tipoResposable=" + tipoResposable;
        }

        // Enviar por Ajax a compromisosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
            , success: function(a)
            {
                console.log('El valor de a es: ' + a);

                // Se divide la variable separandola por comas.
                var resultado = a;

                if(resultado == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Información'
                        , content: 'El compromiso se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('compromisos.php');
                        }
                    });
                }
                else if(resultado.includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'El compromiso ya se encuentra registrado.'
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
                        , content: 'No se pudo agregar el compromiso, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}