<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    session_start();
    $case = $_REQUEST['case'];
    switch ($case) {
        case 'cadastro':
            $iduser = $_SESSION['id_usuario'];
            $conexao = conectarDB();
            $legenda = $_REQUEST['legenda'];
            $data_postagem = date("y-m-d h:i:s");
            $filtro = $_REQUEST["filtro"];
            // cadastro do post
            $sql_cad_post = "INSERT INTO tb_post VALUES (null, ?, ?, ?, ?);";
            $resultado = executaSql($sql_cad_post,'isss',[$iduser ,$legenda,$data_postagem,$filtro]);
            //select do post
            if ($resultado) {
                $sql_slct_post = "SELECT id_post FROM tb_post WHERE data_postagem = ? ";
                $select = executaSql($sql_slct_post,'s',[$data_postagem]);
                if (sizeof($select[1]) > 0) {
                    foreach ($select[1] as $row) {
                        $idpost = $row["id_post"];
                    }
                }                
                
                $pasta_banco = "/assets/img/";
                $pasta_servidor = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/"; 
                $ext_img = "." . pathinfo($_FILES['img_post']['name'], PATHINFO_EXTENSION);
                $nome_img = time() . md5(uniqid()) . rand(1,100);
                $arq_img_bd = $pasta_banco . $nome_img . $ext_img;
                $arq_img_server = $pasta_servidor . $nome_img . $ext_img;
                move_uploaded_file($_FILES['img_post']['tmp_name'], $arq_img_server);
                
                $sql_cad_img = "INSERT INTO tb_midia (midia, id_post) VALUES (?, ?) ";
                $result_img = executaSql($sql_cad_img,'si',[$arq_img_bd,$idpost]);
                if (!$result_img){
                   echo " <script>
                            window.alert('Erro no cadastro da img')
                            window.location.href='/index.php';
                        </script> ";
                }
                echo "<script>
                        window.alert('Deu certo')
                        window.location.href='/index.php';
                    </script>";
            } else {
                echo "<script>
                        window.alert('Erro no cadastro do post')
                        window.location.href='/index.php';
                    </script>";
            }
            break;
            case 'update':
                $iduser = $_SESSION['id_usuario'];
                $idpost = $_REQUEST['id'];
                $data_postagem = date("y-m-d h:i:s");
                $legenda = $_REQUEST['legenda'];
                $filtro = $_REQUEST['filtro'];
                $sql_upd_post = "UPDATE tb_post SET id_post = ?, id_usuario = ?, legenda = ?, data_postagem = ?, filtro = ?
                WHERE id_post = ?;";
                $result_upd_post = executaSql($sql_upd_post,'iisssi',[$idpost, $iduser, $legenda, $data_postagem, $filtro, $idpost]);
                if ($result_upd_post){
                    echo "<script>
                        window.alert('Deu certo')
                        window.location.href='/index.php';
                    </script>";  
                } else {
                    echo "<script>
                        window.alert('Deu errado')
                        window.location.href='/index.php';
                    </script>";
                }
                break;
            case 'delete':
                $idpost = $_REQUEST['id'];
                $sql_del = "DELETE FROM tb_post WHERE id_post = ?;";
                $result_del = executaSql($sql_del,'i',[$idpost]);
                if ($result_del) {
                    echo "<script>
                        window.alert('Deu certo')
                        window.location.href='/index.php';
                    </script>";  
                } else {
                    echo "<script>
                        window.alert('Deu errado')
                        window.location.href='/index.php';
                    </script>";  
                }
                break;

            

    }
?>