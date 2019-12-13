<?php

    // Deletar usuários cadastrados no sistema
    $id = filter_input(INPUT_GET, "id");

    $link = mysqli_connect("localhost", "root", "");
    mysqli_select_db($link, "mychat");

    if ($link)
    {

        $query = mysqli_query($link, "DELETE FROM superuser where id ='$id';");
        if ($query)
        {

            header("Location: ../login");

        }else
        {

            die(mysqli_error($link));

        }
    }else
    {

        die(mysqli_error($link));

    }

?>
