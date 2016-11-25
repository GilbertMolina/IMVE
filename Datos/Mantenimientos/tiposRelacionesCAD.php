<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de los tipos de relacion
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoRelacionesPorTipoRelacion') {
    try {
        $tipoRelacion = $_POST['tipoRelacion'];

        $sql          = "CALL TbTiposRelacionesListarTipoRelacion('$tipoRelacion')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                if ($resultados['NombreInversoMasculino'] != ''
                    && $resultados['NombreInversoFemenino'] != '')
                {
                    $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosTiposRelacionesDetalleModificar(' . $resultados['IdTipoRelacion'] . ')">' . utf8_encode($resultados['NombreMasculino']) . '/' . utf8_encode($resultados['NombreFemenino']) . ' - ' . utf8_encode($resultados['NombreInversoMasculino']) . '/' . utf8_encode($resultados['NombreInversoFemenino']) . '</a><a href="#" class="delete ui-btn ui-btn-icon-notext ui-icon-delete" onclick="TiposRelacionesEliminar('. $resultados['IdTipoRelacion'] . ')"></a></li>';
                }
                else
                {
                    $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosTiposRelacionesDetalleModificar(' . $resultados['IdTipoRelacion'] . ')">' . utf8_encode($resultados['NombreMasculino']) . '/' . utf8_encode($resultados['NombreFemenino']) . '</a><a href="#" class="delete ui-btn ui-btn-icon-notext ui-icon-delete" title="Delete" onclick="TiposRelacionesEliminar('. $resultados['IdTipoRelacion'] . ')">Eliminar</a></li>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay tipos de relaciones.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un tipo de relacion
if (isset($_POST['action']) && $_POST['action'] == 'registrarTipoRelacion') {
    try {
        $nombreMasculino        = $_POST['nombreMasculino'];
        $nombreFemenino         = $_POST['nombreFemenino'];
        $nombreInversoMasculino = $_POST['nombreInversoMasculino'];
        $nombreInversoFemenino  = $_POST['nombreInversoFemenino'];
        $usuarioActual          = $_SESSION['idPersona'];

        $sql = "CALL TbTiposRelacionesAgregar('$nombreMasculino','$nombreFemenino','$nombreInversoMasculino','$nombreInversoFemenino','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idTipoRelacion = $resultados['Id'];
                $exito          = "1";
            }

        } else {
            $exito = "-1";
        }
        echo $exito;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza la modificación de un tipo de relacion existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarTipoRelacion') {
    try {
        $idTipoRelacion         = $_POST['idTipoRelacion'];
        $nombreMasculino        = $_POST['nombreMasculino'];
        $nombreFemenino         = $_POST['nombreFemenino'];
        $nombreInversoMasculino = $_POST['nombreInversoMasculino'];
        $nombreInversoFemenino  = $_POST['nombreInversoFemenino'];
        $usuarioActual          = $_SESSION['idPersona'];

        $sql = "CALL TbTiposRelacionesModificar('$idTipoRelacion', '$nombreMasculino','$nombreFemenino','$nombreInversoMasculino','$nombreInversoFemenino','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un tipo de relacion en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarTipoRelacion') {
    try {
        $idTipoRelacion = $_POST['idTipoRelacion'];

        $sql          = "CALL TbTiposRelacionesListarPorIdTipoRelacion('$idTipoRelacion')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<form method="post" action="#">';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtNombreMasculino">Nombre masculino:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtNombreMasculino" id="txtNombreMasculino" maxlength="20" data-clear-btn="true" value="' . utf8_encode($resultados['NombreMasculino']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtNombreFemenino">Nombre femenino:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtNombreFemenino" id="txtNombreFemenino" maxlength="20" data-clear-btn="true" value="' . utf8_encode($resultados['NombreFemenino']) . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                if($resultados['NombreInversoMasculino'] != ''
                    && $resultados['NombreInversoFemenino'] != '')
                {
                    $cadena_datos .= '<div>';
                    $cadena_datos .= '<label for="txtNombreInversoMasculino">Nombre relación inversa masculino:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                    $cadena_datos .= '<input type="text" name="txtNombreInversoMasculino" id="txtNombreInversoMasculino" maxlength="20" data-clear-btn="true" value="' . utf8_encode($resultados['NombreInversoMasculino']) . '"/>';
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '<br>';
                    $cadena_datos .= '<div>';
                    $cadena_datos .= '<label for="txtNombreInversoFemenino">Nombre relación inversa femenino:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                    $cadena_datos .= '<input type="text" name="txtNombreInversoFemenino" id="txtNombreInversoFemenino" maxlength="20" data-clear-btn="true" value="' . utf8_encode($resultados['NombreInversoFemenino']) . '"/>';
                    $cadena_datos .= '</div>';
                    $cadena_datos .= '<br>';
                }
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="TiposRelacionesModificarTipoRelacion(' . $resultados['IdTipoRelacion'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-edit">Modificar</button>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '</form>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza la eliminación de un tipo de relacion existente
if (isset($_POST['action']) && $_POST['action'] == 'eliminarTipoRelacion') {
    try {
        $idTipoRelacion = $_POST['idTipoRelacion'];

        $sql = "CALL TbTiposRelacionesEliminar('$idTipoRelacion')";
        $consulta = $db->consulta(utf8_decode($sql));

        $resultado = '';

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $resultado = $resultados['Resultado'];
            }
        } else {
            $resultado = "-1";
        }
        echo $resultado;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de los tipos de relacion para mostrarlos en un select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoTiposRelaciones') {
    try {
        $sql          = "CALL TbTiposRelacionesListar()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdTipoRelacion'] . '-' . $resultados['TipoRelacion'] . '">' . utf8_encode($resultados['NombreMasculino']) . ' / ' . utf8_encode($resultados['NombreFemenino']) . '</option>';


//                if ($resultados['NombreInversoMasculino'] != ''
//                    && $resultados['NombreInversoFemenino'] != '')
//                {
//                    $cadena_datos .= '<option value="' . $resultados['IdTipoRelacion'] . '">' . utf8_encode($resultados['NombreMasculino']) . '/' . utf8_encode($resultados['NombreFemenino']) . ' - ' . utf8_encode($resultados['NombreInversoMasculino']) . '/' . utf8_encode($resultados['NombreInversoFemenino']) . '</option>';
//                }
//                else
//                {
//                    $cadena_datos .= '<option value="' . $resultados['IdTipoRelacion'] . '">' . utf8_encode($resultados['NombreMasculino']) . '/' . utf8_encode($resultados['NombreFemenino']) . '</option>';
//                }
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}