<?php
	
	class meuchat
	{
		
		protected $pdo;
		protected $usuario;

		public function __construct($pdo)
		{

			$this->pdo = $pdo;

			$this->usuario = (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : NULL);

			if($this->usuario != null)
			{
			
				$this->atualiza_status();
			
			}

		}

		public function get_explode()
		{
		
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'login';
			return $explode = explode('/', $url);
		
		}

		// Paginação do sistema
		public function paginacao($pdo)
		{
		
			$explode = $this->get_explode();
			$folder = "navegacao/";
			$extension = ".php";
			$unlock = array("login", "admin");

			if(file_exists($folder.$explode['0'].$extension) && isset($_SESSION['admin']))
			{
				
				include_once($folder.$explode['0'].$extension);
			
			}if (file_exists($folder.$explode['0'].$extension) && isset($_SESSION['usuario'])) 
			{
				
				include_once($folder.$explode['0'].$extension);

			}else if(file_exists($folder.$explode['0'].$extension) && !isset($_SESSION['usuario']) && !isset($_SESSION['admin']))
			{
				
				if(!in_array($explode['0'], $unlock))	
				{
					
					include_once($folder."login".$extension);
				
				}else
				{
				
					include_once($folder.$explode['0'].$extension);
				}		
			
			}else if(!file_exists($folder.$explode['0'].$extension) && isset($_SESSION['usuario']))
			{			
			 	 
			 	echo "Página não encontrada";

			}
		}



		public function update_class()
		{

			$class = array("class='col-sm-8 offset-md-4' style='border:none; background: none;'", "class='col-sm-8'");

			if(isset($_SESSION['usuario']))
			{
				
				return $class[1];
			
			}else
			{
				
				return $class[0];
			
			}
		}

		// Redirecionamento de páginas
		public function redirect($url)
		{
		
				echo "<meta http-equiv='refresh' content='3;URL={$url}'>";
		
		}

		public function redirect_direct($url)
		{
		
				echo "<meta http-equiv='refresh' content='0;URL={$url}'>";
		
		}

		public function alerta($tipo, $mensagem, $col)
		{
		
			echo "<div class='alert alert-{$tipo} {$col}'>{$mensagem}</div>";
		
		}

		// Login do usuário
		protected function login()
		{
		
			if(isset($_POST['env']) && $_POST['env'] == "login")
			{
			
				try
				{
				
					$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
					$stmt->execute(array(':email' => $_POST['email'], ':senha' => $_POST['senha']));
					$total = $stmt->rowCount();

					if($total > 0)
					{
					
						$dados = $stmt->fetch(PDO::FETCH_ASSOC);
						$_SESSION['usuario'] = $dados['usuario'];
						$this->alerta('success', 'Logado com sucesso...', 'col-sm-6');
						$this->redirect('inicio');
					
					}else
					{
					
						$this->alerta('danger', 'Usuário ou senha inválidos...',  'col-sm-6');
					
					}

				}catch(PDOException $e)
				{
				
					return $e->getMessage();
				
				}

			}
		}

		// Login para a área administrativa
		protected function admin_login()
		{

			if (isset($_POST['enva']) && $_POST['enva'] == "adm") 
			{
			
				try
				{			
			
					$stmt = $this->pdo->prepare("SELECT * FROM superuser WHERE admin = :admin AND senha = :senha");
					$stmt->execute(array(':admin' => $_POST['admin'], ':senha' => $_POST['senha']));
					$max = $stmt->rowCount();

					if ($max > 0) 
					{
			
						$dados = $stmt->fetch(PDO::FETCH_ASSOC);
						$_SESSION['admin'] = $dados['admin'];
						$this->alerta('sucess', 'Logado com sucesso...', 'col-sm-6');
						echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=supervisor.php'>";

					}else
					{

						$this->alerta('danger', 'Usuário ou senha inválidos...', 'col-sm-6');

					}

				}catch(PDOException $e)
				{

					return $e->getMessage();

				}

			}

		}

		// Verifica o login do supervisor
		public function verifica_loginadm()
		{
			
			session_start();
			$stmt = $this->pdo->prepare("SELECT id FROM superuser WHERE admin = ? AND senha = ?");
			$stmt->bind_param('ss', $admin, $senha);
			$stmt->execute();
			$res = $stmt->get_result();

			if ($res->num_rows) 
			{
				
				$row = $res->fetch_array(MYSQLI_ASSOC);
				$_SESSION['admin'] = $row['id'];
				header('Location: supervisor.php');
				exit;

			}else
			{

				header('Location: login');
				exit;

			}

		}



		// Cadastro de um novo usuário
		public function cadastro()
		{
		
			if(isset($_POST['env']) && $_POST['env'] == "cad")
			{
			
				error_reporting(0);
				$status = $this->verifica_cadastro($_POST['email'], $_POST['usuario']);
				$post_dados = array($_POST['nome'], $_POST['usuario'], $_POST['email'], $_POST['senha'], $_POST['setor'], $_POST['sexo']);

				if($status == TRUE)
				{
					
					try
					{
						
						$stmt = $this->pdo->prepare("INSERT INTO usuarios (nome, usuario, email, senha, setor, sexo) VALUES(:nome, :usuario, :email, :senha, :setor, :sexo)");
						$stmt->execute(array(':nome' => $post_dados[0], 
											':usuario'  => $post_dados[1],
											':email' => $post_dados[2],
											':senha' => $post_dados[3],
											':setor' => $post_dados[4],
											':sexo'  => $post_dados[5]));
						
						$conta = $stmt->rowCount();

						if($conta > 0)
						{
				
							echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=tabela.php'>";

						}
						
					}catch(PDOException $e)
					{
					
						$e->getMessage();
					
					}

				}else
				{
				
					echo "<div class='alert alert-danger'>Usuário ou email já cadastrados, tente outro!</div>";
				
				}
			}
		}

		// Cadastro de um novo supervisor
		public function cadastroAdmin()
		{
			
			if(isset($_POST['env']) && $_POST['env'] == "admin")
			{
			
				error_reporting(0);
				$status = $this->verifica_cadastroAdmin($_POST['email'], $_POST['admin']);
				$post_dados = array($_POST['nome'], $_POST['email'], $_POST['setor'], $_POST['admin'], $_POST['senha']);
				$uploaddir = 'images/uploads/';
				$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

				if($status == TRUE)
				{
				
					try
					{
						
						$stmt = $this->pdo->prepare("INSERT INTO superuser (nome, email, setor, admin, senha, foto) VALUES(:nome, :email, :setor, :admin, :senha, :foto)");
						$stmt->execute(array(':nome' => $post_dados[0], 
											':email'  => $post_dados[1],
											':setor' => $post_dados[2],
											':admin' => $post_dados[3],
											':senha'  => $post_dados[4],
											':foto' => $uploadfile));
						$conta = $stmt->rowCount();

						if($conta > 0)
						{
						
							$this->alerta("success", "Cadastro efetuado com sucesso! Aguarde...", false);
							echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=supervisor.php'>";

						}
						
					}catch(PDOException $e)
					{
					
						$e->getMessage();
					
					}

				}else
				{
				
					echo "<div class='alert alert-danger'>Usuário ou email já cadastrados ou incorretos, tente outro!</div>";
				
				}
			}
		}	

		// Verifica cadastro do supervisor
		public function verifica_cadastroAdmin($email, $admin)
		{
			
			try
			{
			
				$stmt = $this->pdo->prepare("SELECT * FROM superuser WHERE email = :email OR admin = :admin");
				$stmt->execute(array(':email' => $email, ':admin' => $admin));
				$total = $stmt->rowCount();

				if($total > 0)
				{
				
					return false;
				
				}else
				{
				
					return true;
				
				}
			}catch(PDOException $e)
			{
			
				$e->getMessage();
			
			}
		}

		// Verifica cadastro do usuário
		public function verifica_cadastro($email, $usuario)
		{
			
			try
			{
				
				$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario OR email = :email");
				$stmt->execute(array(':usuario' => $usuario, ':email' => $email));
				$total = $stmt->rowCount();

				if($total > 0)
				{
				
					return false;
				
				}else
				{
				
					return true;
				
				}
			}catch(PDOException $e)
			{
			
				$e->getMessage();
			
			}
		}

		// Atualiza o tempo online do usuário
		public function atualiza_status()
		{
		
			$dataAtualizada = date('d-m-Y H:i:s', strtotime('+2 minutes'));

			try
			{
			
				$stmt = $this->pdo->prepare("UPDATE usuarios SET status = :status WHERE usuario = :usuario");
				$stmt->execute(array(':status' => $dataAtualizada, ':usuario' => $this->usuario));
			
			}catch(PDOException $e)
			{
			
				echo $e->getMessage();
			
			}
		}


		public function get_status($usuario)
		{
		
			$dataUser = $this->dados_user($usuario, "status");
			$data = $this->get_data();

			if($data <= $dataUser)
			{
			
				return "<img src='images/status-online.png' title='Online'>";
			
			}
		}


		// Inicia um chat
		public function verifica_chat($id_para)
		{
		
			try
			{
		    
		      $stmt = $this->pdo->prepare("SELECT * FROM chats WHERE id_de = :id_de AND id_para = :id_para OR id_de = :id_para AND id_para = :id_de");
		      $stmt->execute(array(':id_de' => $this->usuario, ':id_para' => $id_para));
		      $total = $stmt->rowCount();

		      if($total > 0)
		      {
		      
		      	$dados = $stmt->fetch(PDO::FETCH_ASSOC);
		      	$this->redirect_direct("chat/{$dados['id']}");
		      	exit();
		      
		      }else
		      {
		      
		      	$this->cria_chat($id_para);
		      	exit();
		      
		      }
		    }catch(PDOException $e)
		    {
		    
		      echo $e->getMessage();
		    
		    }
		}

	
		// Criação de um novo chat
		public function cria_chat($id_para)
		{ //falta adicionar a data
		
			$data = $this->get_data();
		    try
		    {
		    
		    	$stmt = $this->pdo->prepare("INSERT INTO chats (id_de, id_para) VALUES (:id_de, :id_para)");
		     	$stmt->execute(array(':id_de' => $this->usuario, ':id_para' => $id_para));
		      	$id = $this->pdo->lastInsertId();
		  
		      	$this->redirect_direct("chat/{$id}");
		      	exit();
		    
		    }catch(PDOException $e)
		    {
		    
		      	echo $e->getMessage();
		    
		    }

		}

		// Data
		public function get_data()
		{
		
			date_default_timezone_set('America/Sao_Paulo');
			return date('d-m-Y H:i:s');
		
		}

		// Diferencia datas de tempo do usuário
	  	public function diferencia_datas($data1)
	  	{

			$data1 = new DateTime($data1);
			$data2 = new DateTime($this->get_data());

			$intervalo = $data1->diff($data2);

			if($intervalo->y > 1)
			{

		  		return $intervalo->y." Anos atrás";
		
			}elseif($intervalo->y == 1)
			{

		  		return $intervalo->y." Ano atrás";
			
			}elseif($intervalo->m > 1)
			{

		  		return $intervalo->m." Meses atrás";
		
			}elseif($intervalo->m == 1)
			{

		  		return $intervalo->m." Mês atrás";
			
			}elseif($intervalo->d > 1)
			{

		  		return $intervalo->d." Dias atrás";
		
			}elseif($intervalo->d > 0)
			{

		  		return $intervalo->d." Dia atrás";
		
			}elseif($intervalo->h > 0)
			{

		  		return $intervalo->h." Horas atrás";
		
			}elseif($intervalo->i > 1 && $intervalo->i < 59)
			{

		  		return $intervalo->i." Minutos atrás";
		
			}elseif($intervalo->i == 1)
			{

		  		return $intervalo->i." Minuto atrás";
		
			}elseif($intervalo->s < 60 && $intervalo->i <= 0)
			{

		  		return $intervalo->s." Segundo atrás";
		
			}
	  	}

	  	// Dados dos usuários
	  	public function dados_user($usuario, $arr)
	  	{

	  		try
	  		{

	  			$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
	  			$stmt->execute(array(':usuario' => $usuario));
	  			$conta = $stmt->rowCount();

	  			if($conta > 0)
	  			{

	  				$dados = $stmt->fetch(PDO::FETCH_ASSOC);
	  				return $dados[$arr];
	  			
	  			}
	  		}catch(PDOException $e)
	  		{

	  			$e->getMessage();
	  		
	  		}
	  	}

	  	// Dados dos supervisores
	  	public function dados_super($admin, $ar)
	  	{

	  		try
	  		{
	  		
	  			$stmt = $this->pdo->prepare("SELECT * FROM superuser WHERE admin = :admin");
	  			$stmt->execute(array(':admin' => $admin));
	  			$conta = $stmt->rowCount();

	  			if($conta > 0)
	  			{

	  				$dados = $stmt->fetch(PDO::FETCH_ASSOC);
	  				return $dados[$ar];
	  			
	  			}
	  		}catch(PDOException $e)
	  		{
	  			
	  			$e->getMessage();
	  		
	  		}
	  	}

		public function pega_chats($id_de)
		{
			
			try
			{

		      $stmt = $this->pdo->prepare("SELECT * FROM chats WHERE id_de = :id_de OR id_para = :id_de ORDER BY lastupdate DESC");
		      $stmt->execute(array(':id_de' => $id_de));
		      $count = $stmt->rowCount();

		      while($dados = $stmt->fetch(PDO::FETCH_ASSOC))
		      {

		      	$this->pega_mensagem_chat($dados['id']);
		      
		      }
		    }catch(PDOException $e)
		    {

		      echo $e->getMessage();
		    
		    }
		}

		public function pega_mensagem_chat($id)
		{

			try
			{

		      	$sql = $this->pdo->prepare("SELECT * FROM mensagens WHERE id_chat = :id_chat ORDER BY id DESC LIMIT 1");
		      	$sql->execute(array(':id_chat' => $id));

		      	while($dsql = $sql->fetch(PDO::FETCH_ASSOC))
		      	{

		      		echo "{$this->verifica_chat_ativo($id)}
					  <div class='chat_people'>

					    <div class='chat_img'> 

					    	<img src='{$this->dados_user($this->verifica_nomes_chat($id),"foto")}'> 

					    </div>
					    <div class='chat_ib'>
					      
					      <h5>
					      
					      <a href='chat/{$id}' class='name-user' onclick='verifica_status()'>{$this->get_status($this->dados_user($this->verifica_nomes_chat($id),"usuario"))} 
					      		{$this->dados_user($this->verifica_nomes_chat($id),"nome")}</a> 
					      		<span class='chat_date'>{$this->diferencia_datas($dsql['data'])}</span>

					      </h5>
					      
					      <p>{$dsql['mensagem']}</p>
					    
					    </div>
					  
					  </div>
					
					</div>";

		      	}

		    }catch(PDOException $e)
		    {

            	echo $e->getMessage();
		      
		     }
		
		}

		// Nomes de usuários dentro do chat
		public function verifica_nomes_chat($id)
		{

			try
			{
				
				$stmt = $this->pdo->prepare("SELECT * FROM chats WHERE id = :id");
				$stmt->execute(array(':id' => $id));

				$dados = $stmt->fetch(PDO::FETCH_ASSOC);

				if($dados['id_de'] == $this->usuario )
				{

					return $dados['id_para'];
				
				}else if ($dados['id_para'] == $this->usuario)
				{

					return $dados['id_de'];
				
				}
				}catch(PDOException $e)
				{

					return $e->getmessage();
				}
			
			}

		// Verifica chats já iniciados	
		public function verifica_chat_ativo($id)
		{
			//$explode = $this->get_explode();
			if(isset($_GET['atual']) && $_GET['atual'] == $id)
			{

				echo "<div class='chat_list active_chat'>";
			
			}else
			{
			
				echo "<div class='chat_list'>";
			
			}
		}

		// Preparo para inserção de mensagem
		public function insere_mensagem()
		{
		//$explode = $this->get_explode();
			$get = (isset($_GET['atual']) ? $_GET['atual'] : NULL);

			$form = array($this->usuario, $get, date("d-m-Y H:i:s"));
          	if(isset($_POST['env']) && $_POST['env'] == "ms")
          	{
            
            	try
            	{

              		$stmt = $this->pdo->prepare("INSERT INTO mensagens (id_de, id_chat, mensagem, data) VALUES(:id_de, :id_chat, :mensagem, :data)");
              		$stmt->execute(array(':id_de' => $form['0'], 
                                    ':id_chat' => $form['1'], 
                                    ':mensagem' => $_POST['msg'], 
                                    ':data' => $form['2']));
              		$this->atualiza_tempo_chat($get);
              		return json_encode(array("success" => TRUE));
            	}catch(PDOException $e)
            	{

              		return json_encode(array("success" => FALSE, "error" => $e->getMessage()));
            	
            	}
          	}
      	}

      	// Inserção da mensagem do supervisor
      	public function mensagem_supervisor()
      	{
      		
      		if(isset($_POST['env']) && $_POST['env'] == "ms")
      		{
      		
      			$post_msg = array($_SESSION['admin'], $_POST['setor'], $_POST['msg'], date("d-m-Y H:i:s"));

      			try 
      			{
      			
      				$stmt = $this->pdo->prepare("INSERT INTO msg_supervisor (supervisor, setor, mensagem, data) VALUES(:supervisor, :setor, :mensagem, :data)");
      				$stmt->execute(array(':supervisor' => $post_msg[0],
      									':setor' => $post_msg[1],
      									':mensagem' => $post_msg[2],
      									':data' => $post_msg['3']));

      			} catch (PDOException $e) 
      			{
      			
      				$e->getMessage();

      			}

      		}

      	}

      public function form_mensagem()
      {

      	$this->insere_mensagem();
      
      }

      // Atualização de tempo de chat
      protected function atualiza_tempo_chat($id)
      {

      	$data = $this->get_data();

      	try
      	{
      	
      		$stmt = $this->pdo->prepare("UPDATE chats SET lastupdate = :data WHERE id = :id");
      		$stmt->execute(array(':data' => $data, ':id' => $id));
      	
      	}catch(PDOException $e)
      	{
      	
      		echo $e->getMessage();
      	
      	}
      	
      }

      // Verifica mensagens lidas
      public function atualiza_lido($id)
      {

      	try
      	{

      		$stmt = $this->pdo->prepare("UPDATE mensagens SET lido = 1 WHERE id_de != :id_de AND id_chat = :id_chat");
      		$stmt->execute(array(':id_de' => $this->usuario, ':id_chat' => $id));	
      	
      	}catch(PDOException $e)
      	{
      	
      		echo $e->getMessage();
      	
      	}
      	
      } 	

      // Verifica se existe algum usuário logado no sistema
      public function verifica_logado()
      {
      	
      	if($this->usuario != NULL)
      	{
      	
      		echo "<meta http-equiv='refresh' content='0;URL=inicio'>";
      		exit();
      	
      	}
      
      }

      public function verifica_admlogado()
      {
      	
      	if ($this->admin != NULL) 
      	{
      		
      		echo "<meta http-equiv='refresh' content='0;URL=inicio'";
      		exit();

      	}

      }

            // Verifica se tem novas mensagens no sistema
            public function get_msg($msg)
            {
            
            	$data = $this->get_data();
            	try
            	{
            	
            		if($msg == 1)
            		{
            			
            			$stmt = $this->pdo->prepare("SELECT * FROM msg_supervisor WHERE data >= :data AND supervisor <> :usuario LIMIT 50");
            			$stmt->execute(array(':data' => $data, ':usuario' => $this->usuario));
      	      	
      	      	}else
      	      	{
      	      	
      	      		$stmt = $this->pdo->prepare("SELECT * FROM msg_supervisor WHERE setor = :setor AND data >= :data AND supervisor <> :usuario LIMIT 50");
      	      		$stmt->execute(array(':setor' => $msg, ':data' => $data, ':usuario' => $this->usuario));	
      	      	
      	      	}
            		
            		$conta = $stmt->rowCount();

            		if($conta > 0)
            		{
            		
            			while($dados = $stmt->fetch(PDO::FETCH_ASSOC))
            			{

            				echo 
            					"<div class='msg_history' id='msghistory'>
	
            						<br>
            						<div id='mensagem'>

										<div class='incoming_msg'>

											<div class='incoming_msg_img'>

												<img src='navegacao/superuser.png' alt='sunil'> 

											</div>

											<div class='received_msg'>

												<div class='received_width_msg'>

													<span>

														// NOME DO SUPERVISOR

													</span>
													<p>

														// MENSAGEM
														{$dados['mensagem']}

													</p>
													<span class='time_date'>

														// DATA DA MENSAGEM

													</span>

													<br><br>

												</div>

											</div>

										</div>

            						</div>

            					</div>";
            			}

            		}

            	}catch(PDOException $e)
            	{
            	
            		echo $e->getMessage();
            	
            	}
            
            }

      // Verifica se tem usuários onlines no sistema
      public function get_onlines($sexo)
      {
      
      	$data = $this->get_data();
      	try
      	{
      	
      		if($sexo == 0)
      		{
      			
      			$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE status >= :data AND usuario <> :usuario LIMIT 50");
      			$stmt->execute(array(':data' => $data, ':usuario' => $this->usuario));
	      	
	      	}else
	      	{
	      	
	      		$stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE sexo = :sexo AND status >= :data AND usuario <> :usuario LIMIT 50");
	      		$stmt->execute(array(':sexo' => $sexo, ':data' => $data, ':usuario' => $this->usuario));	
	      	
	      	}
      		
      		$conta = $stmt->rowCount();

      		if($conta > 0)
      		{
      		
      			while($dados = $stmt->fetch(PDO::FETCH_ASSOC))
      			{

      				$separa_nome = explode(' ', $dados['nome']);
      				echo "<div class='user'>
							<img src='{$dados['foto']}' class='img-user'><br>
							<span><img src='images/status-online.png' class='status' /> <a href='nchat/{$dados['usuario']}'>".ucfirst($separa_nome['0'])."</a></span>
							</div>
							</div>";
      			}

      		}

      	}catch(PDOException $e)
      	{
      	
      		echo $e->getMessage();
      	
      	}
      
      }

      // Editar dados dos supervisores
      public function editar_adm()
      {

      	error_reporting(0);
      	$id = filter_input(INPUT_GET, "id");

      	if (isset($_POST['env']) && $_POST['env'] == "alt-adm") 
      	{
      	
      		$stmt = $this->pdo->prepare("UPDATE superuser SET nome = :nome, email = :email, setor = :setor, admin = :admin, senha = :senha WHERE id = '$id';");
      		$stmt->execute(array(':nome' => $_POST['nome'],
      								':email' => $_POST['email'],
      								':setor' => $_POST['setor'],
      								':admin' => $_POST['admin'],
      								':senha' => $_POST['senha']));

      	if ($stmt->rowCount() > 0) 
      	{
      		
      		$this->alerta("success", "Dados alterados com sucesso!", false);
      		echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=../logout'>";

      	}else
      	{

      		echo "Erro: ".$this->pdo->errorInfo();
      		
      	}

      }

    }

      // Editar dados dos usuários já cadastrados no sistema
      public function editar_dados()
      {

      	if(isset($_POST['env']) && $_POST['env'] == "alt")
      	{
      	
      		//move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)
      		$uploaddir = 'images/uploads';
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
      		if($_FILES['userfile']['size'] <= 0 )
      		{

      			$stmt = $this->pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, sexo = :sexo WHERE usuario = :usuario");
      			$stmt->execute(array(':nome' => $_POST['nome'],
      									':email' => $_POST['email'],
      									':senha' => $_POST['senha'],
      									':sexo' => $_POST['sexo'],
      									':usuario' => $this->usuario));
      		
      		}else
      		{

      			$stmt = $this->pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, sexo = :sexo, foto = :foto WHERE usuario = :usuario");
      			$stmt->execute(array(':nome' => $_POST['nome'],
      									':email' => $_POST['email'],
      									':senha' => $_POST['senha'],
      									':sexo' => $_POST['sexo'],
      									':foto' => $uploadfile,
      									':usuario' => $this->usuario));
      			move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
      		
      		}

      		if($stmt->rowCount() > 0)
      		{

      			$this->alerta("success", "Dados alterados com sucesso!", false);
      			$this->redirect("configs");
      		
      		}else
      		{
      		
      			echo "Erro: ".$this->pdo->errorInfo();
      		
      		}
      		
      	}
     	
     }

           public function editar_dados_sudo()
           {

           	$id = filter_input(INPUT_GET, "id");

           	if(isset($_POST['env']) && $_POST['env'] == "alt")
           	{
           	
           		$stmt = $this->pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, sexo = :sexo, usuario = :usuario, setor = :setor WHERE id = '$id';");
           		$stmt->execute(array(':nome' => $_POST['nome'],
           								':email' => $_POST['email'],
           								':senha' => $_POST['senha'],
           								':sexo' => $_POST['sexo'],
           								':usuario' => $_POST['usuario'],
           								':setor' => $_POST['setor']));

           		if($stmt->rowCount() > 0)
           		{

           			$this->alerta("success", "Dados alterados com sucesso!", false);
           			echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=tabela.php'>";
           		
           		}else
           		{
           		
           			echo "Erro: ".$this->pdo->errorInfo();
           		
           		}
           		
           	}
          	
        }

}
?>