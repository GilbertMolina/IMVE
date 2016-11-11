<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 31/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la clase de conexion
require("../conexionMySQL.php");
$db = new MySQL();

// Obtiene el listado de personas del sistema para mostrarlas en un ListView
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasPorOrdenamientoEstado') {
    try {
        $ordenamiento = $_POST['ordenamiento'];
        $estado       = $_POST['estado'];

        $sql               = "CALL TbPersonasListarPorOrdenamientoEstado('$ordenamiento', '$estado')";
        $consulta          = $db->consulta($sql);
        $consultaAcciones  = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<ul data-role="listview" id="listaPersonas" data-filter="true" data-input="#filtro" data-split-icon="gear" data-autodividers="true" data-inset="true">';

        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<li><a href="#" onclick="UtiProcesosPaginaProcesosPersonasDetalleModificar(' . $resultados['IdPersona'] . ')">' . utf8_encode($resultados['NombreCompleto']) . '</a><a href="#acciones_'. $resultados['IdPersona'] . '" data-rel="popup" data-position-to="window" data-transition="pop">Acciones</a></li>';
            }
            $cadena_datos .= '</ul>';

            if($db->num_rows($consultaAcciones) != 0)
            {
                while($resultadosAcciones = $db->fetch_array($consultaAcciones))
                {
                    $cadena_datos .= '<div data-role="popup" id="acciones_'. $resultadosAcciones['IdPersona'] . '" data-theme="a" data-overlay-theme="b" class="ui-content text-center" style="max-width:340px; padding-bottom:2em;">';
                    $cadena_datos .= '<h3>Contacto</h3>';

                    if($resultadosAcciones['Telefono'] == ""
                        && $resultadosAcciones['Celular'] == ""
                        && $resultadosAcciones['Correo'] == ""){
                        $cadena_datos .= '<p>' . $resultadosAcciones['NombreCompleto'] . ' no tiene asociado un número de teléfono, celular ni un correo electrónico, con el cual se pueda contactar.</p>';
                    }
                    else{
                        $cadena_datos .= '<p>Estas son las acciones disponibles para ' . $resultadosAcciones['NombreCompleto'] . ':</p>';
                    }

                    if($resultadosAcciones['Telefono'] != ""){
                        $cadena_datos .= '<a href="tel:' . $resultadosAcciones['Telefono'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Fijo</a>';
                    }
                    if($resultadosAcciones['Celular'] != ""){
                        $cadena_datos .= '<a href="tel:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-phone ui-btn-icon-left ui-btn-inline ui-mini">Móvil</a>';
                        $cadena_datos .= '<a href="sms:' . $resultadosAcciones['Celular'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-comment ui-btn-icon-left ui-btn-inline ui-mini">SMS</a>';
                    }
                    if($resultadosAcciones['Correo'] != ""){
                        $cadena_datos .= '<a href="mailto:' . $resultadosAcciones['Correo'] . '" class="ui-shadow ui-btn ui-corner-all ui-btn-b ui-icon-mail ui-btn-icon-left ui-btn-inline ui-mini">Correo</a>';
                    }
                    $cadena_datos .= '<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cancelar</a>';
                    $cadena_datos .= '</div>';
                }
            }
        }
        else
        {
            $cadena_datos .= '<li>No hay personas para mostrar en la agenda en este estado.</li>';
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de personas del sistema para mostrarlas en un campo de select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasCelularesCorreos') {
    try {
        $accion = $_POST['accion'];

        $sql               = "CALL TbPersonasListarCelularesCorreos('$accion')";
        $consulta          = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonas" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonas" id="accionesSeleccionPersonas" data-filter="true" data-input="#filtroSeleccion" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarPersonas()">';

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                if ($accion == 'S'){
                    $cadena_datos .= '<option value="' . $resultados['Celular'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
                }
                else{
                    $cadena_datos .= '<option value="' . $resultados['Correo'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
                }
            }
            $cadena_datos .= '</select>';
        }
        else
        {
            $cadena_datos .= '<option>No hay personas para mostrar</option>';
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Obtiene el listado de personas filtradas por estado para mostrarlas en un campo de select
if (isset($_POST['action']) && $_POST['action'] == 'obtenerListadoPersonasFiltradasPorEstado') {
    try {
        $estado = $_POST['estado'];

        $sql               = "CALL TbPersonasListarActivosInactivos('$estado')";
        $consulta          = $db->consulta($sql);
        $cadena_datos      = "";

        $cadena_datos .= '<label for="accionesSeleccionPersonasActivarDesactivar" style="margin-top: 30px">Lista de personas para seleccionar:</label>';
        $cadena_datos .= '<select name="accionesSeleccionPersonasActivarDesactivar" id="accionesSeleccionPersonasActivarDesactivar" data-filter="true" data-input="#filtroSeleccionActivasDesactivas" data-native-menu="false" multiple="multiple" data-iconpos="left" data-theme="a" onchange="PersonasAccionesSeleccionarActivarDesactivarPersonas()">';

        if($db->num_rows($consulta) != 0)
        {
            $cadena_datos .= '<option>Seleccione</option>';

            while($resultados = $db->fetch_array($consulta))
            {
                $cadena_datos .= '<option value="' . $resultados['IdPersona'] . '">' . utf8_encode($resultados['NombreCompleto']) . '</option>';
            }
            $cadena_datos .= '</select>';
        }
        else
        {
            $cadena_datos .= '<option>No hay personas para mostrar</option>';
        }
        echo $cadena_datos;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se actualiza el estado de personas
if (isset($_POST['action']) && $_POST['action'] == 'modificarEstadoPersonas') {
    try {
        $estado        = $_POST['estado'];
        $listaPersonas = json_decode(stripslashes($_POST['listaPersonas']));
        $usuarioActual = $_SESSION['idPersona'];

        foreach($listaPersonas as $persona){
            $sql      = "CALL TbPersonasActualizarEstado('$estado','$persona','$usuarioActual')";
            $consulta = $db->consulta(utf8_decode($sql));
        }
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se realiza el registro de una nueva persona en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'registrarPersona') {
    try {
        $identificacion       = $_POST['identificacion'];
        $nombre               = $_POST['nombre'];
        $apellido1            = $_POST['apellido1'];
        $apellido2            = $_POST['apellido2'];
        $fechaNacimiento      = $_POST['fechaNacimiento'];
        $distrito             = $_POST['distrito'];
        $direccionDomicilio   = $_POST['direccionDomicilio'];
        $telefono             = $_POST['telefono'];
        $celular              = $_POST['celular'];
        $correo               = $_POST['correo'];
        $sexo                 = $_POST['sexo'];
        $usuarioActual        = $_SESSION['idPersona'];

        $sql = "CALL TbPersonasAgregar('$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$correo','$sexo','$usuarioActual')";
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

// Se realiza la modificación de una persona existente
if (isset($_POST['action']) && $_POST['action'] == 'modificarPersona') {
    try {
        $idPersona            = $_POST['idPersona'];
        $identificacion       = $_POST['identificacion'];
        $nombre               = $_POST['nombre'];
        $apellido1            = $_POST['apellido1'];
        $apellido2            = $_POST['apellido2'];
        $fechaNacimiento      = $_POST['fechaNacimiento'];
        $distrito             = $_POST['distrito'];
        $direccionDomicilio   = $_POST['direccionDomicilio'];
        $telefono             = $_POST['telefono'];
        $celular              = $_POST['celular'];
        $correo               = $_POST['correo'];
        $sexo                 = $_POST['sexo'];
        $estado               = $_POST['estado'];
        $usuarioActual        = $_SESSION['idPersona'];

        $sql = "CALL TbPersonasModificar('$idPersona', '$identificacion','$nombre','$apellido1','$apellido2','$fechaNacimiento','$distrito','$direccionDomicilio','$telefono','$celular','$correo','$sexo','$estado','$usuarioActual')";
        $consulta = $db->consulta(utf8_decode($sql));
        echo 1;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Se carga una persona en especifíco en la pantalla de ver detalle
if (isset($_POST['action']) && $_POST['action'] == 'cargarPersona') {
    try {
        $idPersona = $_POST['IdPersona'];

        $sql          = "CALL TbPersonasListarPorIdPersona('$idPersona')";
        $consulta     = $db->consulta($sql);
        $cadena_datos = "";

        $sqlProvincias      = "CALL TbProvinciasListar()";
        $consultaProvincias = $db->consulta($sqlProvincias);
        $utilizarCantones = false;
        $utilizarDistritos = false;


        if($db->num_rows($consulta) != 0)
        {
            while($resultados = $db->fetch_array($consulta))
            {
                if($resultados['Provincia'] != null){
                    $sqlCantones      = "CALL TbCantonesListarFiltrado(". $resultados['Provincia'] . ")";
                    $consultaCantones = $db->consulta($sqlCantones);
                    $utilizarCantones = true;
                }

                if($resultados['Provincia'] != null
                    && $resultados['Canton'] != null){
                    $sqlDistritos      = "CALL TbDistritosListarFiltrado(" . $resultados['Provincia'] . "," . $resultados['Canton'] . ")";
                    $consultaDistritos = $db->consulta($sqlDistritos);
                    $utilizarDistritos = true;
                }

                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtIdentificacion">Identificación:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="102220333" maxlength="30" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultados['Identificacion'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtNombre">Nombre:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtNombre" id="txtNombre" maxlength="20" data-clear-btn="true" value="' . $resultados['Nombre'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtApellido1">Primer apellido:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<input type="text" name="txtApellido1" id="txtApellido1" maxlength="20" data-clear-btn="true" value="' . $resultados['Apellido1'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtApellido2">Segundo apellido:</label>';
                $cadena_datos .= '<input type="text" name="txtApellido2" id="txtApellido2" maxlength="20" data-clear-btn="true" value="' . $resultados['Apellido2'] . '"/>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtFechaNacimiento">Fecha de nacimiento:</label>';
                $cadena_datos .= '<input type="date" name="txtFechaNacimiento" id="txtFechaNacimiento" value="' . explode(" ", $resultados['FechaNacimiento'])[0] . '">';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdProvincia">Provincia:</label>';
                $cadena_datos .= '<select name="cboIdProvincia" id="cboIdProvincia" onchange="PersonasOnSelectedChangeProvincias()">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($db->num_rows($consultaProvincias) != 0)
                {
                    while($resultadosProvincias= $db->fetch_array($consultaProvincias))
                    {
                        if ($resultadosProvincias['IdProvincia'] == $resultados['Provincia']){
                            $cadena_datos .= '<option value="' . $resultadosProvincias['IdProvincia'] . '" selected>' . utf8_encode($resultadosProvincias['Descripcion']) . '</option>';
                        }
                        else
                        {
                            $cadena_datos .= '<option value="' . $resultadosProvincias['IdProvincia'] . '">' . utf8_encode($resultadosProvincias['Descripcion']) . '</option>';
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdCanton">Cantón:</label>';
                $cadena_datos .= '<select name="cboIdCanton" id="cboIdCanton" onchange="PersonasOnSelectedChangeCantones()">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($utilizarCantones){
                    if($db->num_rows($consultaCantones) != 0)
                    {
                        while($resultadosCantones= $db->fetch_array($consultaCantones))
                        {
                            if ($resultadosCantones['IdCanton'] == $resultados['Canton']){
                                $cadena_datos .= '<option value="' . $resultadosCantones['IdCanton'] . '" selected>' . utf8_encode($resultadosCantones['Descripcion']) . '</option>';
                            }
                            else
                            {
                                $cadena_datos .= '<option value="' . $resultadosCantones['IdCanton'] . '">' . utf8_encode($resultadosCantones['Descripcion']) . '</option>';
                            }
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboIdDistrito">Distrito:</label>';
                $cadena_datos .= '<select name="cboIdDistrito" id="cboIdDistrito">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if($utilizarDistritos){
                    if($db->num_rows($consultaDistritos) != 0)
                    {
                        while($resultadosDistritos= $db->fetch_array($consultaDistritos))
                        {
                            if ($resultadosDistritos['IdDistrito'] == $resultados['Distrito']){
                                $cadena_datos .= '<option value="' . $resultadosDistritos['IdDistrito'] . '" selected>' . utf8_encode($resultadosDistritos['Descripcion']) . '</option>';
                            }
                            else
                            {
                                $cadena_datos .= '<option value="' . $resultadosDistritos['IdDistrito'] . '">' . utf8_encode($resultadosDistritos['Descripcion']) . '</option>';
                            }
                        }
                    }
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtDireccionDomicilio">Dirección domicilio:</label>';
                $cadena_datos .= '<textarea name="txtDireccionDomicilio" id="txtDireccionDomicilio" maxlength="250" placeholder="Dirección exacta de su domicilio." data-clear-btn="true">' . utf8_encode($resultados['DireccionDomicilio']) . '</textarea>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtTelefono">Teléfono: </label>';
                $cadena_datos .= '<input type="tel" name="txtTelefono" id="txtTelefono" placeholder="88888888" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultados['Telefono'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el número de teléfono podrá ser contactado por medio de una llamada.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtCelular">Celular:</label>';
                $cadena_datos .= '<input type="tel" name="txtCelular" id="txtCelular" placeholder="88888888" maxlength="8" onKeyPress="return SoloNumeros(event)" data-clear-btn="true" value="' . $resultados['Celular'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el número de celular podrá ser contactado por medio de una llamada o un mensaje de texto.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="txtCorreo">Correo eléctronico:</label>';
                $cadena_datos .= '<input type="text" name="txtCorreo" id="txtCorreo" placeholder="correo@ejemplo.com" maxlength="50" onblur="PersonasValidarCorreo()" data-clear-btn="true" value="' . $resultados['Correo'] . '"/>';
                $cadena_datos .= '<p class="bg-danger text-justify">Nota: Si proporciona el correo electrónico podrá ser contactado por medio del mismo.</p>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboSexo">Género:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboSexo" id="cboSexo">';
                $cadena_datos .= '<option value="0">Seleccione</option>';
                if ($resultados['Sexo'] == 'F'){
                    $cadena_datos .= '<option value="F" selected>Femenino</option>';
                    $cadena_datos .= '<option value="M">Masculino</option>';
                }
                else
                {
                    $cadena_datos .= '<option value="F">Femenino</option>';
                    $cadena_datos .= '<option value="M" selected>Masculino</option>';
                }
                $cadena_datos .= '</select>';
                $cadena_datos .= '</div>';
                $cadena_datos .= '<br>';
                $cadena_datos .= '<div>';
                $cadena_datos .= '<label for="cboEstadoPersona">Estado:<img src="../Includes/images/warning.ico" alt="Necesario" height="24px" width="24px" align="right"></label>';
                $cadena_datos .= '<select name="cboEstadoPersona" id="cboEstadoPersona">';
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
                $cadena_datos .= '<div class="row">';
                $cadena_datos .= '<div class="col-xs-1"></div>';
                $cadena_datos .= '<div class="col-xs-10">';
                $cadena_datos .= '<button type="button" id="btnAceptar" data-theme="b" onclick="PersonasModificarPersona(' . $resultados['IdPersona'] . ')" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-btn-icon-left ui-icon-plus">Modificar</button>';
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
