<?php 
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/session.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
    session_start();
    if (isset($_REQUEST['iduser'])) {
        $idusuario = $_REQUEST['iduser'];
    } else if (isset($_SESSION['id_usuario'])) {
        $idusuario = $_SESSION['id_usuario'];
    } else {
        sessionPermit('aluno');
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
            margin-bottom: 10px;
        }
    </style>

</head>
<body>
    <?php
        $sql_usr_prfl = "SELECT * FROM tb_usuario WHERE id_usuario = ?";
        $rslt_usr_prfl = executaSql($sql_usr_prfl, 'i', [$idusuario]);
        if (sizeof($rslt_usr_prfl[1]) > 0) {
            foreach ($rslt_usr_prfl[1] as $row_usr) {
                $nome = $row_usr['nome_usuario'];
                $email = $row_usr['email_usuario'];
                $tipo = $row_usr['tipo'];
                $foto = $row_usr['foto_usuario'];
            }
        } 
        else {
            redirect("pagina_inicial","Usuario não existente");
        }
        ?>
        <p><?= $foto?></p>
        <p><?= $nome?></p>
        <p><?= $email?></p>
        <?php 
            switch ($tipo){
                case 'A':
                    echo "Aluno";
                    break;
                case "P":
                    echo "Professor";
                    break;
                case "X":
                    echo "Admim";
                    break;
            }
        ?>
        <p><a href="form_usuario.php?case=update">Alterar o perfil</a></p>
        <p><a href="form_filtro.php?case=update">Alterar os filtros</a></p>
        <?php
        if ($tipo != "A") {
            $sql_pst_prfl = "SELECT * FROM tb_post WHERE id_usuario = ? ORDER BY data_postagem DESC, fixado";
            $rslt_pst_prfl = executaSql($sql_pst_prfl,'i',[$idusuario]);
            if (sizeof($rslt_pst_prfl[1]) > 0 ){
                foreach ($rslt_pst_prfl[1] as $row_pst) {
                    ?><div class="post"><?                    
                    $idpost = $row_pst['id_post'];
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post= ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    foreach ($midia[1] as $listimg) {
                        $img = $listimg['midia'];
                        ?>
                        <img src="<?= $img;?>" alt="imagine uma">
                        <?php
                    }
                    $legenda = $row_pst['legenda'];
                    $datapostagem = $row_pst['data_postagem'];
                    $filtro = $row_pst['filtro'];
                    ?>
                    <p><? echo $legenda; ?></p>
                    <p><?= $datapostagem?></p>
                    <p><? echo $filtro; ?></p>
                    <?php
                    if (isset($iduser)  && isset($tipologado)) {
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
            } else {
                ?><div class="post">
                    <p>Não a post feito por esse usuario</p>
                </div><?php
            }
        } else {
            ?><div class="post">
                    <p>Esse usuario é um aluno</p>
                </div><?php
        }
    ?>
</body>
</html>