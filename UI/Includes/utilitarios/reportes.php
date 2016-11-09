<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 30/10/16
 */

session_start();

class UtilitariosReportes
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
}