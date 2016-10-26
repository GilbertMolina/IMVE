<?php
class ConectarMySQL {
    public static function conexion() {
        $BaseDatos = "IMVE";
        $Servidor = "localhost";
        $Usuario = "root";
        $Clave = "123456";
        
        $conexion = mysql_connect($Servidor, $Usuario, $Clave);
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET 'utf8'");
        $seleccionarBase = mysql_select_db($BaseDatos, $conexion);
        
        if (!$conexion) {
            die('<h1>Error al conectar a la base de datos.</h1><h2>Por favor, verifique que la contrase&ntilde;a sea la correcta.</h2>');
            mysql_close($conexion);
        }
        
        if (!$seleccionarBase) { 
            die('<h1>Error al seleccionar la base de datos.</h1><h2>Por favor, verifique que la base de datos sea la correcta y que este bien escrito.</h2>');
            mysql_close($conexion);
        }
        
        return $conexion;
    }
}



