/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de visitas
function VisitasOnLoad() {

}

// Función que se ejecuta al cargar la pagina de visitas detalle
function VisitasDetalleOnLoad() {
    GruposCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function GruposCambiarBarraNavegacionFooter() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){
        $('#NuevaVisita').hide();
    }
    else{
        $('#DetalleVisita').hide();
    }
}
