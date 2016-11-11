/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 11/11/16
 */

// Función que se ejecuta al cargar la pagina de grupos
function GruposOnLoad() {
    GruposCargarGruposListado();
}

// Función que se ejecuta al cargar la pagina de grupos detalle
function GruposDetalleOnLoad() {
    GruposCargarGrupoPorId();
}

// Función para obtener todos los grupos registradas
function GruposCargarGruposListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoGrupo');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoGruposPorEstado&estado=" + estado;

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        , success: function(a) {
            $("#listaGrupos").html(a).listview("refresh");
        }
    })
}

// Función para obtener todas las categorías de grupos activas
function GruposCargarCategoriasGruposComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasGruposActivasCombobox";

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
        , success: function(a) {
            $("#cboIdCategoriasGrupos").html(a).html(a).trigger("create");
        }
    })
}

// Función para obtener todos los ministerios activos
function GruposCargarMinisteriosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoMinisteriosActivosCombobox";

    // Enviar por Ajax a ministeriosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
        , success: function(a) {
            $("#cboIdMinisterios").html(a).html(a).trigger("create");
        }
    })
}

// Función para cargar un grupo por su id
function GruposCargarGrupoPorId() {
    var IdGrupo = ObtenerParametroPorNombre('IdGrupo');

    if(IdGrupo != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarGrupo&IdGrupo=" + IdGrupo;

        // Enviar por Ajax a usuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
            , success: function(a) {
                $("#gruposDetalle").html(a).trigger("create");
            }
        });
    }
    else
    {
        GruposCargarCategoriasGruposComboBox();
        GruposCargarMinisteriosComboBox();
    }
}

// Función para registrar un grupo
function GruposRegistrarGrupo() {
    var idCategoriaGrupo = $('#cboIdCategoriasGrupos').val();
    var idMinisterio     = $('#cboIdMinisterios').val();
    var descripcion      = $('#txtDescripcionGrupo').val();

    if(idCategoriaGrupo == 0
        && descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar la categoría grupo y digitar la descripción.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarGrupo&idCategoriaGrupo=" + idCategoriaGrupo + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion;

        // Enviar por Ajax a gruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
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
                        , content: 'El grupo se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('grupos.php');
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
                        , content: 'El grupo ya se encuentra registrado.'
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
                        , content: 'No se pudo agregar el grupo, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para modificar un grupo
function GruposModificarGrupo(p_IdGrupo) {
    var idGrupo             = p_IdGrupo;
    var idCategoriaGrupo    = $('#cboIdCategoriasGrupos').val();
    var idMinisterio        = $('#cboIdMinisterios').val();
    var descripcion         = $('#txtDescripcionGrupo').val();
    var estado              = $('#cboEstadoGrupo').val();

    if(idCategoriaGrupo == 0
        || descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar la categoría de grupo, digitar la descripción, y seleccionar el estado.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarGrupo&idGrupo=" + idGrupo + "&idCategoriaGrupo=" + idCategoriaGrupo + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&estado=" + estado;

        // Enviar por Ajax a gruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
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
                        , content: 'El grupo se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('grupos.php');
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
                        , content: 'No se pudo modificar el grupo, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}