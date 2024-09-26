<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
session_start();
if ($_SESSION['id_usuario']){
    $iduser = $_SESSION['id_usuario'];
    $tipologado = $_SESSION['tipo'];
}

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
    <h3><a href="login.html">login</a></h3>
    <h3><a href="/controle/controle_usuario.php?case=logout">Deslogin</a></h3>
    <h3>usuario:</h3>
    <p>criacao e lista de <a href="/public/dashboard/usuario/index.php">usuario</a></p>
    <p>hora agora</p>
    <?echo date("y-m-d h:i:s");?>
    <h3>posts:</h3>
    <div class="container-posts">
        <p>Criar um <a href="/public/form_post.php?case=insert">Post</a></p>
        <?php
            $sql = "SELECT * FROM tb_post";
            $conexao = conectarDB();
            $result = mysqli_query(conectarDB(),$sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='post'>";
                    $iduser_post = $row['id_usuario'];
                    $idpost = $row['id_post'];
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post= ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    foreach ($midia[1] as $listimg) {
                        $img = $listimg['midia'];
                        ?>
                        <img src="<?= $img;?>" alt="imagine uma">
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
                        $sql_coment = "SELECT comentario,id_usuario, id_comentario, resposta_id FROM tb_comentario WHERE id_post = ?";
                        $resultcoment = executaSql($sql_coment,'i',[$idpost]);
                        if (sizeof($resultcoment[1]) > 0) {
                            foreach ($resultcoment[1] as $listcoment){
                                $comentario = $listcoment['comentario'];
                                $iduser_coment = $listcoment['id_usuario'];
                                $id_comentario = $listcoment['id_comentario'];
                                $sql_comt_name_user = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                                $resultnomeusuer = executaSql($sql_comt_name_user,'i',[$iduser_coment]);
                                
                                $nome_user_coment = $resultnomeusuer[1][0];
                                if ($iduser_coment == '1')
                                $user_coment = "Anonimo";
                                else {
                                    $user_coment = $nome_user_coment['nome_usuario'];
                                }
                                $resposta = $listcoment['resposta_id'];
                                ?><div class="comentario"><p><?php
                                if ($resposta != null) {
                                    // Pega o id do usuario do comentario de origem da resposta
                                    $sql_cmnt_org = "SELECT id_usuario FROM tb_comentario WHERE id_comentario = ?";
                                    $rslt_cmnt_org = executaSql($sql_cmnt_org,'i',[$resposta]);
                                    $row_cmt_org = $rslt_cmnt_org[1][0];
                                    $id_us_cmnt_org = $row_cmt_org['id_usuario'];
                                    // Pega o nome do usario do comentario de origem
                                    $sql_nm_us_org = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                                    $rslt_nm_us_org = executaSql($sql_nm_us_org,'i',[$id_us_cmnt_org]);
                                    $row_nm_us_org = $rslt_nm_us_org[1][0];
                                    $nm_us_org = $row_nm_us_org['nome_usuario'];
                                    // comentario:
                                    echo $user_coment ." Respondeu " .$nm_us_org . ": " . $comentario ;?></p></div><?php

                                } else {
                                    echo $user_coment . ": " . $comentario ;?></p></div><?php
                                }
                                if (isset($_SESSION)) {
                                    if (!isset($iduser)){
                                        $iduser = 1;
                                    }
                                    if ($iduser == $iduser_coment && $iduser != 1 ||  $tipologado == "X") {
                                        ?>
                                            <p><a href="/controle/controle_comentario.php?case=deletar&id=<?=$id_comentario?>">DELETAR</a> COMENTARIO</p>
                                        <?php
                                    }
                                }
                                ?>
                                <form action="/controle/controle_comentario.php?case=comentario_resposta" method="post">
                                    <input type="text" name="resposta">
                                    <input type="hidden" name="id_user" value="<?= $iduser;?>">
                                    <input type="hidden" name="id_comentario" value="<?= $id_comentario;?>">
                                    <input type="hidden" name="id_post" value="<?= $idpost;?>">
                                    <input type="submit" value="responder">
                                </form>
                                <?php
                            };
                        } else {
                            echo "nenhum comentario";
                        };
                    ?>
                    <form action="/controle/controle_comentario.php?case=comentario_post" method="post">
                        <label for="comentario">Comente:</label>
                        <input type="text" name="comentario">
                        <input type="hidden" name="id_post" value="<?echo $idpost?>">
                        <input type="hidden" name="id_user" value="<?= $iduser;?>">
                        <input type="submit" value="enviar">
                    </form>
                    <?php 
                        // $iduser = id do usuario logado
                        // $iduser_post = id do usaurio que postou
                        if (isset($iduser)) {
                            if ($iduser_post == $iduser || $tipologado == "X") {
                            ?>
                            <p>Editar post: <a href="/controle/controle_post.php?case=delete&id=<?=$idpost?>">Deletar</a> <a href="form_post.php?case=update&id=<?=$idpost?>">Atualizar</a></p>
                            <?php
                        }
                    }
                    ?>
                    </div>
                    <?php

                }

        
        
        ?>

    </div>

</body>
</html>