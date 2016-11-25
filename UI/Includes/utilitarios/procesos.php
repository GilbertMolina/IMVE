<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 30/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

class UtilitariosProcesos
{
    function ObtenerNombreUsuario()
    {
        if (!isset($_SESSION['nombreCompleto'])
            && !isset($_SESSION['token']))
        {
            // Si el usuario no ha iniciado sesión se le redirige a la página de inicio de sesión
            header('location: ../../index.php');
        }
        else
        {
            return $nombreUsuario = explode(" ", $_SESSION['nombreCompleto'])[0] . ' ' . explode(" ", $_SESSION['nombreCompleto'])[1];
        }
    }

    function ObtenerMensajeBienvenida()
    {
        if (!isset($_SESSION['nombreCompleto'])
            && !isset($_SESSION['token']))
        {
            // Si el usuario no ha iniciado sesión se le redirige a la página de inicio de sesión
            header('location: ../../index.php');
        }
        else
        {
            $mensajeInicioBienvenida = ($_SESSION['sexo'] == 'F') ? 'Bienvenida' : 'Bienvenido';
            $nombreUsuario = explode(" ", $_SESSION['nombreCompleto'])[0] . ' ' . explode(" ", $_SESSION['nombreCompleto'])[1];
            return $mensajeInicioBienvenida . ' ' . $nombreUsuario;
        }
    }

    function ObtenerRolUsuario()
    {
        return $_SESSION['rol'];
    }

    function ObtenerNombrePersona()
    {
        // Se realiza el llamado a la clase de conexion
        require("../../Datos/conexionMySQL.php");
        $db = new MySQL();

        // Se carga una persona en especifíco en la pantalla de ver detalle
        if (isset($_GET['IdPersona'])) {
            $idPersona = $_GET['IdPersona'];

            $sqlPersona      = "CALL TbPersonasListarPorIdPersona('$idPersona')";
            $consultaPersona = $db->consulta($sqlPersona);
            $nombrePersona = "";

            if($db->num_rows($consultaPersona) != 0)
            {
                while($resultadosPersona = $db->fetch_array($consultaPersona))
                {
                    $nombrePersona = $resultadosPersona['Nombre'] . ' ' . $resultadosPersona['Apellido1'] . ' ' . $resultadosPersona['Apellido2'];
                }
            }
            return $nombrePersona;
        }
    }
}
