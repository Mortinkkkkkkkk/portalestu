<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
session_start();
if (isset($_SESSION['id_usuario'])){
    $iduser = $_SESSION['id_usuario'];
    $tipologado = $_SESSION['tipo'];
}

?>
<!-- INDEX POST -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universo Estudantil</title>
    <link rel="icon" type="image/x-icon" href="/public/assets/img/logo.ico">
    <link rel="stylesheet" href="/public/assets/css/index.css">
    <style>
        .post{
            border: 2px black solid;
        }
        .comentario{
            border: 2px red dotted;
        }
        .resposta {
            margin-left: 100px;
        }
    </style>
</head>
<body>
<header>
    <div class="logo-container">
            <img src="/public/assets/img/logo.png" alt="Logo Universo Estudantil" class="logo">
            <h1>Universo Estudantil</h1>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="#noticias">Notícias</a>
                    <ul class="submenu">
                        <li><a href="index.php">Últimas notícias</a></li>
                        <li><a href="?fltPsq=edu">Educação</a></li>
                        <li><a href="?fltPsq=cie">Ciência</a></li>
                    </ul>
                </li>
                <li><a href="#enem">ENEM</a>
                    <ul class="submenu">
                        <li><a href="?fltPsq=sim">Simulados</a></li>
                        <li><a href="?fltPsq=dica">Dicas de Estudo</a></li>
                        <li><a href="?fltPsq=ins">Inscrições</a></li>
                        <li><a href="?fltPsq=edital">Editais</a></li>
                    </ul>
                </li>
                <li><a href="#materias">Matérias</a>
                    <ul class="submenu">
                        <li><a href="?fltPsq=mat">Matemática</a></li>
                        <li><a href="?fltPsq=lin">Linguagens</a></li>
                        <li><a href="?fltPsq=cienat">Ciências da Natureza</a></li>
                        <li><a href="?fltPsq=ciehum">Ciências Humanas</a></li>
                        <li><a href="?fltPsq=red">Redação</a></li>
                    </ul>
                </li>
                <li><a href="#vocacional">Orientação Vocacional</a>
                    <ul class="submenu">
                        <li><a href="?fltPsq=testes">Testes Vocacionais</a></li>
                        <li><a href="#carreiras">Carreiras</a></li>
                        <li><a href="#depoimentos">Depoimentos de Profissionais</a></li>
                    </ul>
                </li>
                <li><a href="#blog">Blog</a>
                    <ul class="submenu">
                        <li><a href="?fltPsq=artigos">Artigos</a></li>
                        <li><a href="?fltPsq=entrevistas">Entrevistas</a></li>
                        <li><a href="?fltPsq=opiniao">Opinião</a></li>
                    </ul>
                </li>
                <li><a href="#contato">Contato</a>
                    <ul class="submenu">
                        <li><a href="#fale-conosco">Fale Conosco</a></li>
                        <li><a href="#faq">Perguntas Frequentes (FAQ)</a></li>
                    </ul>
                </li>
                
    </header>
    <?php 
        if(!isset($iduser)) {
    ?>
    <h3><a href="/index.html">login</a></h3>
    <?php } else {?>
    <h3><a href="/controle/controle_usuario.php?case=logout">Deslogin</a></h3>
    <?}?>
    <h3>usuario:</h3>
    <?php 
        if (!isset($iduser)){
           ?><p><a href="/public/dashboard/usuario/form_usuario.php?caso=insert">Cadastra-se</a></p><?
        } else if (isset($tipologado) && $tipologado == "X") {?>
        <p>criacao e lista de <a href="/public/dashboard/usuario/index.php">usuario</a></p>
        <p>hora agora</p>
        <?}?>
    <h3>Noticias:</h3>
    <div class="container-posts">
        <?php
            if (isset($tipologado) && $tipologado != "A") {
            ?><p>Criar um <a href="/public/form_post.php?case=insert">Noticias</a></p><?php
            }
            ?>
            <form action="/public/index.php" method="post">
                <label for="pesquisa">Procurar:</label>
                <input type="text" name="pesquisa" id="100">
                <select name="opcao_pesq" id="">
                    <option value="legenda">Legenda</option>
                    <option value="data">Data</option>
                    <option value="filtro">Filtro</option>
                </select>
                <input type="submit" value="Pesquisar">
            </form>
            <?php
            if (isset($_REQUEST['pesquisa'])) {
                ?>
                <a href="/public/index.php">Voltar</a>
                <?php
                $pesquisa ="%" . $_REQUEST['pesquisa'] . "%";
                $opcao_pesq = $_REQUEST['opcao_pesq'];
                switch ($opcao_pesq) {
                    case "data" :
                        $sql = "SELECT * FROM tb_post WHERE data_postagem LIKE ?";
                        break;
                    case "legenda":
                        $sql = "SELECT * FROM tb_post WHERE legenda LIKE ?";
                        break;
                    case "filtro":
                        $sql = "SELECT * FROM tb_post WHERE filtro LIKE ?";
                        break;
                }
                $rslt_pesq = executaSql($sql,'s',[$pesquisa]);
                if (sizeof($rslt_pesq[1]) == 0) {
                    $nada = true;
                } else {
                    $nada = false;
                }
            } else if(!isset($_REQUEST['pesquisa']) && isset($_REQUEST['fltPsq'])){
                $fltPsq = $_REQUEST['fltPsq'];
                switch ($fltPsq) {
                    case 'edu':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'linguagem' OR filtro = 'matematica' OR filtro = 'ciencia naturais' OR filtro = 'ciencia humanas' OR filtro = 'redacao'";
                        break;
                    case 'cie':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'ciencia humanas' OR filtro = 'ciencias naturais'";
                        break;
                    case 'sim':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'simulados'";
                        break;
                    case 'dica':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'dicasdeestudo'";
                        break;
                    case 'ins':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'inscricao'";
                        break;
                    
                }
                $rslt_pesq = SelectallSql($sql);
                if (sizeof($rslt_pesq[1]) == 0) {
                    $nada = true;
                } else {
                    $nada = false;
                }
            } else {
                $sql = "SELECT * FROM tb_post";
                $rslt_pesq = SelectallSql($sql);
                $nada = false;
            }   
            if (!$nada) {
                foreach ($rslt_pesq[1] as $row) {
                    ?><div class="post"><?
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
                    // $datapostagem = strtotime($datapostagem); 
                    // $datapostagem = date('y-m-d h:i:s',$datapostagem);
                    // $datatratada = date("y-m-d h:i:s") + $datapostagem;
                    ;
                    ?>
                    <p><? echo $legenda; ?></p>
                    <!-- <p><? echo $datatratada; ?></p> -->
                    <p><?= $datapostagem?></p>
                    <p><? echo $filtro; ?></p>
                    <?php
                        $sql_coment = "SELECT comentario,id_usuario, id_comentario, resposta_id FROM tb_comentario WHERE id_post = ? ORDER BY id_comentario, resposta_id";
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
                                if ($resposta != null) {
                                    ?><div class="comentario resposta"><p><?php
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
                                    echo $user_coment ." Respondeu " .$nm_us_org . ": " . $comentario ;?></p><?php

                                } else {
                                    ?><div class="comentario"><p><?php
                                    echo $user_coment . ": " . $comentario ;?></p><?php
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
                                if (isset($_SESSION) && isset($tipologado)) {
                                    if (!isset($iduser)){
                                        $iduser = 1;
                                    }
                                    if ($iduser == $iduser_coment && $iduser != 1 ||  $tipologado == "X") {
                                        ?>
                                            <p><a href="/controle/controle_comentario.php?case=deletar&id=<?=$id_comentario?>">DELETAR</a> COMENTARIO</p></div>
                                            <?php
                                    }
                                }
                                ?></div><?
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
                ?>
                <div class='post'>
                    <p>Nenhum Post Encontrado</p>
                </div>
                <?php
            }
        
        ?>
</div>

</body>
</html>