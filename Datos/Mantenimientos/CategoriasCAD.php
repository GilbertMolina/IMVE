<?php
/*Se importa el archivo de ConexionMySQL de la base de datos*/
require_once ("ConexionMySQL.php");

/*Clase que maneja los DMLs de las categorias*/
class Categorias{
    
/*Se declara la variable "$consultas" de tipo private*/
    private $consultas;
    
/*Funcion constructor*/
    public function __construct() {
        $this->consultas = array();
    }
        
/*Funcion que muestra las categorias*/
    public function mostrarCategorias() {
        $sql = "SELECT * "
                . "FROM IMVE.TbCategorias";
	$mostrarCategorias = mysql_query($sql, ConectarMySQL::ConexionMySQL());
	while ($resultadoCategoria = mysql_fetch_assoc($mostrarCategorias)) {
            $this->consultas[] = $resultadoCategoria;
	}
        return $this->consultas;
    }
  

/*Funcion que muestra los datos de las categorias que se selecciono para editar*/
    /*public function mostrarCategoriasPorId($idCategoria) {
        $sql = "SELECT * "
                . "FROM IMVE.TbCategorias "
                . "WHERE IdCategoria = '$idCategoria' ";
	$editarProveedorPorId = mysql_query($sql, ConectarMySQL::ConexionMySQL());
	while ($resultadoProveedor = mysql_fetch_assoc($editarProveedorPorId)) {
		$this->consultas[] = $resultadoProveedor;
	}
	return $this->consultas;
    }*/
    
/*Funcion que hace las inserciones de los proveedores*/
    /*public function registroProveedores($nombre, $razonSocial, $cedula, $costo_del_servicio, $descripcion_del_servicio) {
       $sql = "INSERT INTO tproveedor (nombre_proveedor, razon_social, cedula, costo_servicio_referencia, descripcion_servicio) 
			   VALUES ('$nombre', '$razonSocial', '$cedula', '$costo_del_servicio', '$descripcion_del_servicio') ";
       $registroProveedor = mysql_query($sql, ConectarMySQL::ConexionMySQL());
       header("location: ../proveedores/mostrarProveedor.php");
    }*/
    
/*Funcion que permite editar los datos de los proveedores*/
    /*public function editarProveedores($nombre, $razonSocial, $cedula, $costo_del_servicio, $descripcion_del_servicio, $idproveedor) {
       $sql = "UPDATE tproveedor SET 
               nombre_proveedor='$nombre', razon_social='$razonSocial', cedula='$cedula', costo_servicio_referencia='$costo_del_servicio', descripcion_servicio='$descripcion_del_servicio' 
               WHERE id_proveedor='$idproveedor' ";
       $editarProveedor = mysql_query($sql, ConectarMySQL::ConexionMySQL());
       header("location: ../proveedores/mostrarProveedor.php");
    }*/
    
/*Funcion que permite eliminar un proveedor seleccionado*/
    /*public function eliminarProveedores($idproveedor) {
       $sql = "DELETE FROM tproveedor 
			   WHERE id_proveedor = '$idproveedor' ";
       $eliminarProveedor = mysql_query($sql, ConectarMySQL::ConexionMySQL());
       header("location: ../proveedores/mostrarProveedor.php");
    }*/

}
