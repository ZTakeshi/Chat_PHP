<?php 

	$chat = new meuchat($pdo);
	require_once('navegacao/blockeds.php');

?>
<script type="text/javascript">
	
	$(document).ready(function()
	{

	  $('#showPassword').on('click', function()
	  {
	    
	    var passwordField = $('#senha');
	    var passwordFieldType = passwordField.attr('type');
	    if(passwordFieldType == 'password')
	    {
	     
	        passwordField.attr('type', 'text');
	        $(this).val('Ocultar');
	    
	    } else 
	    {

	        passwordField.attr('type', 'password');
	        $(this).val('Mostrar');
	    
	    }
	  
	  });
	
	});

</script>

<!-- Box editar dados dos usuários -->
<div class="bar">

	<h4>Editar dados</h4>

</div>
<div class="edit-dados">

	<form method="POST" class="col-sm-7" enctype="multipart/form-data">
		
		<br>
		<p>
			
			<div class="form-group row">
			   
			   <label for="inputName3" class="col-sm-2 col-form-label">Nome: </label>
			   <div class="col-sm-10">
			    
			    	<p>

			    		<input type="text" name="nome" class="form-control" value="<?php echo $chat->dados_user($this->usuario, 'nome');?>" readonly="true">

			    	</p>
			   
			   </div>
			 
			</div>
		
		</p>
		
		<p>
		
			<div class="form-group row">
			
			   <label for="inputEmail3" class="col-sm-2 col-form-label">Email: </label>
			   <div class="col-sm-10">
			
			     <p>

			     	<input type="email" name="email" class="form-control" value="<?php echo $chat->dados_user($this->usuario, 'email');?>" readonly="true">

			     </p>
			   
			   </div>

			</div>
		
		</p>

		<p>

			<div class="form-group row">
			    
			   	<label for="senha" class="col-sm-2 col-form-label">Senha: </label>
			    <div class="col-sm-10">
			      
			      <div class="input-group mb-3">
			      
			        <input type="password" name="senha" id="senha" class="form-control" value="<?php echo $chat->dados_user($this->usuario, 'senha');?>" readonly="true">
			        <div class="input-group-append">
			        	
			        	<input type="button" id="showPassword" value="Mostrar" class="btn btn-outline-primary">
			        
			        </div>
			      
			      </div>
			    
			    </div>

			</div>
		
		</p>

		<p>
		
			<div class="form-group row">
			  
			   <label for="inputEmail3" class="col-sm-2 col-form-label">Perfil: </label>

			   <div class="col-sm-10">
			  
			   		<p>

			   			<input type="file" name="userfile" accept="image/*" class="form-control">

			   		</p>
			  
			   </div>

			</div>
		
		</p>

		<p>
		
			<?php
				$sexoAtual = null;
				switch($chat->dados_user($this->usuario, 'sexo'))
				{

					case 0:

						$sexoAtual = "<option value='0'>Feminino(Atual)</option>";
					
					break;

					case 1:
					
						$sexoAtual = "<option value='1'>Masculino(Atual)</option>";
					
					break;
				
				}
			?>

		<p>
		
			<input type="submit" value="Alterar cadastro" class="btn btn-outline-success btn-lg btn-block">
		
		</p>
		
		<input type="hidden" name="env" value="alt">
		
	</form>
	
	<?php $chat->editar_dados();?>

</div>