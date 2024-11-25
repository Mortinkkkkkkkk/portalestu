<?php 
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/session.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
    session_start();
    if (isset($_REQUEST['iduser'])) {
        $idusuario = $_REQUEST['iduser'];
        $iduser = $_SESSION['id_usuario'];
    $tipologado = $_SESSION['tipo'];
    } else if (isset($_SESSION['id_usuario'])) {
        $idusuario = $_SESSION['id_usuario'];
        $iduser = $_SESSION['id_usuario'];
        $tipologado = $_SESSION['tipo'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/assets/css/posts.css">
    <link rel="stylesheet" href="/public/assets/css/inputs.css">
    <link rel="stylesheet" href="/public/assets/css/perfil.css">
</head>
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
        <div class="info-perfil">
        <a href="/public/index.php" class="casa"><ion-icon name="home" class="casinha"></ion-icon></a><br>
        <?php
            if ($foto != null) {
               ?>
               <img src="<?= $foto?>" alt="imagine uma">
               <? 
            } else if ($foto == null) {
                ?>
                <img class="info-perfil" src="/public/assets/img/perfil/pessoasemfoto.jpeg" alt="">
                <?
            }

        ?>
        <p><?= $nome?></p>
        <p><?= $email?></p>
        <p>
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
        </p>
        <p><a href="form_usuario.php?caso=update&id=<?= $idusuario?>">Alterar o perfil</a></p>
        <p><a href="form_filtro.php?case=update&id=<?= $idusuario?>">Alterar os filtros</a></p>
        </div>
        <div class="container-posts">
        <?php
        if ($tipo != "A") {
            $sql_pst_prfl = "SELECT * FROM tb_post WHERE id_usuario = ? ORDER BY fixado DESC, data_postagem DESC";
            $rslt_pst_prfl = executaSql($sql_pst_prfl,'i',[$idusuario]);
            if (sizeof($rslt_pst_prfl[1]) > 0 ){
                foreach ($rslt_pst_prfl[1] as $row_pst) {
                    ?><div class="post card mb-3" style="width: 30rem;">
                        <div class="row g-0">
                            <div class=" ">
                            <?                    
                    $idpost = $row_pst['id_post'];
                    $list_coment_post[] = $idpost; 
                    $iduser_post = $row_pst['id_usuario'];
                    $sqlimg = "SELECT  midia FROM tb_midia WHERE id_post = ?";
                    $midia = executaSql($sqlimg,'i',[$idpost]); 
                    if (sizeof($midia[1]) == 1){
                        foreach ($midia[1] as $listimg) {
                            $img = $listimg['midia'];
                            ?>
                            <img src="<?= $img;?>" class="img-size rounded-start" alt="imagine uma">
                            <?php
                
                        }
                        } else if (sizeof($midia[1]) > 1){
                            ?><div  id="carousel<?= $idpost?>"class="carousel carousel-dark slide">
                            <?php
                                $qtn_btn = 0;
                                for ($contador = 0;$contador == sizeof($midia);$contador++){
                                    ?>
                                       teste
                                    <?php 
                                    $qtn_btn++;
                                }    
                                ?>   
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
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $idpost?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $idpost?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                            </button>
                                </div>
                        <?
                    }
                    $legenda = $row_pst['legenda'];
                    $datapostagem = $row_pst['data_postagem'];
                    $filtro = $row_pst['filtro'];
                    $fixado = $row_pst['fixado'];
                    ?>
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title"><?= $legenda; ?></h5>
                            <p class="card-text"><?= $datapostagem?></p>
                        </div>
                    </div>
                        <div class="ion toggler">
                            <ion-icon name="chatbox-ellipses-outline" class="btn-coment" id="btn-coment<?=$idpost?>"></ion-icon>
                        </div>
                        <div class="ion refresh">
                            <ion-icon name="refresh-outline" class="btn-coment" id="refresh<?= $idpost?>"></ion-icon>
                        </div>
                        <div class="comentarios" id="comentarios<?= $idpost?>">
                    </div>   
                    <?php
                    if (isset($idusuario) && isset($tipologado)) {
                        if ($iduser_post == $idusuario || $tipologado == "X") {
                        ?>
                        <p class="card-text">Editar post: <a href="/controle/controle_post.php?case=delete&id=<?=$idpost?>">Deletar</a> <a href="/public/form_post.php?case=update&id=<?=$idpost?>">Atualizar</a></p>
                        <?php
                        } 
                        if ($fixado == 0) {
                            $txt_pin = "Fixar";
                            $icon_fix = "<ion-icon class='ion fix' name='bookmark-outline'></ion-icon>";
                        } else {
                            $txt_pin = "Desfixar";
                            $icon_fix = "<ion-icon class='ion fix' name='bookmark'></ion-icon>";
                        }
                        ?> <p class="card-text"><a href="/controle/controle_post.php?case=pin&id=<?= $idpost?>&func=<?= $txt_pin?>"><?= $icon_fix?></a></p>
                        <?php
                    }
                    ?>
                    </div>
                        </div>
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
        </div>
<script src="/public/assets/js/jquery-3.7.1.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $('document').ready(
        function() {
            // carregar os post pelo ajax
            let lista = [<?php foreach ($list_coment_post as $id_hider) {echo $id_hider . ",";}?>];
            for (let index in lista) {
                let btn_coment = "#btn-coment"+lista[index];
                let coment = "#comentarios"+lista[index];
                let refresh = "#refresh"+lista[index];
                let pagi_coment = '/helpers/comentarios.php?id_post='+lista[index];
                $(coment).load(pagi_coment)
                $(refresh).click(
                    function() {
                        $(coment).load(pagi_coment);
                    }
                );
                $('.form-comentario').submit(
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
        }
    )
</script>


</body>
</html>