<?php 

	include_once("pdo/include.php");
	$chat = new meuchat($pdo);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

 	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="">
  	<meta name="author" content="Lucas Takeshi">

	<title>Sistema de chat - Brisanet/Início</title>

	<base href="http://localhost/SistemaChat2k19/">

	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" >
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<link href="css/style.css" rel="stylesheet" id="bootstrap-css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>

</head>
<body>

	<div class="row">

		<?php if(isset($_SESSION['usuario'])){?>
		<div class="col-sm-4" id="left-menu">

			<div class="user_infos">

				<div class="menu">

					<a href="inicio/" class="nlink"><i class="fas fa-home"></i>&nbsp; Inicio |&nbsp;</a>
					<a href="configs/" class="nlink"><i class="fas fa-user-edit"></i>&nbsp; Editar |&nbsp;</a>
					<a href="msg_supervisor/" class="nlink"><i class="fas fa-user-tie"></i>&nbsp; Supervisores |&nbsp;</a>
					<a class="nlink" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt"></i>&nbsp; Sair &nbsp;</a>
					<hr class="duser">

				</div>
				<img src="<?php echo $chat->dados_user($_SESSION['usuario'],'foto');?>">
				<span>

					<?php echo $chat->dados_user($_SESSION['usuario'],'usuario');?>
					<hr>
					<h4>Minhas conversas</h4>
					<hr>

				</span>

			</div>
			<div class="box_chat" id="chats">
			</div>
		</div><?php }?>
		<div <?php echo $chat->update_class();?>>

			<?php $chat->paginacao($pdo);?>

		</div>

	</div>

	<!-- Logout Modal -->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog" role="document">

			<div class="modal-content">

				<div class="modal-header">

					<h5 class="modal-title" id="exampleModalLabel">

						Brisanet Chat

					</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true">×</span>

					</button>

				</div>

				<div class="modal-body">

					<?php echo $chat->dados_user($_SESSION['usuario'], 'usuario') ,', Deseja realmente sair?'; ?>

				</div>

				<div class="modal-footer">

					<button class="btn btn-secondary" type="button" data-dismiss="modal">

						Não

					</button>
					<a href="sair/" class="btn btn-danger">Sim</a>

				</div>

			</div>

		</div>

	</div>

</body>
</html>
