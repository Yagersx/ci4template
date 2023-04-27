<!DOCTYPE html>
<html>

<head>
	<title>Confirmación de cuenta</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f4f4f4;
		}

		.container {
			background-color: #fff;
			padding: 30px;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			text-align: center;
		}

		h1 {
			font-size: 36px;
			margin-bottom: 20px;
		}

		p {
			font-size: 18px;
			margin-bottom: 30px;
			line-height: 1.5;
		}

		a {
			display: inline-block;
			padding: 10px 20px;
			border-radius: 5px;
			border: 1px solid #007bff;
			text-decoration: none;
			font-size: 18px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}

		a:hover {
			background-color: #007bff;
			color: #fff;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>
			<?= $subject ?? 'Reestablecimiento de Contraseña' ?>
		</h1>
		<p>
			Se ha solicitado un reestablecimiento de contraseña para esta cuenta. Si no has sido tú, ignora este
			mensaje.
		</p>
		<p>
			De lo contrario, haz clic en el siguiente botón para reestablecer tu contraseña.
		</p>
		<br>
		<a href="<?= site_url('auth/reset-password?token=' . $token) ?>">Click aqui para reestablecer tu contraseña.</a>
	</div>
</body>

</html>