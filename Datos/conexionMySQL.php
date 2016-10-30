<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

// Clase que realiza la conexión a MySQL
class MySQL
{
    public $host      = "localhost"; // Servidor
    private $usuario  = "root";      // Usuario con el cual se realiza la conexión a la base de datos
    private $clave    = "123456";    // Contraseña del usuario con el que se realiza la conexión a la base de datos
    private $nombreBD = "IMVE";      // Nombre de la base de datos
    private $conexion;

    // Función que realiza la conexión con el servidor y selecciona la base de datos
    public function MySQL()
    {
        if (!isset($this->conexion))
        {
            $this->conexion = (mysqli_connect($this->host, $this->usuario, $this->clave, $this->nombreBD)) or die(mysqli_error());
        }
    }

    // Función que ejecuta un DML en la base de datos
    public function consulta($consulta)
    {
        $resultado = mysqli_query($this->conexion, $consulta) or die (mysqli_error($this->conexion));

        if (!$resultado)
        {
            echo 'MySQL Error: ' . mysqli_error();
            exit;
        }

        mysqli_next_result($this->conexion);

        return $resultado;
    }

    // Función con la cual se obtiene los datos de la consulta realizada
    public function fetch_array($consulta)
    {
        return mysqli_fetch_array($consulta);
    }

    // Función con la cual se obtiene el número de filas de la consulta realizada
    public function num_rows($consulta)
    {
        return mysqli_num_rows($consulta);
    }
}
