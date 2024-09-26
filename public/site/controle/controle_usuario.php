<?php
    include_once($_SERVER["DOCUMENT_ROOT"]."/bd/conexao.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/helpers/redirect.php");
    session_start();
    $case = $_REQUEST['case'];
    $tipologado = $_SESSION['tipo'];
    switch ($case) {
        // usuario
        case 'userinsert':
            $sql = "INSERT INTO tb_usuario (nome_usuario, senha_usuario, email_usuario, certificado, tipo)
            VALUES (?, ?, ?, ?, ?)";
            $nome = $_REQUEST['nome'];
            $senha = $_REQUEST['senha'];
            $email = $_REQUEST['email'];
            $certificado = $_REQUEST['certificado'];
            $tipo = $_REQUEST['tipo'];
            $result = executaSql($sql,'sssss',[$nome,$senha,$email,$certificado,$tipo]);
            if ($result) {
                $sql_iduser = "SELECT id_usuario FROM tb_usuario WHERE senha_usuario = ? AND email_usuario = ?";
                $iduser = executaSql($sql_iduser,'ss',[$senha, $email]);
                if (sizeof($iduser[1]) > 0) {
                    foreach ($iduser[1] as $row) {
                        $userid = $row["id_usuario"];
                    }
                    echo "<script>
                        window.location.href='/public/dashboard/usuario/form_filtro.php?case=insert&id=$userid';
                    </script>";
                }
            } else { 
                redirect('usuario', 'Deu algo de errado');
            }
            break;
        case 'update':
            $iduser = $_REQUEST['id'];
            $nome = $_REQUEST['nome'];
            $senha = $_REQUEST['senha'];
            $email = $_REQUEST['email'];
            $certificado = $_REQUEST['certificado'];
            $tipo = $_REQUEST['tipo'];
            $sql = "UPDATE tb_usuario SET id_usuario = ?, nome_usuario = ?,senha_usuario = ?,email_usuario = ?,certificado = ?,tipo = ?,foto_usuario = NULL
            WHERE id_usuario = ?";
            $result = executaSql($sql,'isssssi',[$iduser,$nome,$senha,$email,$certificado,$tipo,$iduser]);
            if ($result) {
                echo "<script>
                        window.location.href='/public/dashboard/usuario/form_filtro.php?case=update&id=$iduser';
                    </script>";
            } else {
                redirect('usuario', 'Deu algo de errado');
            }
            break;
        case 'delete':
            $iduser = $_REQUEST['id'];
            $sql = "DELETE FROM tb_usuario
            WHERE id_usuario = ?";
            executaSql($sql,'i',[$iduser]);
            if ($tipologado == 'X'){
                redirect('usuario', '100% Deletado');
            } else {
                session_destroy();
                redirect('usuario', '100% Deletado');
            }
            break;
        // filtro do usuario
        case 'filterinsert':
            $sql = "INSERT INTO tb_filtro (id_usuario, filtro)
            VALUES (?, ?),(?, ?),(?, ?);";
            $iduser = $_REQUEST['id'];
            $filtro1 = $_REQUEST['flt1'];
            $filtro2 = $_REQUEST['flt2'];
            $filtro3 = $_REQUEST['flt3'];
            $result = executaSql($sql,'isisis',[$iduser, $filtro1, $iduser, $filtro2, $iduser, $filtro3]);
            if ($result) {
                redirect('usuario', 'Cadastro finalizado');
            } else {
                redirect('usuario', 'Deu algo de errado');
            }
            break;
        case 'filterupdate':
            $sql_slct_filtros = "SELECT id_filtro FROM tb_filtro WHERE id_usuario = ?";
            $iduser = $_REQUEST['id'];
            $result_slct = executaSql($sql_slct_filtros,'i',[$iduser]);
            if (sizeof($result_slct[1]) > 0) {
                $filtro1 = $_REQUEST['flt1'];
                $filtro2 = $_REQUEST['flt2'];
                $filtro3 = $_REQUEST['flt3'];
                $filtros = [$filtro1,$filtro2,$filtro3];
                $sql_upd_filtro = 'UPDATE tb_filtro SET id_filtro = ?, id_usuario = ?, filtro = ?
                WHERE id_filtro = ?';
                $num = 0;
                foreach ($result_slct[1] as $row) {
                    $idfiltro = $row['id_filtro'];
                    executaSql($sql_upd_filtro,'iisi',[$idfiltro,$iduser,$filtros[$num],$idfiltro]);
                    $num += 1;
                }
                redirect('usuario', 'Atualizado');
                } else {
                    redirect('usuario', 'Deu algo de errado');
                }

            break;

        // login e logout
        case 'login' :
            session_start();
            $email = $_REQUEST['email'];
            $senha = $_REQUEST['senha'];
            $sql = "SELECT tipo, id_usuario FROM tb_usuario WHERE senha_usuario = ? AND email_usuario = ? ";
            $result = executaSql($sql,'ss',[$senha, $email]);
            if (sizeof($result[1]) > 0) {
                foreach ($result[1] as $row) {
                    $tipo = $row['tipo'];
                    $id = $row['id_usuario'];
                }
                $_SESSION['tipo'] = $tipo;
                $_SESSION['id_usuario'] = $id;
                redirect('pagina_inicial', 'Logado >:P');
            } else {
                redirect('login_err', 'Email ou Senha errado');
            }
            break;
        case 'logout':
            session_start();
            session_destroy();
            redirect('login_err', 'Deslogado :P');
            break;




    }
?>