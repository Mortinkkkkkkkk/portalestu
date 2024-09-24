<?php 
    function redirect($local,$mensagem,) {
        switch ($local){
            case 'pagina_inicial':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/index.php';
                </script>";
                break;
            case 'session':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/index.php';
                </script>";
                break;
            case 'usuario':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/public/dashboard/usuario/index.php';
                </script>";
                break;
            case 'login_err':
                echo "<script>
                    window.alert('$mensagem');
                    window.location.href='/index.php';
                </script>";
                break;


        }
    }

?>
