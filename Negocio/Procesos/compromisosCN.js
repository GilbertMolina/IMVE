/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de compromisos
function CompromisosOnLoad() {
    CompromisosCargarCalendario();
}

// Función que carga el calendario de compromisos según el estado
function CompromisosCargarCalendario() {
    var listadoCompromisosJSON = CompromisosListarCompromisos();

    listadoCompromisosJSON.success(function(listadoCompromisos) {
        CompromisosMostrarCalendarioConCompromisos(jQuery.parseJSON(listadoCompromisos));
        $('#calendar').load();
    });
}

// Función que se ejecuta al cargar la pagina de compromisos detalle
function CompromisosDetalleOnLoad() {
    CompromisosCambiarBarraNavegacionFooter();
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
function CompromisosMostrarCalendarioConCompromisos(eventosCompromisos){
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today'
            , center: 'title'
            , right: 'month,agendaWeek,agendaDay'
        }
        , editable: false
        , eventLimit: true
        , events: eventosCompromisos
        , allDayDefault: false
    });
}

// Función que obtiene todos los compromisos en formato JSON filtrados por estado
function CompromisosListarCompromisos(){
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCompromisosPorEstado";

    // Enviar por Ajax a compromisosCAD.php
    return $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
    });
}

// Función para cargar un compromiso por su id
function CompromisosCargarCompromisoPorId() {
    var IdCompromiso = ObtenerParametroPorNombre('IdCompromiso');

    if(IdCompromiso != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarCompromiso&idCompromiso=" + IdCompromiso;

        // Enviar por Ajax a usuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
            , success: function(a) {
                $("#compromisosDetalle").html(a).trigger("create");

                var personasResponsables = $('#CompromisosPersonasResponsables').val();
                var gruposResponsables = $('#CompromisosGruposResponsables').val();

                if(personasResponsables != null){
                    $('#divCompromisosPersonasResponsables').show();
                    $('#divCompromisosGruposResponsables').hide();
                }
                else{
                    $('#divCompromisosPersonasResponsables').hide();
                    $('#divCompromisosGruposResponsables').show();
                }

                if(gruposResponsables != null){
                    $('#divCompromisosPersonasResponsables').hide();
                    $('#divCompromisosGruposResponsables').show();
                }
                else{
                    $('#divCompromisosPersonasResponsables').show();
                    $('#divCompromisosGruposResponsables').hide();
                }
            }
        });
    }
    else
    {
        CompromisosAsignarFechaInicioFinal();
        CompromisosCambiarTipoResponsable();
        CompromisosCargarMinisteriosComboBox();
        CompromisosCargarTiposCompromisosComboBox();
        CompromisosCargarPersonasResponsables();
        CompromisosCargarGruposResponsables();
        CompromisosCargarPersonasParticipantes();
    }
}

// Función para cambiar el tipo de responsable del compromiso
function CompromisosCambiarTipoResponsable(){
    var tipoResponsable = ObtenerValorRadioButtonPorNombre('tipoResponsable');
    
    if(tipoResponsable == 'P'){
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
    var mi  = (date.getMinutes().toString().length == 1) ? '0' + date.getMinutes() : date.getMinutes();
    var h  = (date.getHours().toString().length == 1) ? '0' + date.getHours() : date.getHours();
    var d = (date.getDate().toString().length == 1) ? '0' + date.getDate() : date.getDate();
    var m  = date.getMonth() + 1;
    m = (m.toString().length == 1) ? '0' + m : m;
    var a  = date.getFullYear();
    var fechaHoy = a + '-' + m + '-' + d + 'T' + h + ':' + mi;

    $("#txtFechaInicio").attr("value", fechaHoy);
    $("#txtFechaFinal").attr("value", fechaHoy);
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
    var tipoResponsable   = ObtenerValorRadioButtonPorNombre('tipoResponsable');

    var idMinisterio     = $('#cboIdMinisterios').val();
    var idTipoCompromiso = $('#cboIdTiposCompromisos').val();
    var descripcion      = $('#txtDescripcionCompromiso').val();
    var lugar            = $('#txtLugar').val();
    var fechaInicio      = $('#txtFechaInicio').val();
    var fechaFinal       = $('#txtFechaFinal').val();

    // Se convierten las fechas a milisegundos para compararlas
    var fechaInicioMilisegundos = new Date(fechaInicio);
    fechaInicioMilisegundos = fechaInicioMilisegundos.getTime();
    var fechaFinalMilisegundos = new Date(fechaFinal);
    fechaFinalMilisegundos = fechaFinalMilisegundos.getTime();

    var personasResponsables;
    var listaPersonasResponsablesJson;
    var gruposResponsables;
    var listaGruposResponsablesJson;

    if(tipoResponsable == 'P'){
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
        return false;
    }
    if(fechaInicioMilisegundos > fechaFinalMilisegundos
        || fechaInicioMilisegundos === fechaFinalMilisegundos)
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'La fecha final debe ser mayor a la fecha de inicio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos dependiendo del tipo de resposable
        var d = "";

        if(tipoResponsable == 'P'){
            d = "action=registrarCompromiso&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar + "&fechaInicio=" + fechaInicio
                + "&fechaFinal=" + fechaFinal + "&listaPersonasResponsables=" + listaPersonasResponsablesJson + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson + "&tipoResposable=" + tipoResponsable;
        }
        else{
            d = "action=registrarCompromiso&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar + "&fechaInicio=" + fechaInicio
                + "&fechaFinal=" + fechaFinal + "&listaGruposResponsables=" + listaGruposResponsablesJson + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson + "&tipoResposable=" + tipoResponsable;
        }

        // Enviar por Ajax a compromisosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
            , success: function(a)
            {
                // Se obtiene el resultado.
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

// Función para modificar un compromiso
function CompromisoModificarCompromiso(p_IdCompromiso){
    var tipoResponsable   = ObtenerValorRadioButtonPorNombre('tipoResponsable');

    var idCompromiso = p_IdCompromiso;
    var idMinisterio     = $('#cboIdMinisterios').val();
    var idTipoCompromiso = $('#cboIdTiposCompromisos').val();
    var descripcion      = $('#txtDescripcionCompromiso').val();
    var lugar            = $('#txtLugar').val();
    var fechaInicio      = $('#txtFechaInicio').val();
    var fechaFinal       = $('#txtFechaFinal').val();
    var estado           = $('#cboEstadoCompromiso').val();

    // Se convierten las fechas a milisegundos para compararlas
    var fechaInicioMilisegundos = new Date(fechaInicio);
    fechaInicioMilisegundos = fechaInicioMilisegundos.getTime();
    var fechaFinalMilisegundos = new Date(fechaFinal);
    fechaFinalMilisegundos = fechaFinalMilisegundos.getTime();
    
    // Se obtiene el tipo de responsable inicial
    var tipoResponsableInicial = $('#hdfTipoResponsable').val();
    
    // Se obtiene la lista inicial de las personas y grupos responsables, así como tambien las personas participantes
    if(tipoResponsable == 'P'){
        var listadoInicialPersonasResponsables = $('#hdfPersonasResponsables').val();
    }
    else{
        var listadoInicialGruposResponsables   = $('#hdfGruposResponsables').val();
    }
    var listadoInicialParticipantes        = $('#hdfParticipantes').val();

    // Se obtiene la lista actual de las personas y grupos responsables, así como tambien las personas participantes
    if(tipoResponsable == 'P'){
        var personasResponsables = $('#CompromisosPersonasResponsables').val();
    }
    else{
        var gruposResponsables = $('#CompromisosGruposResponsables').val();
    }
    var participantes = $('#CompromisosPersonasParticipantes').val();

    // Se convierten a formato JSON las listas
    if(tipoResponsable == 'P'){
        var listaPersonasResponsablesAgregadasJson = JSON.stringify(ObtenerValoresAgregados(listadoInicialPersonasResponsables,personasResponsables));
        var listaPersonasResponsablesEliminadasJson = JSON.stringify(ObtenerValoresEliminados(listadoInicialPersonasResponsables,personasResponsables));
    }
    else{
        var listaGruposResponsablesAgregadosJson = JSON.stringify(ObtenerValoresAgregados(listadoInicialGruposResponsables,gruposResponsables));
        var listaGruposResponsablesEliminadosJson = JSON.stringify(ObtenerValoresEliminados(listadoInicialGruposResponsables,gruposResponsables));
    }
    var listaParticipantesAgregadosJson = JSON.stringify(ObtenerValoresAgregados(listadoInicialParticipantes,participantes));
    var listaParticipantesEliminadosJson = JSON.stringify(ObtenerValoresEliminados(listadoInicialParticipantes,participantes));

    if(idMinisterio == 0
        && idTipoCompromiso == 0
        && descripcion == ""
        && fechaInicio == ""
        && fechaFinal == ""
        && lugar == ""
        && estado == 0)
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
    if(fechaInicioMilisegundos > fechaFinalMilisegundos
        || fechaInicioMilisegundos === fechaFinalMilisegundos)
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'La fecha final debe ser mayor a la fecha de inicio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos dependiendo del tipo de resposable
        var d = "";

        if(tipoResponsable == 'P'){
            d = "action=modificarCompromiso&idCompromiso=" + idCompromiso + "&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar
                + "&fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal + "&listaPersonasResponsablesAgregadas=" + listaPersonasResponsablesAgregadasJson + "&listaPersonasResponsablesEliminadas=" + listaPersonasResponsablesEliminadasJson
                + "&listaParticipantesAgregados=" + listaParticipantesAgregadosJson + "&listaParticipantesEliminados=" + listaParticipantesEliminadosJson + "&listaParticipantesEliminados=" + listaParticipantesEliminadosJson
                + "&tipoResponsable=" + tipoResponsable + "&tipoResponsableInicial=" + tipoResponsableInicial + "&estado=" + estado;
        }
        else{
            d = "action=modificarCompromiso&idCompromiso=" + idCompromiso + "&idMinisterio=" + idMinisterio + "&idTipoCompromiso=" + idTipoCompromiso + "&descripcion=" + descripcion + "&lugar=" + lugar
                + "&fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal + "&listaGruposResponsablesAgregados=" + listaGruposResponsablesAgregadosJson + "&listaGruposResponsablesEliminados=" + listaGruposResponsablesEliminadosJson
                + "&listaParticipantesAgregados=" + listaParticipantesAgregadosJson + "&listaParticipantesEliminados=" + listaParticipantesEliminadosJson + "&listaParticipantesEliminados=" + listaParticipantesEliminadosJson
                + "&tipoResponsable=" + tipoResponsable + "&tipoResponsableInicial=" + tipoResponsableInicial + "&estado=" + estado;
        }

        // // Enviar por Ajax a compromisosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
            , success: function(a)
            {
                // Se obtiene el resultado.
                var resultado = a;

                if(resultado == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Información'
                        , content: 'El compromiso se modificó satisfactoriamente.'
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
                        , content: 'No se pudo modificar el compromiso, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}