<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/bd/conexao.php");
    $case = $_REQUEST['case'];
    switch ($case) {
        case 'cadastro':
            $conexao = conectarDB();
            $img = $_REQUEST['imagem'];
            $legenda = $_REQUEST['legenda'];
            $data_postagem = date("y-m-d h:i:s");
            $filtro = $_REQUEST["filtro"];
            // cadastro do post
            $sql_cad_post = "INSERT INTO `tb_post` (`legenda`, `data_postagem`, `filtro`)
            VALUES (?, ?, ?);";
            $resultado = executaSql($sql_cad_post,'sss',[$legenda,$data_postagem,$filtro]);
            //select do post
            if ($resultado) {
                $sql_slct_post = "SELECT id_post FROM tb_post WHERE data_postagem = ? ";
                $stmt_slct_post = mysqli_prepare($conexao,$sql_slct_post);
                mysqli_stmt_bind_param($stmt_slct_post,'s',$data_postagem);
                mysqli_stmt_execute($stmt_slct_post);
                mysqli_stmt_bind_result($stmt_slct_post, $id_post);
                mysqli_stmt_store_result($stmt_slct_post);
                //cadastro da img
                while (mysqli_stmt_fetch($stmt_slct_post)){
                    $idpost = $id_post;
                }
                $sql_cad_img = "INSERT INTO tb_midia (midia, id_post) VALUES (?, ?) ";
                $result_img = executaSql($sql_cad_img,'si',[$img,$idpost]);
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
            
            

    }
?>