<?php 

	$chat = new meuchat($pdo);
	$chat->verifica_admlogado();
	session_start();

?>

<!-- Box de login do supervisor -->
<div class="admin col-sm-6">
		
	<div class="admin-box">
	
		<!-- Formulários de login -->
		<form method="POST">
			
			<header>

				<h2>Supervisor</h2>
				<h4>Login</h4>
			
			</header>
			<p>
			
				<input type="text" name="admin" id="admin" class="admin-input text-dark" placeholder="Usuário" required>

			</p>

			<div class="input-group mb-3">
		  	
		  		<input type="password" name="senha" id="senha" class="admin-input text-dark" placeholder="**********" required="">
			
			 </div>

			<p>

				<input type="submit" value="Entrar" id="btnLogin" name="btnLogin" class="btn btn-outline-success btn-md btn-block"/>

			</p>
			
				<input type="hidden" name="enva" value="adm">

			<div class="alert alert-primary" role="alert">

				<p class="infos-login text-center">
				
					<a href="login" class="small alert-link text-dark">Já tem um cadastro? Acesse aqui.</a>

				</p>
			
			</div>
			
		</form>

	</div>

</div>

<?php $chat->admin_login();?>
 