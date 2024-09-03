<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .post{
            border: 2px black solid;
        }
        .comentario{
            border: 2px red dotted;
        }
    </style>
</head>
<body>
    <h1>universo estudantil</h1>
    <h3>usuario:</h3>
    <p>criacao e lista de <a href="usuario.php">usuario</a></p>

    <h3>posts:</h3>
    <div class="container-posts">
        <p>Criar um <a href="form_post.html">Post</a></p>
        <?php
            $sql = "SELECT * FROM tb_post";
            $result = selectSql($sql,'',['idpost','curtida','legenda','datapostagem','filtro']);
            print_r($result);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='post'>";
                    $idpost = $row['id_post'];
                    $sqlimg = "SELECT midia FROM tb_midia WHERE id_post = ?";
                    $midia = selectSql($sqlimg,"i",$idpost);
                    while ($img = mysqli_fetch_array($midia)){
                        ?>
                        <img src="/assets/img/<?php echo $img['midia'];?>" alt="imagine uma">
                        <?php
                    };
                    $legenda = $row['legenda'];
                    $datapostagem = $row['data_postagem'];
                    $filtro = $row['filtro'];
                    ?>
                    <p><? echo $legenda; ?></p>
                    <p><? echo $datapostagem; ?></p>
                    <p><? echo $filtro; ?></p>
                    <?php
                        $sql_comenta = "SELECT * FROM tb_comentario WHERE id_post = ?";
                        $result_comenta = selectSql($sql_comenta,"i",$idpost);
                        if (mysqli_num_rows($result_comenta) > 0) {
                            while ($row_coment = mysqli_fetch_array($result_comenta)){
                                $comentario = $row_coment["comentario"];
                                $id_comentario = $row_coment["id_comentario"];
                                $resposta = $row_coment["resposta_id"];
                                ?><div class="comentario"><p><?php
                                if ($resposta != null) {
                                    echo ">";
                                };
                                echo $comentario;?></p></div>
                                <form action="controle/controle_comentario.php?case=comentario" method="post">
                                    <input type="text" name="resposta">
                                    <input type="hidden" name=" id_comentario" value="<?echo $id_comentario;?>">
                                    <input type="hidden" name="id_post" value="<?echo $idpost;?>">
                                    <input type="submit" value="responder">
                                </form>
                                <?php
                            };
                        } else {
                            echo "nenhum comentario";
                        };
                    ?>
                    <form action="/controle/controle_comentario.php?case=post" method="post">
                        <label for="comentario">Comente:</label>
                        <input type="text" name="comentario">
                        <input type="hidden" name="id_post" value="<?echo $idpost?>">
                        <input type="submit" value="enviar">
                    </form>
                    </div>
                    <?php

                }

        
        
        ?>

    </div>

</body>
</html>