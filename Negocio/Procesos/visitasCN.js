/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de visitas
function VisitasOnLoad() {
    VisitasCargarVisitasListado();
}

// Función que se ejecuta al cargar la pagina de visitas detalle
function VisitasDetalleOnLoad() {
    VisitasCargarVisitaPorId();
    VisitasAsignarFechaVisita();
    VisitasCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function VisitasCambiarBarraNavegacionFooter() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){
        $('#NuevaVisita').hide();
    }
    else{
        $('#DetalleVisita').hide();
    }
}

// Función que carga la fecha actual en el campo de fecha visita
function VisitasAsignarFechaVisita(){
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth() + 1;
    var a = date.getFullYear();
    var fechaHoy = a + '-' + m + '-' + d;

    $("#txtFechaVisita").attr("value", fechaHoy);
}

// Función para obtener todos los ministerios activos o inactivos
function VisitasCargarVisitasListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoVisitas');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoVisitasPorEstado&estado=" + estado;

    // Enviar por Ajax a visitasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/visitasCAD.php"
        , success: function(a) {
            $("#listaVisitas").html(a).listview("refresh");
        }
    })
}

// Función para cargar un ministerio por su id
function VisitasCargarVisitaPorId() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarVisitas&idVisita=" + IdVisita;

        // Enviar por Ajax a visitasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/visitasCAD.php"
            , success: function(a) {
                $("#visitasDetalle").html(a).trigger( "create" );
            }
        });
    }
    else
    {
        VisitasCargarMinisteriosComboBox();
        VisitasCargarPersonasVisitantes();
        VisitasCargarPersonasResponsablesComboBox();
    }
}

// Función para obtener todos los ministerios activos
function VisitasCargarMinisteriosComboBox()
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

// Función para obtener todas las personas activas
function VisitasCargarPersonasResponsablesComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoPersonasActivasCombobox";

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#IdResponsables").html(a).trigger("create");
        }
    })
}

// Función para obtener todas las personas y mostralos al usuarios para que seleccione en los cuales son participantes
function VisitasCargarPersonasVisitantes()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasVisitantesListado";

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#VisitasPersonasVisitas").html(a).selectmenu('refresh');
        }
    })
}

// Función para registrar un visita
function VisitasRegistrarVisita() {
    var idMinisterio        = $('#cboIdMinisterios').val();
    var descripcion         = $('#txtDescripcionVisita').val();
    var fechaVisita         = $('#txtFechaVisita').val();
    var idPersonaReponsable = $('#cboIdResponsables').val();

    var personasParticipante = $('#VisitasPersonasVisitas').val();
    var listaPersonasParticipantesJson = JSON.stringify(personasParticipante);

    if(idMinisterio == 0
        || descripcion == ""
        || fechaVisita == "")
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
        var d = "action=registrarVisita&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&fechaVisita=" + fechaVisita + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson + "&idPersonaReponsable=" + idPersonaReponsable;

        // Enviar por Ajax a visitasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/visitasCAD.php"
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
                        , content: 'La visita se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('visitas.php');
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
                        , content: 'La visita ya se encuentra registrada.'
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
                        , content: 'No se pudo agregar la visita, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para modificar un grupo
function VisitasModificarVisita(p_idVisita) {
    var idVisita          = p_idVisita;
    var idMinisterio     = $('#cboIdMinisterios').val();
    var descripcion      = $('#txtDescripcionVisita').val();
    var fechaVisita      = $('#txtFechaVisita').val();
    var estado           = $('#cboEstadoVisita').val();

    // Se obtiene la lista inicial de las personas visitantes
    var listadoInicialPersonasVisitante = $('#hdfVisitasPersonasVisitantes').val();

    // Se obtiene la lista actual de las personas que son visitantes
    var personasParticipante = $('#VisitasPersonasVisitas').val();

    // Variables para obtener la lista de las personas visitantes que fueron agregadas
    var listaPersonasVisitantesAgregado = [];

    // Variables para obtener la lista de las personas visitantes que fieron eliminadas
    var listaPersonasVisitantesEliminadas = [];

    if(personasParticipante != null){
        // Se pregunta si la lista inicial tiene algun registro
        if(listadoInicialPersonasVisitante.length > 0){
            // Se obtienen las personas que pertenecian a la visita
            for(var i = 0; i < listadoInicialPersonasVisitante.length; i++){
                var busquedaEnArregloLideresEliminados = jQuery.inArray(listadoInicialPersonasVisitante[i],personasParticipante);
                if(busquedaEnArregloLideresEliminados == -1){
                    listaPersonasVisitantesEliminadas.push(listadoInicialPersonasVisitante[i]);
                }
            }

            // Se obtienen las personas que ahora pertenecen a la visita
            for(var i = 0; i < personasParticipante.length; i++){
                var busquedaEnArregloLideresAgregados = jQuery.inArray(personasParticipante[i],listadoInicialPersonasVisitante);
                if(busquedaEnArregloLideresAgregados == -1){
                    listaPersonasVisitantesAgregado.push(personasParticipante[i]);
                }
            }
        }
        else
        {
            // Se obtienen las personas que ahora pertenecen a la visita
            for(var i = 0; i < personasParticipante.length; i++){
                listaPersonasVisitantesAgregado.push(personasParticipante[i]);
            }
        }
    }

    // Si la lista de los visitantes es nula y la lista inicial de los visitantes no esta vacia quiere decir que todos los que habian en la lista inicial, fueron eliminados
    if(personasParticipante == null
        && listadoInicialPersonasVisitante.length > 0){
        // Se obtienen las personas que pertenecian a la visita
        for(var i = 0; i < listadoInicialPersonasVisitante.length; i++){
            listaPersonasVisitantesEliminadas.push(listadoInicialPersonasVisitante[i]);
        }
    }

    // Se convierten a formato JSON las listas
    var listaPersonasVisitantesAgregadoJson = JSON.stringify(listaPersonasVisitantesAgregado);
    var listaPersonasVisitantesEliminadosJson = JSON.stringify(listaPersonasVisitantesEliminadas);

    if(idMinisterio == 0
        || descripcion == ""
        || fechaVisita == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar el ministerio, digitar la descripción, seleccionar la fecha de la visita y seleccionar el estado.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarVisita&idVisita=" + idVisita + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&fechaVisita=" + fechaVisita + "&estado=" + estado
            + "&listaPersonasVisitantesAgregado=" + listaPersonasVisitantesAgregadoJson + "&listaPersonasVisitantesEliminados=" + listaPersonasVisitantesEliminadosJson;

        // Enviar por Ajax a visitasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/visitasCAD.php"
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
                        , content: 'La visita se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('visitas.php');
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
                        , content: 'No se pudo modificar la visita, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}