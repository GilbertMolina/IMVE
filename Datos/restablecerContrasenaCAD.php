<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 29/10/16
 */

session_start();

error_reporting(11);
ini_set('display_errors', 1);

// Se realiza el llamado a la libreria de enviar correo
require('Utilitarios/PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

// Se realiza el llamado a la clase de conexion
require("conexionMySQL.php");
$db = new MySQL();

// Se restablece la contraseña del usuario y se envia por correo
if (isset($_POST['action']) && $_POST['action'] == 'restablecerContrasena') {
    try {
        $identificacion = "";
        $idPersona      = "";
        $identificacion = "";
        $nombreCompleto = "";
        $correo         = "";
        $sexo           = "";
        $validacion     = "";

        $identificacion = $_POST['identificacion'];

        $sql      = "CALL TbUsuariosSolicitarDatos('$identificacion')";
        $consulta = $db->consulta($sql);

        if ($db->num_rows($consulta) != 0) {
            while ($resultados = $db->fetch_array($consulta)) {
                $idPersona        = $resultados['IdPersona'];
                $identificacion   = $resultados['Identificacion'];
                $nombreCompleto   = $resultados['NombreCompleto'];
                $correo           = $resultados['Correo'];
                $sexo             = $resultados['Sexo'];
                $validacion       = (strlen($correo) > 0) ? "1" : "-1";
                $exitoDatos = "1";
            }
        } else {
            $exitoDatos = "-1";
            echo $validacion = "-1";
        }

        if ($exitoDatos == "1"){
            $mail->isSMTP();                          // Configurar el uso de SMTP
            $mail->Host        = 'smtp.gmail.com';    // Especificar el servidor de correo de SMPT
            $mail->SMTPAuth    = true;                // Habilitar la autenticación de SMTP
            $mail->Username    = 'imveuia@gmail.com'; // Usuario de correo, este fue creado exclusivamente para este proyecto
            $mail->Password    = 'imveuia2016';       // Contraseña
            $mail->SMTPSecure  = 'tls';               // Habilitar la encriptación TLS
            $mail->Port        = 587;                 // Puerto TCP por el cual se lleva a cabo la conexión
            $mail->CharSet     = 'UTF-8';             // Se configura para utilizar el charset utf8

            $correoSistemaIMVE = 'imveuia@gmail.com';
            $nombreSistemaIMVE   = 'Sistema IMVE';

            $identificacionSolicitante         = $identificacion;
            $correoSolicitante                 = $correo;
            $nombreSolicitante                 = $nombreCompleto;
            $nuevaContraseñaGenerada           = GenerarContrasena();
            $nuevaContraseñaGeneradaEncriptada = sha1($nuevaContraseñaGenerada);

            // Se procede a actualizar la contraseña
            $sql = "CALL TbUsuariosRestablecerContrasena('$idPersona','$identificacion','$nuevaContraseñaGeneradaEncriptada')";
            $consulta = $db->consulta($sql);

            if ($db->num_rows($consulta) != 0) {
                while ($resultados = $db->fetch_array($consulta)) {
                    $idPersona         = $resultados['Id'];
                    $exitoRestablecer  = "1";
                    $validacion       .= ",1";
                }

            } else {
                $exitoRestablecer = "-1";
                $validacion      .= ",-1";
            }

            if ($exitoRestablecer == "1")
            {
                $mail->setFrom($correoSistemaIMVE, $nombreSistemaIMVE);
                $mail->addAddress($correoSolicitante, $nombreSolicitante);

                $mail->isHTML(true);

                $mail->Subject = 'Recordatorio de contraseña en Sistema IMVE';

                $InicioMensaje = ($sexo == 'F') ? 'Estimada' : 'Estimado';

                $htmlContenido = '<html>'
                               . '<body>'
                               . '<p>' . $InicioMensaje . ' ' . $nombreSolicitante . ',<br /><br />'
                               . 'Usted ha solicitado recordar su contraseña en el Sistema IMVE, los datos son los siguientes.<br><br>'
                               . 'Identificación: <strong>' . $identificacionSolicitante . '</strong><br><br>'
                               . 'Contraseña: <strong>' . $nuevaContraseñaGenerada . '</strong><br /><br />'
                               . 'Recuerde cambiar la contraseña una vez ingresado al sistema.<br><br>'
                               . 'Saludos cordiales.<br><br>'
                               . '<strong>Sistema IMVE</strong><br><br>'
                               . '</p>'
                               . '</body>'
                               . '</html>';

                $mail->Body = $htmlContenido;

                $textoContenido = $InicioMensaje . ' ' . $nombreSolicitante . ','
                                . 'Usted ha solicitado restablecer su contraseña en el Sistema IMVE, la cual ya ha sido restablecida y los datos son los siguientes.'
                                . ''
                                . 'Identificación: ' . $identificacionSolicitante
                                . ''
                                . 'Contraseña: ' . $nuevaContraseñaGenerada
                                . ''
                                . 'Recuerde cambiar la contraseña una vez ingresado al sistema.'
                                . ''
                                . 'Saludos cordiales'
                                . ''
                                . ''
                                . 'Sistema IMVE';

                $mail->AltBody = $textoContenido;

                if($mail->send()) {
                    $validacion .= ",1";
                } else {
                    $validacion .= ",-1";
                    echo 'Error: ' . $mail->ErrorInfo;
                }
            }
        }
        echo $validacion;
    }
    catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
}

// Función que genera una contraseña aleatoria
function GenerarContrasena(){
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);
    $contrasena = "";
    $longitudContrasena = 10;

    for($i = 1; $i <= $longitudContrasena; $i++){
        $posicion = rand(0, $longitudCadena - 1);
        $contrasena .= substr($cadena, $posicion, 1);
    }
    return $contrasena;
}
