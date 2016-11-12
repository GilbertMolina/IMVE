<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 30/10/16
 */

class VersionAPP
{
    function obtenerVersionApp()
    {
        $VERSION_APP = '0.61';

        return 'v' . $VERSION_APP;
    }

    function obtenerNombreApp()
    {
        $NOMBRE_APP = 'Sistema IMVE';

        return $NOMBRE_APP;
    }
}
