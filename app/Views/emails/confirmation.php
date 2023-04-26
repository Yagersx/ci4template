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
			background-color: #007bff;
			color: #fff;
			border-radius: 5px;
			text-decoration: none;
			font-size: 18px;
			transition: background-color 0.3s ease;
		}

		a:hover {
			background-color: #0069d9;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Confirmación de cuenta</h1>
		<p>Se ha creado una cuenta ligada a este correo. Haga clic en el siguiente botón para establecer su nueva
			contraseña.</p>
		<p>No olvides que para inicar sesion es necesario colocar tu correo electrónico y la contraseña que generes en
			el siguiente link.</p>
		<a href="<?= site_url('auth/reset-password?token=' . $token) ?>">Click aqui para establecer una contraseña</a>
	</div>
</body>

</html>