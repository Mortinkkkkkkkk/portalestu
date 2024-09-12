<?php
    include_once($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
    $case = $_REQUEST['case'];
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
            break;
        // login e logout
        case 'login' :
            session_start();
            $email = $_REQUEST['email'];
            $senha = $_REQUEST['senha'];
            $sql = "SELECT `tipo`, `id_usuario` FROM `tb_usuario` WHERE `senha_usuario` = ? AND `email_usuario` = ? ";
            $result = executaSql($sql,'ss',[$senha, $email]);
            if (sizeof($result[1]) > 0) {
                foreach ($result[1] as $row) {
                    $tipo = $row['tipo'];
                    $id = $row['id_usuario'];
                }
                $_SESSION['tipo'] = $tipo;
                $_SESSION['id_usuario'] = $id;
                echo "<script>
                    window.alert('Logado >:P')
                    window.location.href='/index.php';
                </script>";
            } else {
                echo "<script>
                    window.alert('Deu errado')
                    window.location.href='/login.html';
                </script>";
            }
            break;
        case 'logout':
            session_start();
            session_destroy();
            echo "<script>
                    window.alert('Deslogado :P')
                    window.location.href='/login.html';
                </script>";
            break;




    }
?>