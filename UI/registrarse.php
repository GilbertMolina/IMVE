<?php
/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 26/10/16
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registro de usuario</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width">
		<link rel="shorcut icon" href="Includes/images/favicon.ico" />
		<link href="Includes/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="Includes/css/styles.css" rel="stylesheet" type="text/css"/>
		<link href="Includes/jquerymobile/jquery.mobile-1.4.2.min.css" rel="stylesheet" type="text/css"/>
		<link href="Includes/jqueryconfirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
		<link href="Includes/jqueryui/jquery-ui-1.12.1.css" rel="stylesheet" type="text/css"/>
		<script src="Includes/jquerymobile/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="Includes/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="Includes/jqueryui/jquery-ui-1.12.1.js"></script>
		<script src="Includes/jquerymobile/jquery.mobile-1.4.2.min.js" type="text/javascript"></script>
		<script src="Includes/jqueryconfirm/jquery-confirm.min.js" type="text/javascript"></script>
		<script src="../Negocio/RegistrarseCN.js" type="text/javascript"></script>
		<script src="Includes/js/utilitarios.js" type="text/javascript"></script>
		<script>
			$(function() {
				if ( $('[type="date"]').prop('type') != 'date' ) {
					$('[type="date"]').datepicker();
				}
			});
		</script>
	</head>
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="b" data-position="fixed">
				<a href="../index.php" data-icon="carat-l" data-transition="slide" data-direction="reverse">Regresar</a>
				<h1>Registro de usuario</h1>
			</div>
			<div data-role="content">
				<div class="container">
					<div class="row" >
						<div class="col-sm-2 col-md-3 col-lg-3"></div>
						<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
							<form method="post" action="#" id="inicioSesion">
								<div>
									<label for="txtIdentificacion">Identificación:</label>
									<input type="text" name="txtIdentificacion" id="txtIdentificacion" placeholder="102220333" maxlength="30" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="txtNombre">Nombre:</label>
									<input type="text" name="txtNombre" id="txtNombre" maxlength="20" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="txtApellido1">Primer apellido:</label>
									<input type="text" name="txtApellido1" id="txtApellido1" maxlength="20" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="txtApellido2">Segundo apellido:</label>
									<input type="text" name="txtApellido2" id="txtApellido2" maxlength="20" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="txtFechaNacimiento">Fecha de nacimiento:</label>
									<input type="date" name="txtFechaNacimiento" id="txtFechaNacimiento" value="01/01/1900">
								</div>
								<br>
								<div>
									<label for="cboIdPistrito">Provincia:</label>
									<select name="cboIdPistrito" id="cboIdProvincia">
										<option value="N">Seleccione</option>
									</select>
								</div>
								<br>
								<div>
									<label for="cboIdCanton">Cantón:</label>
									<select name="cboIdCanton" id="cboIdCanton">
										<option value="N">Seleccione</option>
									</select>
								</div>
								<br>
								<div>
									<label for="cboIdDistrito">Distrito:</label>
									<select name="cboIdDistrito" id="cboIdDistrito">
										<option value="N">Seleccione</option>
									</select>
								</div>
								<br>
								<div>
									<label for="txtDireccionExacta">Dirección domicilio:</label>
									<textarea name="txtDireccionExacta" id="txtDireccionExacta" maxlength="250" data-clear-btn="true"></textarea>
								</div>
								<br>
								<div>
									<label for="txtTelefono">Teléfono:</label>
									<input type="tel" name="txtTelefono" id="txtTelefono" placeholder="88888888" maxlength="8" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="txtCelular">Celular:</label>
									<input type="tel" name="txtCelular" id="txtCelular" placeholder="88888888" maxlength="8" onKeyPress="javascript:return soloNumeros(event)" data-clear-btn="true"/>
								</div>
								<br>
								<div>
									<label for="cboSexo">Género:</label>
									<select name="cboSexo" id="cboSexo">
										<option value="N">Seleccione</option>
										<option value="F">Femenino</option>
										<option value="M">Masculino</option>
									</select>
								</div>
								<br>
								<div>
									<label for="txtContrasena">Contraseña:</label>
									<input type="password" name="txtContrasena" id="txtContrasena" maxlength="50" data-clear-btn="true">
								</div>
								<br>
								<div>
									<label for="txtConfirmarContrasena">Confirmar contraseña:</label>
									<input type="password" name="txtConfirmarContrasena" id="txtConfirmarContrasena" maxlength="50" data-clear-btn="true">
								</div>
								<br>
								<div>
									<div>
										<button type="submit" id="btnGuardar" data-theme="b" onclick="">Guardar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-2 col-md-3 col-lg-3"></div>
					</div>
				</div>
				<div data-role="footer" data-theme="b" data-position="fixed">
					<div data-role="navbar">
						<ul>
							<li>
								<a href="#acercade" data-icon="info" data-rel="dialog" data-transition="slidedown">Acerca de</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div data-role="page" id="acercade" data-theme="a">
				<div data-role="header" data-theme="b">
					<h1>Acerca de</h1>
				</div>
				<div data-role="content">
					<center><h2 style="margin-top: 0px">Iglesia Manantiales de Vida Eterna</h2></center>
					<p style="text-align: justify">
						<b>Misión:</b> Manantiales de Vida Eterna, ministerio Cristo céntrico, llamado a ganar Cartago y Costa Rica para el reino de Dios. Proclama bajo la unción del Espíritu Santo, el evangelio que salva para vida eterna.
					</p>
					<br>
					<p style="text-align: justify; margin-top: -10px">
						<b>Visión:</b> Ser una Iglesia reconocida como un ministerio de alcance sólido y edificado conforme al carácter de Jesucristo, logrando la excelencia mediante la dirección del Señor.
					</p>
				</div>
			</div>
	</body>
</html>