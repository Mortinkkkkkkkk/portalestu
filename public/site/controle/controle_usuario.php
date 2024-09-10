<?php
    include_once($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
    $case = $_REQUEST['caso'];
    switch ($case) {
        // usuario
        case 'userinsert':
            $sql = "INSERT INTO `tb_usuario` (`nome_usuario`, `senha_usuario`, `email_usuario`, `certificado`, `tipo`)
            VALUES (?, ?, ?, ?, ?)";
            $nome = $_REQUEST['nome'];
            $senha = $_REQUEST['senha'];
            $email = $_REQUEST['email'];
            $certificado = $_REQUEST['certificado'];
            $tipo = $_REQUEST['tipo'];
            $result = executaSql($sql,'sssss',[$nome,$senha,$email,$certificado,$tipo]);
            if ($result) {
                $sql_iduser = "SELECT `id_usuario` FROM `tb_usuario` WHERE `senha_usuario` = ? AND `email_usuario` = ?";
                $iduser = executaSql($sql_iduser,'ss',[$senha, $email]);
                if (sizeof($iduser[1]) > 0) {
                    foreach ($iduser[1] as $row) {
                        $userid = $row["id_usuario"];
                    }
                    echo "<script>
                    window.location.href='/form_filtro.php?id=$userid';
                    </script>";
                }
            } else { 
                echo "<script>
                        window.alert('Deu errado')
                        window.location.href='/usuario.php';
                    </script>";
            }
            break;
        // filtro do usuario
        case 'filterinsert':
            $sql = "INSERT INTO `tb_filtro` (`id_usuario`, `filtro`)
            VALUES (?, ?),(?, ?),(?, ?);";
            $iduser = $_REQUEST['id'];
            $filtro1 = $_REQUEST['flt1'];
            $filtro2 = $_REQUEST['flt2'];
            $filtro3 = $_REQUEST['flt3'];
            $result = executaSql($sql,'isisis',[$iduser, $filtro1, $iduser, $filtro2, $iduser, $filtro3]);
            if ($result) {
                echo "<script>
                        window.alert('Deu certo')
                         window.location.href='/usuario.php';
                    </script>";
            } else {
                echo "<script>
                        window.alert('Deu errado')
                        window.location.href='/usuario.php';
                    </script>";
            }



    }
?>