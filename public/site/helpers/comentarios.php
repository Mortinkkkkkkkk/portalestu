<?php
include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
session_start();
            $idpost = $_REQUEST['id_post'];
            $iduser = $_SESSION['id_usuario'];
            $tipologado = $_SESSION['tipo'];
            $sql_coment = "SELECT comentario,id_usuario, id_comentario, resposta_id FROM tb_comentario WHERE id_post = ? AND resposta_id IS NULL ORDER BY id_comentario, resposta_id";
            $resultcoment = executaSql($sql_coment,'i',[$idpost]);
                if (sizeof($resultcoment[1]) > 0) {
                    foreach ($resultcoment[1] as $listcoment){
                        $comentario = $listcoment['comentario'];
                        $iduser_coment = $listcoment['id_usuario'];
                        $id_comentario = $listcoment['id_comentario'];
                        $sql_comt_name_user = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                        $resultnomeusuer = executaSql($sql_comt_name_user,'i',[$iduser_coment]);
                            $nome_user_coment = $resultnomeusuer[1][0];
                            $list_form_id[] = $id_comentario; 
                            $user_coment = $nome_user_coment['nome_usuario'];
                                ?><div class="comentario" id="comentario<?=$id_comentario?>" ><p class="txt-coment"><?php
                                    echo $user_coment . ": " . $comentario ;?></p></div><?php
                                $sql_rspt = "SELECT * FROM tb_comentario WHERE resposta_id = ? ORDER BY id_comentario";
                                $rslt_rspt = executaSql($sql_rspt,'i',[$id_comentario]);
                                if (sizeof($rslt_rspt[1]) > 0) {
                                    foreach ($rslt_rspt[1] as $lst_rspt) {
                                    $resposta = $lst_rspt["resposta_id"];
                                    $cmnt_rspt = $lst_rspt["comentario"];
                                    $id_user_rspt = $lst_rspt['id_usuario'];
                                    // pesquisa pelo nome do usuario que respondeu
                                        $sql_nm_rspt = "SELECT nome_usuario FROM tb_usuario WHERE id_usuario = ?";
                                        $rslt_nm_rspt = executaSql($sql_nm_rspt,"i",[$id_user_rspt]);
                                        $lst_nm_rspt = $rslt_nm_rspt[1][0];
                                        $nm_rspt = $lst_nm_rspt["nome_usuario"];
                                    ?><div class="comentario resposta">
                                        <p class="txt-resposta"><?php

                                    // comentario:
                                    echo $nm_rspt ." Respondeu " . $user_coment  . ": " . $cmnt_rspt ;?></p></div><?php
  
                                    }
                                }
                            
                                ?>
                                <script>
                                        
                                        // enviar o form pelo ajax
                                        $("#form-resposta<?=$id_comentario?>").submit(
                                            function(sptun) {
                                            // sptun = Só Pra Ter Um Nome
                                            // preventDefault = Previne a alteracao do usuario após enviar 
                                            sptun.preventDefault();
                                                
                                            let form = $("#form-resposta<?=$id_comentario?>");
                                            
                                            // serialize() = pega os conteudos dos inputs do form e separa ele 
                                            $.ajax({
                                                type:"POST",
                                                url: "/controle/controle_comentario.php?case=comentario_resposta",
                                                data: form.serialize(),
                                                success: function(data){
                                                    alert('Responeder');
                                                }
                                            });
                                            
                                        }

                                    );
                    </script>
                                <div>
                                <form class="form-resposta" id="form-resposta<?=$id_comentario?>" action="/controle/controle_comentario.php?case=comentario_resposta" method="post">
                                <div class="div-input">
                                    <input class="input-ui" placeholder="Digite seu comentario" type="text"  name="resposta" id="txt-resposta<?=$id_comentario?>">
                                    <span class="input-border"></span>
                                </div>     
                                    <input type="hidden" name="id_user" value="<?= $iduser;?>">
                                    <input type="hidden" name="id_comentario" value="<?= $id_comentario;?>">
                                    <input type="hidden" name="id_post" value="<?= $idpost;?>">
                                    <input type="submit" value="responder" id="btn-enviar<?=$id_comentario?>">
                                </form>
                                </div>
                                <?php
                                if (isset($_SESSION) && isset($tipologado)) {
                                    if ($iduser == $iduser_coment || $tipologado == "X") {
                                        ?>
                                            <p><a href="/controle/controle_comentario.php?case=deletar&id=<?=$id_comentario?>"><ion-icon style="font-size: 30px; color: black;" name="trash"></ion-icon></a></p></div>
                                            <?php
                                    }
                                }
                            }

                            
                    } else {
                           ?>
                            <div class="comentario">
                                <p class="txt-coment">Esse Post não tem comentario</p>
                            </div>
                           <?php
                        };
                    ?>
                            </div>
                        </div>
                        <script>                                    
                            // enviar o form pelo ajax
                            $("#form-comentario<?=$idpost?>").submit(
                                function(sptun) {
                                // sptun = Só Pra Ter Um Nome
                                // preventDefault = Previne a alteracao do usuario após enviar 
                                sptun.preventDefault();
                                                
                                let form = $("#form-comentario<?=$idpost?>");
                                            
                                // serialize() = pega os conteudos dos inputs do form e separa ele 
                                $.ajax({
                                    type:"POST",
                                    url: "/controle/controle_comentario.php?case=comentario_post",
                                    data: form.serialize(),
                                    success: function(data){
                                            alert('Comentado');
                                            }
                                        });
                                            
                                    }

                                );
                            
                    </script>
                    <form class="form-comentario" id="form-comentario<?=$idpost?>" action="/controle/controle_comentario.php?case=comentario_post" method="post">
                        <label for="comentario">Comente:</label>
                        <div class="div-input">
                            <input class="input-ui" placeholder="teste" type="text" name="comentario">
                            <span class="input-border"></span>
                        </div>
                        <input type="hidden" name="id_post" value="<?echo $idpost?>">
                        <input type="hidden" name="id_user" value="<?= $iduser;?>">
                        <input type="submit" value="enviar">
                    </form>   