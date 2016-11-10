/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function CategoriasOnLoad() {
    CategoriasCargarCategoriasListado();
}

// Función que se ejecuta al cargar la pagina de categorias detalle
function CategoriasDetalleOnLoad() {
    CategoriasCargarCategoriaPorId();
}

// Función para obtener todas las categorias activas
function CategoriasCargarCategoriasListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoCategoria');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasPorEstado&estado=" + estado;

    // Enviar por Ajax a categoriasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
        , success: function(a) {
            $("#listaCategorias").html(a).listview("refresh");
        }
    })
}

// Función para registrar una categoria persona
function CategoriasRegistrarCategoria() {
    var descripcion = $('#txtDescripcionCategoria').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción de la categoría de persona.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarCategoria&descripcion=" + descripcion;

        // Enviar por Ajax a categoriasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
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
                        , content: 'La categoría de persona se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categorias.php');
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
                        , title: 'Nueva categoría de persona'
                        , content: 'La categoría de persona ya se encuentra registrada.'
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
function CategoriasCargarCategoriaPorId() {
    var idCategoria = ObtenerParametroPorNombre('idCategoria');

    if(idCategoria != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarCategoria&idCategoria=" + idCategoria;

        // Enviar por Ajax a categoriasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
            , success: function(a) {
                $("#categoriasDetalle").html(a).trigger( "create" );
            }
        });
    }
}

// Función para modificar una categoria persona
function CategoriasModificarCategoria(p_idCategoria) {
    var idCategoria = p_idCategoria;
    var descripcion = $('#txtDescripcionCategoria').val();
    var estado = $('#cboEstadoCategoria').val();

    if(descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción y el estado de la categoría de persona.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarCategoria&idCategoria=" + idCategoria + "&descripcion=" + descripcion + "&estado=" + estado;

        // Enviar por Ajax a categoriasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
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
                        , title: 'Modificar categoría de persona'
                        , content: 'La categoría de persona se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categorias.php');
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
                        , title: 'Modificar categoría de persona'
                        , content: 'No se pudo modificar la categoría de persona, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}