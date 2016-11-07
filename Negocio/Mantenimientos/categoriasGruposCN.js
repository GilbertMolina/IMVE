/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias de grupos
function CategoriasGruposOnLoad(){
    CategoriasGruposCargarCategoriasGruposListado();
}

// Función que se ejecuta al cargar la pagina de categorias grupos detalle
function CategoriasGruposDetalleOnLoad() {
    CategoriasGruposCargarCategoriaPorId();
}

// Función para obtener todas las categorias grupos activas o inactivas
function CategoriasGruposCargarCategoriasGruposListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoCategoriaGrupo');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasGruposPorEstado&estado=" + estado;

    // Enviar por Ajax a categoriasGruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
        , success: function(a) {
            $("#listaCategoriasGrupos").html(a).listview("refresh");
        }
    })
}

// Función para registrar una categoria grupo
function CategoriasGruposRegistrarCategoriaGrupo() {
    var descripcion = $('#txtDescripcionCategoriaGrupo').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción de la categoría de grupo.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarCategoriaGrupo&descripcion=" + descripcion;

        // Enviar por Ajax a categoriasGruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
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
                        , title: 'Nueva categoría de persona'
                        , content: 'La categoría de grupo se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categoriasGrupos.php');
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
                        , title: 'Nueva categoría de persona'
                        , content: 'No se pudo agregar la categoría, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para cargar una categoria persona por su id
function CategoriasGruposCargarCategoriaPorId() {
    var idCategoriaGrupo = ObtenerParametroPorNombre('IdCategoriaGrupo');

    if(idCategoriaGrupo != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarCategoriaGrupo&idCategoriaGrupo=" + idCategoriaGrupo;

        // Enviar por Ajax a categoriasGruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
            , success: function(a) {
                $("#categoriasGruposDetalle").html(a).trigger( "create" );
            }
        });
    }
}

// Función para modificar una categoria persona
function CategoriasGruposModificarCategoria(p_idCategoriaGrupo) {
    var idCategoriaGrupo = p_idCategoriaGrupo;
    var descripcion = $('#txtDescripcionCategoriaGrupo').val();
    var estado = $('#cboEstadoCategoriaGrupo').val();

    if(descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción y el estado de la categoría de grupo.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarCategoriaGrupo&idCategoriaGrupo=" + idCategoriaGrupo + "&descripcion=" + descripcion + "&estado=" + estado;

        // Enviar por Ajax a categoriasGruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
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
                        , title: 'Modificar categoría de grupo'
                        , content: 'La categoría de grupo se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categoriasGrupos.php');
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
                        , title: 'Modificar categoría de grupo'
                        , content: 'No se pudo modificar la categoría de grupo, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}