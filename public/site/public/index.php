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
    <link rel="stylesheet" href="/public/assets/css/posts.css">
    <link rel="stylesheet" href="/public/assets/css/inputs.css">
    <script src="/public/assets/js/jquery-3.7.1.min.js"></script>
</head>
<body class="teste">
<header>
    <div class="logo-container">
            <img src="/public/assets/img/logo.png" alt="Logo Universo Estudantil" class="logo">
            <h1 class="title-logo">Universo Estudantil</h1>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Últimas notícias</a></a>
                </li>
                <li><a href="index.php">Enem</a>
                <!-- Menu com várias opções e submenus -->
                    <ul class="submenu">
                        <li><a href="/public/Simulado.html">Simulados</a></li>
                        <li><a href="/public/index.php?fltPsq=dica">Dicas de Estudo</a></li>
                        <li><a href="/public/index.php?fltPsq=resultvest">Resultado</a></li>
                    </ul>
                </li>
                <li><a href="index.php">Materia</a>
                    <ul class="submenu">
                        <li><a href="/public/index.php?fltPsq=mat">Matemática</a></li>
                        <li><a href="/public/index.php?fltPsq=lin">Linguagens</a></li>
                        <li><a href="/public/index.php?fltPsq=cienat">Ciências da Natureza</a></li>
                        <li><a href="/public/index.php?fltPsq=ciehum">Ciências Humanas</a></li>
                        <li><a href="/public/index.php?fltPsq=red">Redação</a></li>
                    </ul>
                </li>
                <li><a href="index.php">Contato</a>
                    <ul class="submenu">
                        <li><a href="#fale-conosco">Fale Conosco</a></li>
                        <li><a href="#faq">Perguntas Frequentes (FAQ)</a></li>
                    </ul>
                </li>
                <div class="container-nav-icons">
                <?php 
                    if(!isset($iduser)) {
                ?>
                <a href="/index.html"><ion-icon class="nav-icons" name="log-in"></ion-icon></a>
                <?php } else {?>
                <a href="/controle/controle_usuario.php?case=logout"> <ion-icon class="nav-icons" name="log-out-outline"></ion-icon></a>
                <?}?>
                <?php 
                    if (!isset($iduser)){
                       ?><p><a href="/public/dashboard/usuario/form_usuario.php?caso=insert"><ion-icon class="nav-icons" name="person-add"></ion-icon></a></p><?
                    } else if (isset($tipologado) && $tipologado == "X") {?>
                    <a href="/public/dashboard/usuario/index.php"><ion-icon class="nav-icons" name="list"></ion-icon></a>
                    <?php }
                        if (isset($iduser)) {
                    ?>
                    <a href="/public/dashboard/usuario/perfil.php"><ion-icon class="nav-icons" name="people"></ion-icon></a>
                    <?}?>
                </div>
            </nav>

                
    </header>
    <h3>Noticias:</h3>
        <?php
            if (isset($tipologado) && $tipologado != "A") {
            ?><a href="/public/form_post.php?case=insert"><ion-icon class="ion" name="newspaper-outline"></ion-icon></a><?php
            }
            ?>
            <form action="/public/index.php" method="post">
                <div class="div-input">
                    <label for="pesquisa">Procurar:</label>
                    <input class="input-ui" type="text" name="pesquisa" id="100">
                    <span class="input-border"></span>
                </div>
                <select name="opcao_pesq" id="">
                    <option value="legenda">Legenda</option>
                    <option value="data">Data</option>
                    <option value="filtro">Filtro</option>
                </select>
                <input class="btn btn-secondary" type="submit" value="Pesquisar">
            </form>
            <?php
            if (isset($_REQUEST['pesquisa'])) {
             // Processamento da pesquisa, filtrando posts no banco de dados
                ?>
                <a href="/public/index.php"><ion-icon class="ion" name="arrow-back-outline"></ion-icon></a>
                <?php
                // coleta o valor do campo de pesquisa
                $pesquisa ="%" . $_REQUEST['pesquisa'] . "%";
                // coleta a opção pesquisada
                $opcao_pesq = $_REQUEST['opcao_pesq'];
                // troca o sql de acordo com a opção pesquisada pelo usuario
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
                    case 'cie':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'ciencia humanas' OR filtro = 'ciencias naturais' ORDER BY data_postagem DESC";
                        break;
                    case 'dica':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'dicasdeestudo' ORDER BY data_postagem DESC";
                        break;
                    case 'resultvest':
                        $sql = "SELECT * FROM tb_post WHERE filtro = 'resultadovestibular' ORDER BY data_postagem DESC";
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
            ?><div class="container-posts"><?php   
            if (!$nada) {
                foreach ($rslt_pesq[1] as $row) {
                    // Exibe os posts encontrados
                    $iduser_post = $row['id_usuario'];
                    $idpost = $row['id_post'];
                    $list_coment_post[] = $idpost; 
                    $sqluser = "SELECT foto_usuario, nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                    $rslt_usr_prfl = executaSql($sqluser,'i',[$iduser_post]);
                    ?>
                    <div id="card-id<?= $idpost?>" class="post card mb-3" style="width: 30rem;">
                        <div class="row g-0">
                            <div class=""><?
                    foreach ($rslt_usr_prfl[1] as $listprfl) {
                        $imgprfl = $listprfl['foto_usuario'];
                        $username = $listprfl['nome_usuario'];
                    }
                    if ($imgprfl == null) {
                        ?>
                            <div class="div-user">
                                <img src="/public/assets/img/perfil/pessoasemfoto.jpeg" class="img-perfil float-start" alt="imagina uma">
                                <a class="username" href="/public/dashboard/usuario/perfil.php?iduser=<?= $iduser_post?>"><?= $username?></a>
                            </div>
                        <?php
                    } else if ($imgprfl != null) {
                    ?>
                    <div class="div-user">
                        <img src="<?= $imgprfl?>" class="img-perfil float-start" alt="imagina uma">
                        <a href="/public/dashboard/usuario/perfil.php?iduser=<?= $iduser_post?>"><?= $username?></a>
                    </div>
                    <?php
                    }
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post= ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    if (sizeof($midia[1]) == 1){
                    foreach ($midia[1] as $listimg) {
                        $img = $listimg['midia'];
                        ?>
                        <img src="<?= $img;?>" class="img-size rounded-start" alt="imagine uma">
                        <?php
            
                    }
                    } else if (sizeof($midia[1]) > 1){
                        ?><div id="carousel<?=$idpost?>"class="carousel slide">
                            <div class="carousel-inner">
                            <?php
                            $num = 1;
                            foreach ($midia[1] as $listimg) {
                                $img = $listimg['midia'];
                                if ($num == 1) {
                                ?>
                                <div class="carousel-item active">
                                    <img src="<?=$img?>" class="img-size" alt="imagine uma">
                                </div>
                                <?php
                                } else if($num > 1) {
                                    ?>
                                <div class="carousel-item">
                                    <img src="<?=$img?>" class="img-size" alt="imagine uma">
                                </div>
                                <?php
                            }
                            $num++;
                            }
                        ?>        
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?=$idpost?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?=$idpost?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                        </button>
                            </div>
                    <?
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
                        <div class="toggler">
                            <ion-icon name="chatbox-ellipses-outline" class="btn-coment" id="btn-coment<?=$idpost?>"></ion-icon>
                        </div>
                        <div class="refresh">
                            <ion-icon name="refresh-outline" class="btn-coment" id="refresh<?= $idpost?>"></ion-icon>
                        </div>
                        <div class="comentarios" id="comentarios<?= $idpost?>">
                    </div>   
                </div>
            </div>
        </div>
                
                    
<?php
$sql_coment = "SELECT id_comentario FROM tb_comentario WHERE id_post = ? ORDER BY id_comentario, resposta_id";
$resultcoment = executaSql($sql_coment,'i',[$idpost]);
    if (sizeof($resultcoment[1]) > 0) {
        foreach ($resultcoment[1] as $listcoment){
            $id_comentario = $listcoment['id_comentario'];
            $list_form_id[] = $id_comentario;
                }
            }
        }
            } else  {
                ?>
                <div class='post'>
                    <p>Nenhum Post Encontrado</p>
                </div>
                <?php
                
            }
        
        ?>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Funções de interatividade para comentários, exibição e atualização
    let listform = [<?php foreach($list_form_id as $id_form){echo $id_form.",";}?>];
    $('document').ready(
        function() {
            // carregar os post pelo ajax
            let lista = [<?php foreach ($list_coment_post as $id_hider) {echo $id_hider . ",";}?>];
            for (let index in lista) {
                let btn_coment = "#btn-coment"+lista[index];
                let coment = "#comentarios"+lista[index];
                let refresh = "#refresh"+lista[index];
                let form_coment = "#form-comentario"+lista[index];
                let pagi_coment = '/helpers/comentarios.php?id_post='+lista[index];
                $(coment).load(pagi_coment)
                $(refresh).click(
                    function() {
                        $(coment).load(pagi_coment);
                    }
                );
                $(form_coment).submit(
                    function(){
                        $(coment).load(pagi_coment);
                    }
                );
                $(".form-resposta").submit(
                    function(){
                        $(coment).load(pagi_coment)
                    }
                )
                


                // esconde a div do comentario
                $(coment).hide()
                $(btn_coment).click(
                    function() {

                        $(coment).toggle(300);
                    }
                );
            }
            
            
        },
    );
</script>
</body>
</html>