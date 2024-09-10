<?php
    include_once($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
    $case = $_REQUEST['caso'];
    switch ($case) {
        case 'insert':
            $sql = "INSERT INTO `tb_usuario` (`nome_usuario`, `senha_usuario`, `email_usuario`, `certificado`, `tipo`)
            VALUES (?, ?, ?, ?, ?)";
            $nome = $_REQUEST['nome'];
            $senha = $_REQUEST['senha'];
            $email = $_REQUEST['email'];
            $certificado = $_REQUEST['certificado'];
            $tipo = $_REQUEST['tipo'];
            $result = executaSql($sql,'sssss',[$nome,$senha,$email,$certificado,$tipo]);
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
    }
?>