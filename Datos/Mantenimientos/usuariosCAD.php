<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

session_start();

error_reporting(1);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de personas para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoUsuariosPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql          = "CALL TbUsuariosListarEstado('$estado')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";
        
        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiMantenimientosPaginaMantenimientosUsuariosDetalleModificar(' . $resultados['IdPersona'] . ')">' . utf8_encode($resultados['NombreCompleto']) . '</a></li>';
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay usuarios en este estado.</li>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de personas que no tienen usuario, para insertarlos en un ComboBox
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasCombobox') {
    try {
        $sql          = "CALL TbPersonasListarSinUsuario()";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos = '<option value="0">Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
        }
        else
        {
            $cadena_datos .= '<option value="0">Todas las personas tienen usuario</option>';
        }

        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de un nuevo usuario
if (isset($_POST['action']) && $_POST['action'] == 'registrarUsuario') {
    try {
        $idPersona     = $_POST['idPersona'];
        $idRolUsuario  = $_POST['idRolUsuario'];
        $contrasena    = $_POST['contrasenaEncriptada'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbUsuariosAgregar('$idPersona','$idRolUsuario','$contrasena','$usuarioActual')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona = $resultados['Id'];
                $exito     = "1";
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

// Se realiza la modificación de un usuario existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarUsuario') {
    try {
        $idPersona     = $_POST['idPersona'];
        $idRolUsuario  = $_POST['idRolUsuario'];
        $contrasena    = $_POST['contrasenaEncriptada'];
        $estado        = $_POST['estado'];
        $usuarioActual = $_SESSION['idPersona'];

        $sql = "CALL TbUsuariosModificar('$idPersona', '$idRolUsuario','$contrasena','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga un ministerio en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarUsuario') {
    try {
        $IdPersona = $_POST['idPersona'];

        $sql          = "CALL TbUsuariosListarPorIdPersona('$IdPersona')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        $sqlRolesUsuario      = "CALL TbRolesUsuariosListar()";
        $consultaRolesUsuario = $db->consulta($sqlRolesUsuario);
        $cadena_datos = "";

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtNombreUsuario">Persona:</label>';
                $cadena_datos .= '<input type="text" name="txtNombreUsuario" id="txtNombreUsuario" maxlength="50" data-clear-btn="true" value="' . utf8_encode($resultados['NombreCompleto']) . '" disabled>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdRol">Roles disponibles:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboIdRol" id="cboIdRol">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaRolesUsuario) != 0)
                {
                    while($resultadosRolesUsuario = $db->fetch_array($consultaRolesUsuario))
                    {
                        if ($resultadosRolesUsuario['Descripcion'] == $resultados['Rol']){
                            $cadena_datos .= '<option value="' . $resultadosRolesUsuario['IdRolUsuario'] . '" selected>' . utf8_encode($resultadosRolesUsuario['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosRolesUsuario['IdRolUsuario'] . '">' . utf8_encode($resultadosRolesUsuario['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtContrasena">Contraseña:</label>';
                $cadena_datos .= '<input type="password" name="txtContrasena" id="txtContrasena" maxlength="50" data-clear-btn="true">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtConfirmarContrasena">Confirmar contraseña:</label>';
                $cadena_datos .= '<input type="password" name="txtConfirmarContrasena" id="txtConfirmarContrasena" maxlength="50" data-clear-btn="true">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoUsuario">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoUsuario" id="cboEstadoUsuario">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultados['Estado'] == 'A'){
                    $cadena_datos .= '<option value="A" selected>Activo</option>';
                    $cadena_datos .= '<option value="I">Inactivo</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="A">Activo</option>';
                    $cadena_datos .= '<option value="I" selected>Inactivo</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= ' <br>';
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnModificar" data-theme="b" onclick="UsuariosModificarUsuario(' . $resultados['IdPersona'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-edit">Modificar</button>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '</div>';
            }
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}
