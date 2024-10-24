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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .img-perfil {
            width: 50px;
            border-radius: 100%;
            margin: 5px 10px 0 5px;
        }
        .img-size {
            width: 100%;
            height: 300px;
        }
        .div-user {
            display: flex;
            flex-direction: row;
        }
        .div-user a {
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
            color: #000;
        }
        .resposta {
            padding-left: 10px;
            margin-left: 50px;
            border-left: solid 2px gray;
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
                        <li><a href="/public/index.php?fltPsq=edu">Educação</a></li>
                        <li><a href="/public/index.php?fltPsq=cie">Ciência</a></li>
                    </ul>
                </li>
                <li><a href="#enem">ENEM</a>
                    <ul class="submenu">
                        <li><a href="/public/index.php?fltPsq=sim">Simulados</a></li>
                        <li><a href="/public/index.php?fltPsq=dica">Dicas de Estudo</a></li>
                        <li><a href="/public/index.php?fltPsq=ins">Inscrições</a></li>
                        <li><a href="/public/index.php?fltPsq=edital">Editais</a></li>
                    </ul>
                </li>
                <li><a href="#materias">Matérias</a>
                    <ul class="submenu">
                        <li><a href="/public/index.php?fltPsq=mat">Matemática</a></li>
                        <li><a href="/public/index.php?fltPsq=lin">Linguagens</a></li>
                        <li><a href="/public/index.php?fltPsq=cienat">Ciências da Natureza</a></li>
                        <li><a href="/public/index.php?fltPsq=ciehum">Ciências Humanas</a></li>
                        <li><a href="/public/index.php?fltPsq=red">Redação</a></li>
                    </ul>
                </li>
                <li><a href="#vocacional">Orientação Vocacional</a>
                    <ul class="submenu">
                        <li><a href="/public/index.php?fltPsq=testes">Testes Vocacionais</a></li>
                        <li><a href="#carreiras">Carreiras</a></li>
                        <li><a href="#depoimentos">Depoimentos de Profissionais</a></li>
                    </ul>
                </li>
                <li><a href="#blog">Blog</a>
                    <ul class="submenu">
                        <li><a href="/public/index.php?fltPsq=artigos">Artigos</a></li>
                        <li><a href="/public/index.php?fltPsq=entrevistas">Entrevistas</a></li>
                        <li><a href="/public/index.php?fltPsq=opiniao">Opinião</a></li>
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
        <?php }
            if (isset($iduser)) {
        ?>
        <p><a href="/public/dashboard/usuario/perfil.php">Perfil</a></p>
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
                        $sql = "SELECT * FROM tb_post WHERE data_postagem LIKE ? ORDER BY data_postagem DESC";
                        break;
                    case "legenda":
                        $sql = "SELECT * FROM tb_post WHERE legenda LIKE ? ORDER BY data_postagem DESC";
                        break;
                    case "filtro":
                        $sql = "SELECT * FROM tb_post WHERE filtro LIKE ? ORDER BY data_postagem DESC";
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
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'linguagem' OR filtro = 'matematica' OR filtro = 'ciencia naturais' OR filtro = 'ciencia humanas' OR filtro = 'redacao' ORDER BY data_postagem DESC";
                        break;
                    case 'cie':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'ciencia humanas' OR filtro = 'ciencias naturais' ORDER BY data_postagem DESC";
                        break;
                    case 'sim':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'simulados' ORDER BY data_postagem DESC";
                        break;
                    case 'dica':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'dicasdeestudo' ORDER BY data_postagem DESC";
                        break;
                    case 'ins':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'inscricao' ORDER BY data_postagem DESC";
                        break;
                    case 'edital':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'edital' ORDER BY data_postagem DESC";
                        break;
                    case 'mat':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'matematica' ORDER BY data_postagem DESC";
                        break;
                    case 'lin':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'linguagem' ORDER BY data_postagem DESC";
                        break;
                    case 'cienat':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'ciencias naturais' ORDER BY data_postagem DESC";
                        break;
                    case 'ciehum':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'ciencia humanas' ORDER BY data_postagem DESC";
                        break;
                    case 'red':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'redacao' ORDER BY data_postagem DESC";
                        break;
                    case 'testes':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'testesvocacional' ORDER BY data_postagem DESC";
                        break;
                    case 'artigos':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'artigos' ORDER BY data_postagem DESC";
                        break;
                    case 'entrevistas':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'entrevistas' ORDER BY data_postagem DESC";
                        break;
                    case 'opiniao':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'opiniao' ORDER BY data_postagem DESC";
                        break;
                    default: 
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'filtronaoexitentepradarerrodeproposito'";
                        break;
                }
                $rslt_pesq = SelectallSql($sql);
                if (sizeof($rslt_pesq[1]) == 0) {
                    $nada = true;
                } else {
                    $nada = false;
                }
            } else {
                $sql = "SELECT * FROM tb_post ORDER BY data_postagem DESC";
                $rslt_pesq = SelectallSql($sql);
                $nada = false;
            }   
            if (!$nada) {
                foreach ($rslt_pesq[1] as $row) {
                    ?><div class="card mb-3" style="max-width: 540px">
                        <div class="row g-0">
                            <div class=""><?
                    $iduser_post = $row['id_usuario'];
                    $idpost = $row['id_post'];
                    $sqluser = "SELECT foto_usuario, nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                    $rslt_usr_prfl = executaSql($sqluser,'i',[$iduser_post]);
                    foreach ($rslt_usr_prfl[1] as $listprfl) {
                        $imgprfl = $listprfl['foto_usuario'];
                        $username = $listprfl['nome_usuario'];
                    }
                    ?>
                    <div class="div-user">
                        <img src="<?= $imgprfl?>" class="img-perfil float-start" alt="imagina uma">
                        <a href="/public/dashboard/usuario/perfil.php?iduser=<?= $iduser_post?>"><?= $username?></a>
                    </div>
                    <?php
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post= ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    foreach ($midia[1] as $listimg) {
                        $img = $listimg['midia'];
                        ?>
                        <img src="<?= $img;?>" class="img-size rounded-start" alt="imagine uma">
                        <?php
                    }

                    $legenda = $row['legenda'];
                    $datapostagem = $row['data_postagem'];
                    $filtro = $row['filtro'];
                    ;
                    ?>
                            </div>
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title"><?= $legenda?></h5>
                            <p class="card-text"><?= $datapostagem?></p>
                        </div>
                    </div>
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
                                <p class="teste">texte</p>
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
                                ?><?
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>