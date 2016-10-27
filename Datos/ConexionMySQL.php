<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 26/10/16
 */
class MySQL
{
    public $host = "localhost";
    private $usuario ="root";
    private $clave ="123456";
    private $nombreBD ="IMVE";
    private $conexion;
    private $total_consultas;
    public $consul;

    public function MySQL()
    {
        if(!isset($this->conexion))
        {
            $this->conexion = (mysqli_connect($this->host,$this->usuario,$this->clave,$this->nombreBD)) or die(mysqli_error());
        }
    }

    public function consulta($consulta)
    {
        $this->total_consultas++;
        $resultado = mysqli_query($this->conexion ,$consulta) or die (mysqli_error($this->conexion));
        if(!$resultado)
        {
            echo 'MySQL Error: ' . mysqli_error();
            exit;
        }
        mysqli_next_result($this->conexion);
        return $resultado;
    }

    public function fetch_array($consulta)
    {
        return mysqli_fetch_array($consulta);
    }

    public function num_rows($consulta)
    {
        return mysqli_num_rows($consulta);
    }

    public function getTotalConsultas()
    {
        return $this->total_consultas;
    }
}


