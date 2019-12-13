<?php

  require_once('../navegacao/block.php');
  include_once("../pdo/include.php");
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

  <title>Sistema de chat - Supervisor/Meus dados</title>

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <?php if(isset($_SESSION['admin'])){?>
  <!-- Barra horizontal -->
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="../supervisor.php">

      Acesso administrativo

    </a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">

      <i class="fas fa-bars"></i>

    </button>

    <!-- Barra horizontal Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

      <div class="input-group">

        <div class="input-group-append">

        </div>

      </div>

    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

      <li>

        <span class="navbar-brand mr-1">

          <?php echo $chat->dados_super($_SESSION['admin'],'admin');?>
          <br>

        </span>

      </li>

      <li class="nav-item dropdown no-arrow">

        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

          <i class="fas fa-user-circle fa-2x"></i>

        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">

            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span>

          </a>

        </div>

      </li>

    </ul>

  </nav>

  <div id="wrapper">

    <!-- Área de menu -->
    <ul class="sidebar navbar-nav">

      <li class="nav-item active">

        <a class="nav-link" href="../supervisor.php">

          <i class="fas fa-home"></i>
          <span>Início</span>

        </a>

      </li>

      <li class="nav-item active">

        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">

          <i class="far fa-comment-alt"></i>
          <span>Acessar chat</span>

        </a>

      </li>

      <li class="nav-item active">

        <a href="#" class="nav-link" data-toggle="modal" data-target="#mensagemModal">

          <i class="fas fa-comments"></i>
          <span>Mensagem</span>

        </a>

      </li>

      <li class="nav-item active">

        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt"></i>
        <span>Sair</span></a>

      </li>

    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">

          <li class="breadcrumb-item">

            <a href="#">MeuChat</a>

          </li>

          <li class="breadcrumb-item active">Meus dados</li>

        </ol>

        <!-- Formulário supervisor -->
        <div class="card mb-3">

          <div class="card-header">

            <i class="far fa-address-card"></i>
            Alterar meus dados

          </div>

          <div class="card-body">

            <div class="table-responsive">

              <form method="POST" class="col-sm-7" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $id ?>"/>

                <p>

                  <div class="form-group row">

                    <label for="inputName3" class="col-sm-2 col-form-label">Nome: </label>
                    <div class="col-sm-10">

                    <p><input type="text" name="nome" class="form-control" value="<?php echo $chat->dados_super($_SESSION['admin'],'nome');?>"></p>

                    </div>

                  </div>

                </p>

                <p>

                  <div class="form-group row">

                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email: </label>
                    <div class="col-sm-10">

                    <p><input type="email" name="email" class="form-control" value="<?php echo $chat->dados_super($_SESSION['admin'],'email');?>"></p>

                    </div>

                  </div>

                </p>

                <p>

                  <div class="form-group row">

                    <label for="inputAdmin3" class="col-sm-2 col-form-label">Setor: </label>
                    <div class="col-sm-10">

                    <p><input type="text" name="setor" class="form-control" value="<?php echo $chat->dados_super($_SESSION['admin'],'setor');?>"></p>

                    </div>

                  </div>

                </p>

                <p>

                  <div class="form-group row">

                    <label for="inputAdmin3" class="col-sm-2 col-form-label">Usuário: </label>
                    <div class="col-sm-10">

                    <p><input type="text" name="admin" class="form-control" value="<?php echo $chat->dados_super($_SESSION['admin'],'admin');?>"></p>

                    </div>

                  </div>

                </p>

                <p>

                  <div class="form-group row">

                    <label for="senha" class="col-sm-2 col-form-label">Senha: </label>
                    <div class="col-sm-10">

                      <div class="input-group mb-3">

                        <input type="password" name="senha" id="senha" class="form-control" value="<?php echo $chat->dados_super($_SESSION['admin'],'senha');?>">

                      </div>

                    </div>

                  </div>

                </p>

                <p>

                  <input type="submit" value="Alterar dados" class="btn btn-outline-success btn-lg btn-block">
                  <?php

                    echo
                      '<a class="btn btn-outline-danger btn-lg btn-block" href="../crud/deletes.php?id='. $chat->dados_super($_SESSION['admin'], 'id') .'">

                          <span>Excluir conta</span>

                        </a>';

                  ?>

                </p>

                  <input type="hidden" name="env" value="alt-adm">

              </form>

              <?php $chat->editar_adm();?>

            </div>

          </div>

        </div>

      </div>

    </div>



  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Mensagem setor modal -->
  <div class="modal fade" id="mensagemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollabelTitle" aria-hidden="true">

      <div class="modal-dialog modal-dialog-scrollable" role="document">

        <div class="modal-content">

          <div class="modal-header">

            <h6 class="modal-title" id="exampleModalScrollabelTitle">

              <?php  echo $chat->dados_super($_SESSION['admin'], 'admin'), ', enviar mensagem para o setor '; echo $chat->dados_super($_SESSION['admin'], 'setor');?>

            </h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span>

            </button>

          </div>

          <div class="box modal-body">

            <div class="type_msg">

              <div class="input_msg_write">

                <form method="POST" id="sendmsg">

                  <input type="hidden" id="setor" value="<?php echo $explode['0'];?>">

                  <select class="form-control custom-select" name="setor" required>

                    <option value="<?php echo $chat->dados_super($_SESSION['admin'],'setor');?>">

                      <?php echo $chat->dados_super($_SESSION['admin'], 'setor') ?>

                    </option>

                  </select>

                  <br>
                  <br>

                  <input type="text" class="" name="msg" id="msg" autocomplete="off" placeholder="Digite sua mensagem...">
                  <button class="msg_send_btn" type="submit">

                    <i class="fa fa-paper-plane" aria-hidden="true"></i>

                  </button>
                  <input type="hidden" name="env" value="ms">

                </form>

                  <?php $chat = new meuchat($pdo); $chat->mensagem_supervisor();?>

              </div>

            </div>

          </div>
          <div class="modal-footer">

          </div>

        </div>

      </div>

  </div>

  <!-- Logout Modal Alteração de dados-->
  <div class="modal fade" id="logoutAlterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Acesso administrativo</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">×</span>

          </button>

        </div>
        <div class="modal-body">

          <?php echo $chat->dados_super($_SESSION['admin'],'admin'),', Deseja realmente alterar seus dados?' ;?>

        </div>

        <div class="modal-footer">

          <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-danger" href="../logout/">Sim</a>

        </div>

      </div>

    </div>

  </div>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Acesso administrativo</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">×</span>

          </button>

        </div>
        <div class="modal-body">

          <?php echo $chat->dados_super($_SESSION['admin'],'admin'),', Deseja realmente sair?' ;?>

        </div>

        <div class="modal-footer">

          <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
          <a class="btn btn-danger" href="../logout/">Sim</a>

        </div>

      </div>

    </div>

  </div>

  <?php } ?>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../js/demo/datatables-demo.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>

</body>

</html>
