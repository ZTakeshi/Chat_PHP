<?php

	$chat = new meuchat($pdo);
	$chat->verifica_logado();

?>

<!-- Box de login do usuário -->
<div class="logar col-sm-6">

	<div class="logar-box">

		<form method="POST">

			<header>

				<h2>Usuário</h1>
				<h4>Login</h4>

			</header>
			<p>

				<input type="email" name="email" id="email" class="logar-input text-dark" placeholder="example@brisanet.com" required>

			</p>

			<div class="input-group mb-3">

		  		<input type="password" class="logar-input text-dark" name="senha" id="senha" placeholder="**********" required>

			</div>

			<p>

				<input type="submit" value="Entrar" class="btn btn-outline-success btn-md btn-block"/>

			</p>

			<input type="hidden" name="env" value="login">

			<div class="alert alert-primary" role="alert">

				<p class="infos-login text-center">

					<a href="admin" class="small alert-link text-dark">Não tem um cadastro? Acesse aqui.</a>

				</p>

			</div>

		</form>

	</div>

</div>

<?php $chat->login();?>
