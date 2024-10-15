<?php 
    include_once('redirect.php');
        function sessionPermit($usuario) {
        switch ($usuario) {
            case "aluno":
                if (!isset($_SESSION['id_usuario'])) {
                    redirect('login_err','Essa pagina precisa de um login');
                }
                break;
            case 'professor':
                if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'P' && $_SESSION['tipo'] != 'X') {
                    redirect('pagina_inicial','Somente Professores acessam essa pagina');
                }
                break;
            case 'admim':
                if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 'X') {
                    redirect('pagina_inicial','Somente Admins acessam essa pagina');
                }
                break;

        }
    }

?>