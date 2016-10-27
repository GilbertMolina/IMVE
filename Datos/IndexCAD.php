<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollador por: Gilberth Molina
 * Date: 26/10/16
 */

session_start();

error_reporting(-1);
ini_set('display_errors', 1);

require("ConexionMySQL.php");
$db = new MySQL(); //llamado a la clase de conexion

// Inicio de sesión en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'iniciarSesion') {
    try {
        $identificacion = $_POST['identificacion'];
        $contrasena     = $_POST['contrasena']; //encriptarla
        $sql            = "CALL TbUsuariosIniciarSesion('$identificacion','$contrasena')";
        $consulta       = $db->consulta($sql);
        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona      = $resultados['IdPersona'];
                $identificacion = $resultados['Identificacion'];
                $nombreCompleto = $resultados['NombreCompleto'];
                $idRol          = $resultados['IdRolUsuario'];
                $rol            = $resultados['Rol'];
                $token          = uniqid(); //Token para login
                $paso           = "1,".$nombreCompleto;
            }
            //variables de sesion
            $_SESSION['idPersona']      = $idPersona;
            $_SESSION['nombreCompleto'] = $nombreCompleto;
            $_SESSION['rol']            = $rol;
            $_SESSION['token']          = $token;
        } else {
            $paso = "2,no";
        }
        echo $paso;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Cierre de sesión en el sistema
if (isset($_POST['action']) && $_POST['action'] == 'cerrarSesion') {
    try {
        session_destroy();
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

//if (isset($_POST['action']) && $_POST['action'] == 'obtenerRol') {
//    $sql      = "CALL EME_RolListar()";
//    $consulta = $db->consulta($sql);
//    $result   = array();
//    if ($db->num_rows($consulta) != 0) {
//        while ($resultados = $db->fetch_array($consulta)) {
//            array_push($result, $resultados);
//        }
//    }
//    echo json_encode($result);
//}
//
////Obtener tipo de Vacuna
//if (isset($_POST['action']) && $_POST['action'] == 'vacunaObtener') {
//    $sql      = "CALL EME_VacunaListar()";
//    $consulta = $db->consulta($sql);
//    $result   = array();
//    $data     = array();
//    $res      = array();
//    if ($db->num_rows($consulta) != 0) {
//        while ($fila = $db->fetch_array($consulta)) {
//            $html .= '<option value="' . $fila['IDVACUNAS'] . '">' . $fila['TIPO'] . '</option>';
//        }
//        echo $html;
//    }
//}
////Funcion para agregar vacuna a persona.
//if (isset($_POST['action']) && $_POST['action'] == 'addvacuna') {
//
//    try {
//        $db            = new MySQL(); //llamado a la clase de conexion
//        $nombreRol     = $_REQUEST['NOMBREROL'];
//        $persona       = $_POST['persona'];
//        $tipoDosis     = $_POST['tipoDosis'];
//        $tipoVacuna    = $_POST['tipoVacuna'];
//        $cantidadDosis = $_POST['cantidadDosis'];
//
//        $idPersona = $_SESSION['id'];
//        $dosis     = false;
//
//        if ($tipoDosis == "DB1") {
//            $dosis = 1;
//        }
//        $sql = "CALL EME_VacunaHistorialAgregar($tipoVacuna,$persona , '$cantidadDosis' ,$dosis )";
//
//        $consulta = $db->consulta($sql);
//        while ($resultados = $db->fetch_array($consulta)) {
//            $respuesta = $resultados['RESPUESTA'];
//        }
//
//        if ($respuesta == 'SI') {
//            $operacion  = "Insertar";
//            $movimiento = "El usuario: " . $idPersona . " Ingreso una vacuna " . $tipoVacuna . "Para la persona: " . $persona;
//            $consulta   = $db->bitacoraAgregar($idPersona, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        } else {
//            $paso = 3;
//        }
//    }
//    catch (Exception $e) {
//        $paso = 0;
//    }
//    echo $paso;
//}
////Función para cargar informacion de vacunas para persona*/
//if (isset($_POST['action']) && $_POST['action'] == 'cargarInformacionVacuna') {
//    try {
//        $identificacion = $_POST["persona"];
//        $sql            = "CALL EME_vacunaxpersonaBuscar($identificacion)";
//        //echo $sql;
//        $consulta       = $db->consulta($sql);
//        $result         = array();
//        if ($db->num_rows($consulta) != 0) {
//            $cadena_datos = "";
//            while ($resultados = $db->fetch_array($consulta)) {
//                $cadena_datos .= "<tr>
//				  <td>" . $resultados["TIPOVACUNA"] . "</td>
//				   <td>" . $resultados["ULTIMADOSIS"] . "</td>
//					<td>" . $resultados["CANTIDAD"] . "</td>
//					 <td>" . $resultados["FECHA"] . "</td>
//				  <td><a href='' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delete_record_modal' onclick='asignarTupla(" . $resultados["IDHISTORIAL"] . ")'>Eliminar</a> <a href='' id='btnActualizar' class='btn btn-warning btn-xs' data-toggle='modal'  data-target='#upd_record_modal' onclick='obtenerVacuna(" . $resultados["IDHISTORIAL"] . ")'>Agregar Dosis</a></td></tr>";
//            }
//        }
//        echo $cadena_datos;
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//}
////Función para busqueda de registros
//if (isset($_POST['action']) && $_POST['action'] == 'BuscarInformacionVacuna') {
//    try {
//        $term     = $_POST["term"];
//        $sql      = "CALL EME_vacunaxpersonaFiltrar('$term')";
//        $consulta = $db->consulta($sql);
//        $result   = array();
//        if ($db->num_rows($consulta) != 0) {
//            $cadena_datos = "";
//            while ($resultados = $db->fetch_array($consulta)) {
//                $cadena_datos .= "<tr>
//			  <td>" . $resultados["TIPOVACUNA"] . "</td>
//			   <td>" . $resultados["ULTIMADOSIS"] . "</td>
//			    <td>" . $resultados["CANTIDAD"] . "</td>
//				 <td>" . $resultados["FECHA"] . "</td>
//			  <td><a href='' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delete_record_modal' onclick='asignarTupla(" . $resultados["IDHISTORIAL"] . ")'>Eliminar</a> <a href='' class='btn btn-warning btn-xs' data-toggle='modal'  data-target='#upd_record_modal' onclick='obtenerAlergia(" . $resultados["IDHISTORIAL"] . ")'>Agregar Dosis</a></td></tr>";
//            }
//        }
//        echo $cadena_datos;
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//}
////Función para eliminar vacunaa
//if (isset($_POST['action']) && $_POST['action'] == 'EliminarVacuna') {
//    try {
//        $historial = $_POST['historial'];
//        $idPersona = $_SESSION['id'];
//        $sql       = "CALL EME_vacunaxpersonaEliminar('$historial')";
//        $consulta  = $db->consulta($sql);
//        if ($consulta) {
//            $operacion  = "Eliminar";
//            $movimiento = "El usuario: " . $idPersona . " elimino el registro de vacuna " . $historial . ".";
//            $consulta   = $db->bitacoraAgregar($idPersona, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
//
//if (isset($_POST['action']) && $_POST['action'] == 'ObtenerVacuna') {
//    try {
//        $historial = $_POST["historial"];
//        $sql       = "CALL EME_vacunaxpersonaConsultar($historial)";
//        $consulta  = $db->consulta($sql);
//        $result    = array();
//        if ($db->num_rows($consulta) != 0) {
//            $cadena_datos = "";
//            while ($resultados = $db->fetch_array($consulta)) {
//                $id          = $resultados['ID'];
//                $tipo        = $resultados['TIPOVACUNA'];
//                $idHistorial = $resultados['IDHISTORIAL'];
//                $dosis       = $resultados['ULTIMADOSIS'];
//                if ($dosis == "Segunda Dosis") {
//                    //toca un refuerzo
//                    $re = "2";
//                } else if ($dosis == "Vacuna completa") {
//                    $re = "3";
//                } else {
//                    $re = "1"; //solo tiene una dosis.
//                }
//                $paso = $id . "," . $tipo . "," . $re;
//            }
//        } else {
//            $paso = "0,0"; //el refuerzo ya se ingresó.
//        }
//        echo $paso;
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//}
////Función para editar vacuna /Agregar dossis
//if (isset($_POST['action']) && $_POST['action'] == 'editvacuna') {
//    $persona    = $_POST['persona'];
//    $tipoDosis  = $_POST['tipoDosis'];
//    $dosis      = $_POST['dosis'];
//    $tipoVacuna = $_POST['tipoVacuna'];
//    $idPersona  = $_SESSION['id'];
//    $historial  = $_POST['historial'];
//
//    try {
//        $sql = "CALL EME_vacunaxpersonaEditar($historial, '$dosis','$tipoDosis')";
//
//        $consulta = $db->consulta($sql);
//        if ($consulta) {
//            $operacion = "Editar";
//            if ($tipoDosis == "DB2") {
//                $ti = "Segunda Dosis";
//            } else if ($tipoDosis == "DF1") {
//                $ti = "Dosis Refuerzo";
//            }
//            $movimiento = "El usuario: " . $idPersona . " actualizo a " . $ti . " el registro: " . $historial;
//            $consulta   = $db->bitacoraAgregar($idPersona, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        } else {
//            $paso = 0; //Error.
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
//
///*Funcion para obtener sesion*/
//if (isset($_POST['action']) && $_POST['action'] == 'obtenerSesion') {
//    $rol =  $_SESSION['rol'];
//    $nombre =   $_SESSION['nombre'];
//    $token =   $_SESSION['token'];
//    $id=  $_SESSION['id'];
//    $paso   =   $nombre . ',' . $rol . ',' . $token . ',' . $id;
//    echo $paso;
//}
//
///*Funcion para agregar una preconsulta*/
//if(isset($_POST['action']) && $_POST['action'] == 'addpreconsulta')
//{
//    $id=  $_SESSION['id'];
//    $problema=$_POST['problema'];
//    $educacion=$_POST['educacion'];
//    $cuidado = $_POST['cuidado'];
//    $persona = $_POST['persona'];
//    try {
//        $sql = "CALL EME_preconsultaAgregar($persona, $id , '$problema','$educacion' , '$cuidado')";
//
//        $consulta = $db->consulta($sql);
//        if ($consulta) {
//            $operacion = "Insertar";
//
//            $movimiento = "El usuario: " . $id . " agrego una preconsulta para el paciente " . $persona ;
//            $consulta   = $db->bitacoraAgregar($id, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        } else {
//            $paso = 0; //Error.
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
///*Funcion para agregar posconsulta*/
//if(isset($_POST['action']) && $_POST['action'] == 'addposconsulta')
//{
//    $id=  $_SESSION['id'];
//    $causa = $_POST['causa'];
//    $preconsulta = $_POST['preconsulta'];
//    $persona = $_POST['persona'];
//
//    try {
//        $sql = "CALL EME_consultaAgregar($preconsulta, $persona , '$causa',$id)";
//
//        $consulta = $db->consulta($sql);
//        while ($resultados = $db->fetch_array($consulta)) {
//            $respuesta = $resultados['RESPUESTA'];
//        }
//        if ($consulta) {
//            $operacion = "Insertar";
//
//            $movimiento = "El usuario: " . $id . " agrego una posconsulta para el paciente " . $persona ;
//            $consulta   = $db->bitacoraAgregar($id, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = "1,".$respuesta;
//            }
//        } else {
//            $paso = "0,0"; //Error.
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
///*Funcion para cargar tabla de medicamento*/
//
//if (isset($_POST['action']) && $_POST['action'] == 'cargarInformacionMedicamento') {
//    try {
//        $consultaID = $_POST["consulta"];
//        $sql            = "CALL EME_medicamentoBuscar($consultaID)";
//        //echo $sql;
//        $consulta       = $db->consulta($sql);
//        $result         = array();
//        if ($db->num_rows($consulta) != 0) {
//            $cadena_datos = "";
//            while ($resultados = $db->fetch_array($consulta)) {
//                $cadena_datos .= "<tr>
//				  <td>" . $resultados["FECHA"] . "</td>
//				   <td>" . $resultados["MEDICAMENTO"] . "</td>
//					<td>" . $resultados["DOSIS"] . "</td>
//					 <td>" . $resultados["PRESENTACION"] . "</td>
//					  <td>" . $resultados["DOCTOR"] . "</td>
//					   <td>" . $resultados["INTERVALO"] . "</td>
//					    <td>" . $resultados["VIA"] . "</td>
//						 <td>" . $resultados["DURACION"] . "</td>
//						  <td><a href='' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delete_record_modal' onclick='asignarTupla(" . $resultados["ID_RECETA"] . ")'>Eliminar</a> <a href='' id='btnActualizar' class='btn btn-warning btn-xs' data-toggle='modal'  data-target='#upd_record_modal' onclick='obtenerMedicamento(" . $resultados["ID_RECETA"] . ")'>Actualizar</a></td></tr>";
//            }
//        }
//        echo $cadena_datos;
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//}
//
///*Funcion para agregar medicamento*/
//
//if(isset($_POST['action']) && $_POST['action'] == 'addmedicamento')
//{
//    $id=  $_SESSION['id'];
//    $consultaID=$_POST['consulta'];
//    $medicamento=$_POST['medicamento'];
//    $dosis = $_POST['dosis'];
//    $presentacion = $_POST['presentacion'];
//    $intervalo=$_POST['intervalo'];
//    $via=$_POST['via'];
//    $duracion = $_POST['duracion'];
//    try {
//        $sql = "CALL EME_medicamentoAgregar($consultaID, $id, '$medicamento','$dosis','$presentacion','$intervalo','$via' ,'$duracion')";
//
//        $consulta = $db->consulta($sql);
//        if ($consulta) {
//            $operacion = "Insertar";
//
//            $movimiento = "El usuario: " . $id . " agrego un medicamento para la consulta " . $consultaID ;
//            $consulta   = $db->bitacoraAgregar($id, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        } else {
//            $paso = 0; //Error.
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
///*funcion para eliminar medicamento*/
//
//if (isset($_POST['action']) && $_POST['action'] == 'EliminarMedicamento') {
//    try {
//        $codigo = $_POST['codigo'];
//        $sql       = "CALL EME_medicamentoEliminar('$codigo')";
//        $idPersona = $_SESSION['id'];
//        $consulta  = $db->consulta($sql);
//        if ($consulta) {
//            $operacion  = "Eliminar";
//            $movimiento = "El usuario: " . $idPersona . " elimino el registro de medicamento " . $codigo . ".";
//            $consulta   = $db->bitacoraAgregar($idPersona, $operacion, $movimiento);
//            if ($operacion)
//            {
//                $paso = 1;
//            }
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
///*Funcion para editar medicamento*/
//if(isset($_POST['action']) && $_POST['action'] == 'editmedicamento')
//{
//    $receta = $_POST['receta'];
//    $id=   $_SESSION['id'];
//    $consultaID=$_POST['consulta'];
//    $medicamento=$_POST['medicamento'];
//    $dosis = $_POST['dosis'];
//    $presentacion = $_POST['presentacion'];
//    $intervalo=$_POST['intervalo'];
//    $via=$_POST['via'];
//    $duracion = $_POST['duracion'];
//    try {
//        $sql = "CALL EME_medicamentoEditar($receta,$consultaID, '$medicamento','$dosis','$presentacion','$intervalo','$via' ,'$duracion')";
//        $consulta = $db->consulta($sql);
//        if ($consulta) {
//            $operacion = "Editar";
//
//            $movimiento = "El usuario: " . $id . " edito un medicamento para la consulta " . $consultaID ;
//            $consulta   = $db->bitacoraAgregar($id, $operacion, $movimiento);
//            if ($operacion) {
//                $paso = 1;
//            }
//        } else {
//            $paso = 0; //Error.
//        }
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//    echo $paso;
//}
///*obtener registro de una receta*/
//
//if (isset($_POST['action']) && $_POST['action'] == 'buscarInformacionMedicamento') {
//    try {
//        $consultaID = $_POST["consulta"];
//        $sql            = "CALL EME_medicamentoFiltrar($consultaID)";
//        //echo $sql;
//        $consulta       = $db->consulta($sql);
//        $result         = array();
//        if ($db->num_rows($consulta) != 0) {
//            $cadena_datos = "";
//            while ($resultados = $db->fetch_array($consulta)) {
//                $cadena_datos .=  $resultados['ID_CONSULTA'] .",". $resultados["MEDICAMENTO"] . "," . $resultados["DOSIS"] . ","
//                    . $resultados["PRESENTACION"] . "," . $resultados["DOCTOR"] . "," . $resultados["INTERVALO"] . ","
//                    . $resultados["VIA"] . "," . $resultados["DURACION"] ;
//            }
//        }
//        echo $cadena_datos;
//    }
//    catch (Exception $e) {
//        echo 'Excepción capturada: ', $e->getMessage(), "\n";
//    }
//}