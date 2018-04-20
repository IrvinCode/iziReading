<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /usuario.php');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, correo, contra FROM usuarios WHERE correo = :email and contra = :password');
    $records->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $records->bindParam(':password', $password);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: ../index.php");
    } else {
      $message = 'Algo esta mal en tus datos';
    }
  }

?>
<!DOCTYPE html>
<html>
	<head>
		<title>IziREading - Inicio de sesion</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<noscript><link rel="stylesheet" href="../assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a href="../index.php" class="logo">IziREading</a>
					</header>

          <!-- Nav -->
  					<nav id="nav">
  						<ul class="links">
  							<li><a href="../index.php">Cursos</a></li>
  							<li class="active"><a href="login.php">Usuario</a></li>
  						</ul>
  						<ul class="icons">
  							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
  							<li><a href="#" class="icon fa-user"><span class="label">Usuario</span></a></li>
  						</ul>
  					</nav>

				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<section class="post">
								<header class="major">
                  <form action="login.php" method="POST" class="alt">
                    <div class="row uniform">
                      <?php if(!empty($message)): ?>
                        <p> <?= $message ?></p>
                      <?php endif; ?>
                      <div class="6u 12u$(xsmall)">
                        <input type="email" name="email" id="email" placeholder="Correo" required/>
                      </div>
                      <div class="6u$ 12u$(xsmall)">
                        <input type="password" name="password" id="password" placeholder="Contraseña" required/>
                      </div>
                      <div class="12u$">
                        <ul class="actions">
                        <input type="submit" value="Iniciar sesion"/>
                      </ul>
                    </div>
                  </form><br><br>
                    <form action="signup.php" method="GET" class="">
                      <input type="submit" value="Crear cuenta" class="special"/>
                    </form>
								</header>

                </section>

					</div>

          <!-- Footer -->
  					<footer id="footer">
  						<section>
  							<form method="post" action="#">
  								<div class="field">
  									<label for="name">Nombre</label>
  									<input type="text" name="name" id="name" />
  								</div>
  								<div class="field">
  									<label for="email">Correo</label>
  									<input type="text" name="email" id="email" />
  								</div>
  								<div class="field">
  									<label for="message">Mensaje</label>
  									<textarea name="message" id="message" rows="3"></textarea>
  								</div>
  								<ul class="actions">
  									<li><input type="submit" value="Send Message" /></li>
  								</ul>
  							</form>
  						</section>
  						<section class="split contact">
  							<section class="alt">
  								<h3>Calle</h3>
  								<p>1234 Somewhere Road #87257<br />
  								Nashville, TN 00000-0000</p>
  							</section>
  							<section>
  								<h3>Telefono</h3>
  								<p><a href="#">(000) 000-0000</a></p>
  							</section>
  							<section>
  								<h3>Correo</h3>
  								<p><a href="#">info@untitled.tld</a></p>
  							</section>
  							<section>
  								<h3>Social</h3>
  								<ul class="icons alt">
                    <li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
  								</ul>
  							</section>
  						</section>
  					</footer>

  				<!-- Copyright -->
  					<div id="copyright">
  						<ul><li>&copy; IziREading</li><li>Aprende y mejora</a></li></ul>
  					</div>

			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>
