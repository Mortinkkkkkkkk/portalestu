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
    <p>hora agora</p>
    <?echo date("y-m-d h:i:s");?>
    <h3>posts:</h3>
    <div class="container-posts">
        <p>Criar um <a href="form_post.html">Post</a></p>
        <?php
            $sql = "SELECT * FROM tb_post";
            $conexao = conectarDB();
            $result = mysqli_query(conectarDB(),$sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='post'>";
                    $idpost = $row['id_post'];
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post= ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    foreach ($midia[1] as $listimg) {
                        $img = $listimg['midia'];
                        ?>
                        <img src="/assets/img/<?php echo $img;?>" alt="imagine uma">
                        <?php
                    }
                    $legenda = $row['legenda'];
                    $datapostagem = $row['data_postagem'];
                    $filtro = $row['filtro'];
                    ?>
                    <p><? echo $legenda; ?></p>
                    <p><? echo $datapostagem; ?></p>
                    <p><? echo $filtro; ?></p>
                    <?php
                        $sql_coment = "SELECT comentario, id_comentario, resposta_id FROM tb_comentario WHERE id_post = ?";
                        $resultcoment = executaSql($sql_coment,'i',[$idpost]);
                        if (sizeof($resultcoment[1]) > 0) {
                            foreach ($resultcoment[1] as $listcoment){
                                $comentario = $listcoment['comentario'];
                                $id_comentario = $listcoment['id_comentario'];
                                $resposta = $listcoment['resposta_id'];
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