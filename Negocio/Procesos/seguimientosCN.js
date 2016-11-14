/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de grupos
function SeguimientosOnLoad() {
    GruposCargarGruposListado();
    GruposCargarPersonasGrupoAccionesSeleccion();

    $('#menuAccionesGrupos').hide();

    $('#btnGruposEnviarSMS').hide();
    $('#btnGruposEnviarCorreo').hide();
}

// Función que se ejecuta al cargar la pagina de grupos detalle
function SeguimientosDetalleOnLoad() {
    GruposCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function GruposCambiarBarraNavegacionFooter() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){
        $('#NuevoSeguimiento').hide();
    }
    else{
        $('#DetalleSeguimiento').hide();
    }
}