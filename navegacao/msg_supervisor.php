<?php

  $chat = new meuchat($pdo);
  header("Refresh: 5");

  require_once('navegacao/blockeds.php');

    $parametro = filter_input(INPUT_GET, "parametro");
    $conexao = mysqli_connect('localhost','root','');
    $banco = mysqli_select_db($conexao, 'mychat');

    if ($parametro)
    {

      $information = mysqli_query($conexao, "SELECT * FROM msg_supervisor where 1");

    }else
    {

      $information = mysqli_query($conexao, "SELECT * FROM msg_supervisor order by id");

    }

    $linha = mysqli_fetch_assoc($information);
    $total = mysqli_num_rows($information);

?>
<script type="text/javascript">

  seta_status(true);

</script>

<?php if(isset($_SESSION['usuario'])){?>

<div class="title-chat">

  <div class="u-info">

    <i class="fas fa-arrow-left" onclick="seta_status(false)" id="backbtn"></i>
    <img src="navegacao/superuser.png">
    <span>Supervisor</span>

    <!-- <select id="busca-s" class="custom-select" data-show-icon="true">

      <option value="0">Selecione o seu setor</option>
      <option value="1"><?php echo $chat->dados_user($_SESSION['usuario'], 'setor'); ?></option>

    </select> -->

  </div>

</div>

<input type="hidden" id="id_msg" value="<?php echo $explode['1'];?>" >

<div class="msg_history" id="msghistory">

  <br>
  <div id="mensagem">

    <?php

      if ($total)
      {

        do
        {

    ?>

    <div class='incoming_msg'>

      <div class='incoming_msg_img'>

        <img src="navegacao/superuser.png" alt='sunil'>

      </div>

      <div class='received_msg'>

        <div class='received_withd_msg'>

          <span>


            <?php

              echo $linha['supervisor'] . " - " . $linha['setor'];

            ?>

          </span>
          <p>

            <?php

              echo $linha['mensagem'];

            ?>

          </p>
          <span class='time_date'>

            <?php

              echo $linha['data'];

            ?>

          <br><br>

        </div>

      </div>

      <?php

        } while ($linha = mysqli_fetch_assoc($information));

          mysqli_free_result($information);}
        mysqli_close($conexao);

      ?>

    </div>

  </div>

</div>

<?php }?>
